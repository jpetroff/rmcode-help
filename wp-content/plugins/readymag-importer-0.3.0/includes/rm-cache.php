<?php

define( 'RM_CACHE_MODULE', true );

// return true to serve static post,
// return false to continue to default WP query
function handle_post_status($status, $post_id) {
	if ($status == 'publish') return true;

	if (
			function_exists( 'current_user_can' ) &&
		(	$status == 'pending' || $status == 'draft' || $status == 'future' 	) &&
		(	current_user_can('edit_posts') || current_user_can('edit_pages') 	)
	)
		return true;

	if (
			function_exists( 'current_user_can' ) &&
			$status == 'private' &&
		(	current_user_can('read_private_posts') || current_user_can('read_private_pages')	)
	)
		return true;


	if (
		function_exists( 'post_password_required' ) &&
		$status == 'protected' &&
		!post_password_required($post_id)
	)
		return true;

	return false;
}

// returns content-type string
function is_file_request( $path ) {
	if( $path == '' )
		return false;

	preg_match('/.*\.([a-zA-Z0-9]{1,4})$/', $path, $matches);
	$extension = $matches[1];
	if (!$extension) {
		return FALSE;
	}
	else {
		switch($extension) {
			case 'jpg':
			case 'jpeg':
				return "Content-Type: image/jpeg; charset=utf-8";
			case 'js':
				return "Content-Type: text/javascript; charset=utf-8";
			case 'css':
				return "Content-Type: text/css; charset=utf-8";
			case 'png':
				return "Content-Type: image/png; charset=utf-8";
			case 'gif':
				return "Content-Type: image/gif; charset=utf-8";
			case 'woff':
				return "Content-Type: application/font-woff; charset=utf-8";
			case 'woff2':
				return "Content-Type: application/font-woff2; charset=utf-8";
			case 'svg':
				return "Content-Type: image/svg+xml; charset=utf-8";
		}
	}
	return false;
}

function rm_importer_parse_request() {
	$result = array(
		'action' => 'pass',
		'type_header' => 'Content-Type: text/html; charset=utf-8',
		'file' => NULL,
		'file_exists' => false,
		'type' => NULL
	);

	$arr_req = parse_url( $_SERVER['REQUEST_URI'] );

	$req_uri = $arr_req['path'] ? urldecode($arr_req['path']) : '';
	$req_anchor = $arr_req['anchor'] ? urldecode($arr_req['anchor']) : '';
	$req_query_str = $arr_req['query'] ? urldecode($arr_req['query']) : '';

	if ($req_query_str != '') {
		parse_str($req_query_str, $req_query);
		$req_query_str = '?'.$req_query_str;
	}

	if( function_exists('static_cache_get_rm_index') ) {
		$rm_project_index = static_cache_get_rm_index();
	} else {
		$rm_project_index = get_option('rm-imported-projects-index');
	}

	if( function_exists('static_cache_get_rm_permalink_array') ) {
		$permalink_obj = static_cache_get_rm_permalink_array();
	} else {
		$permalink_obj = parse_url($rm_project_index['&sample_permalink']);
	}

	$permalink_path_pattern = '#^'.rtrim(str_replace( array( '%pagename%', '%postname%' ), '([^/]+)', $permalink_obj['path']), '/') . '(/(.*)?)?#i';

	$check_uri = preg_match($permalink_path_pattern, $req_uri, $permalink_matches);
	$rm_post_name = $permalink_matches[1];
	$rm_post_path = $permalink_matches[2];

	if ($rm_post_name && isset($rm_project_index[$rm_post_name])) {

		$post = $rm_project_index[$rm_post_name];
		$result['handle_status'] = handle_post_status($post['status'], $post['post_id']);

		/*
			 ===============
			 REDIRECTS
			 ===============
		*/

		if ($rm_post_path == '') {
			$canonical = $permalink_obj['scheme'] . "://" . $permalink_obj['host'] . $req_uri . '/' . $req_query_str . $req_anchor;
			$result['action'] = 'redirect';
			$result['type_header'] = "Location: {$canonical}";
			$result['redirect_link'] = $canonical;
			return $result;
		}

		// is it a page permalink? check for trailing slash
		// yoursite.com/rm-post/page-permalink/ → yoursite.com/rm-post/page-permalink
		if($post['has_permalinks'] && preg_match("|^/[^/]+/$|i", $rm_post_path)) {
			$canonical = $permalink_obj['scheme'] . "://" . $permalink_obj['host'] . rtrim($req_uri, '/') . $req_query_str . $req_anchor;
			$result['action'] = 'redirect';
			$result['type_header'] = "Location: {$canonical}";
			$result['redirect_link'] = $canonical;
			return $result;
		}

		/*
			 ======================
			 PROCESSING FILE TYPES
			 ======================
		*/

		$projects_root = WP_CONTENT_DIR . '/rm-projects';
		$current_root = $projects_root . '/' . $post['folder'] . '/';

		$is_fragment = isset($req_query['_escaped_fragment_']);

		$rm_post_path = trim($rm_post_path, '/');

		$result['action'] = 'try_rm';

		$check_file = is_file_request($rm_post_path);
		if( $check_file !== false ) {

			// handle file request
			$result['type'] = 'file';
			$result['file'] = $current_root.trim($rm_post_path, '/');
			$result['type_header'] = $check_file;
			$result['file_exists'] = rm_file_exists($result['file']);

		} else if ($is_fragment) {

			$fname = '1_patched.html';
			if (!$post['has_permalinks']) {
				$fname = '___single.html';
			} else if ($rm_post_path != '' && preg_match('|^[^/]+$|', $rm_post_path) ) {
				$fname = $rm_post_path . '_patched.html';
			}

			// handle prerendered snippet request
			$result['type'] = 'snippet';
			$result['file'] = $current_root.'snippets/'.$fname;
			$result['file_exists'] = rm_file_exists($result['file']);

		} else if (
				$rm_post_path == '' ||
			(	$post['has_permalinks'] && preg_match('|^[^/]+$|', $rm_post_path) )
		) {

			// handle pages snippet request
			$result['type'] = 'page';
			$result['file'] = $current_root.'index_patched.html';
			$result['file_exists'] = rm_file_exists($result['file']);

		}
	}

	return $result;
}

function send_file_phase1( $route ) {

	if( $route['action'] == 'redirect' ) {
		header( "X-Served-By: rm-importer-plugin-advanced-cache" );
		header($route['type_header'],true,301);
		exit;
	}

	if( $route['action'] == 'pass' )
		return;

	$file_type = $route['type'];
	$try_file = $route['file'];
	$file_exists = $route['file_exists'];

	if(!$file_exists && $file_type == 'file') {
		header( "X-Served-By: rm-importer-plugin-advanced-cache" );
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		exit;
	}

	if(
		(	$route['handle_status'] == true ) ||
		(	$file_type == 'file' && !preg_match('|build/json.js&|i', $try_file) )
	) {
		$local_mod_time = gmdate("D, d M Y H:i:s",filemtime( $try_file )).' GMT';

		header( $route['type_header'] );
		header( "X-Served-By: rm-importer-plugin-advanced-cache" );
		header( "Vary: Accept-Encoding, Cookie" );
		header( "Cache-Control: max-age=3, must-revalidate" );
		header( "Last-Modified: " . $local_mod_time );

		readfile($try_file);
		exit;
	} else {

		// at this point we know it's a readymag URI
		// but we cannot serve it
		// so we pass it to phase 2
		define( 'RM_CACHE_REQUIRE_PHASE2', true );

	}

}

function send_file_phase2( $route, &$wp ) {

	if( $route['action'] == 'redirect' ) {
		$wp->query_vars['is_rm_project'] = true;
		wp_redirect($route['canonical']);
		exit;
	}

	$file_type = $route['type'];
	$try_file = $route['file'];
	$file_exists = $route['file_exists'];

	if( $route['action'] == 'pass' || ($route['handle_status'] == false && $file_type == 'page') )
  		return;

	$wp->query_vars['is_rm_project'] = true;

	if(!$file_exists && $file_type == 'file') {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		exit;
	}

	if( $route['handle_status'] == true && $file_exists ) {

		$wp->query_vars['rm_route_object'] = $route;
		unset($wp->query_vars['error']);

		add_filter('wp_headers', 'rm_custom_headers', 10, 2);
		function rm_custom_headers($headers, $wp) {
			$_route = $wp->query_vars['rm_route_object'];
			$headers['Content-Type'] = str_replace('Content-Type: ', '', $_route['type_header']);
			$headers['Last-Modified'] = gmdate("D, d M Y H:i:s",filemtime( $_route['file'] )).' GMT';
			return $headers;
		}

		$wp->send_headers();

		readfile($try_file);
		do_action('shutdown');
		exit;
	}
}