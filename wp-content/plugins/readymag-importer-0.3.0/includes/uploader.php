<?php

global $rm_state_array;

function _add_backbone_fix($path, $pushState = false) {
	global $rm_state_array;

	if (!file_exists($path)) {
		$rm_state_array['warning'][] = array(
			'project' => -1,
			'caption' => 'Missing '.basename($path),
			'details' => '_add_backbone_fix() at '.$path
		);
		return false;
	}

	$content = file_get_contents($path);

	if ($content == false) {
		$rm_state_array['warning'][] = array(
			'project' => 0,
			'caption' => 'Empty '.basename($path),
			'details' => '_add_backbone_fix() at '.$path
		);
		return false;
	}

	$pattern = "/\/\* RM WP BACKBONE ROUTER PATCH BEGIN \*\/(.*)\/\* RM WP BACKBONE ROUTER PATCH END \*\//sU";

	$has_patch = preg_match($pattern, $content, $matches);

	if ($has_patch && !$pushState) {
		$content = str_replace($matches[0],'',$content);
	} else if (!$has_patch && $pushState) {
		$injection = '!function(){_.extend(Backbone.history,{navigate:function(t,e){if(!Backbone.History.started)return!1;e&&e!==!0||(e={trigger:!!e});var i=this.root+(t=this.getFragment(t||""));if(t=t.replace(Backbone.pathStripper,""),this.fragment!==t){if(this.fragment=t,this._hasPushState)this.history[e.replace?"replaceState":"pushState"]({},document.title,i);else{if(!this._wantsHashChange)return this.location.assign(i);this._updateHash(this.location,t,e.replace),this.iframe&&t!==this.getFragment(this.getHash(this.iframe))&&(e.replace||this.iframe.document.open().close(),this._updateHash(this.iframe.location,t,e.replace))}return e.trigger?this.loadUrl(t):void 0}}})}();';
		$prefix = "/* RM WP BACKBONE ROUTER PATCH BEGIN */";
		$suffix = "/* RM WP BACKBONE ROUTER PATCH END */";
		$content .= $prefix.$injection.$suffix;
	}

	if (file_put_contents($path, $content) == false) {
		$rm_state_array['warning'][] = array(
			'project' => 0,
			'caption' => 'Unable to write '.basename($path),
			'details' => '_add_backbone_fix() at '.$path
		);
		return false;
	};
	return true;
}

function create_patched_index($path) {
	global $rm_state_array;

	if (!file_exists($path)) {
		$rm_state_array['error'][] = array(
			'project' => -1,
			'caption' => 'Missing index.html',
			'details' => 'create_patched_index() at '.$path
		);
		return false;
	}
	$index = file_get_contents($path.DIRECTORY_SEPARATOR.'index.html');
	if (file_put_contents($path.DIRECTORY_SEPARATOR.'index_patched.html', $index) == false) {
		$rm_state_array['error'][] = array(
			'project' => -1,
			'caption' => 'Unable to create index_patched.html',
			'details' => 'create_patched_index() at '.$path
		);
		return false;
	}
	return true;
}

function update_meta_tags($project) {
	$path = $project['full_path'];
	$root_link = '/'.$project['permalink'].'/';
	$push_state = $project['pushstate'];


	$index = rm_file_get_contents($path.DIRECTORY_SEPARATOR.'index_patched.html');

	$html = new DOMDocument();
	@$html->loadHTML($index);
	$html->preserveWhiteSpace = true;
	$head = $html->getElementsByTagName('head')->item(0);
	$canonical_link = untrailingslashit(home_url()).$root_link;

	$script_config = $html->createElement('script');
	$script_text = "(function(RM, undefined) {RM.config = {root:'".$root_link."',pushState:".($push_state ? 'true' : 'false')."}})(RM);";
	$script_config->appendChild($html->createTextNode($script_text));
	$script_config->setAttribute('id', 'rm-download-source-inline-config');

	$async_script = $html->createElement('script');
	$async_script->setAttribute('id', 'rm-download-source-async-json-load');
	$async_script->setAttribute('src', 'build/json.js');

	$insert_config = true;
	$insert_async_json_load = true;

	$remove_nodes = [];
//	if ($path == '/Users/john/rmsource/wordpress/wp-content/rm-projects/Readymag - Test Export Project')
//		var_dump($html);
	foreach($head->childNodes as $node) {
		if($node->tagName == 'link' && $node->getAttribute('rel') == 'next') {
			$remove_nodes[] = $node;
			continue;
		}
		if ($node->tagName == 'link' && $node->getAttribute('rel') == 'canonical') {
			$remove_nodes[] = $node;
			continue;
		}
		if ($node->tagName == 'meta' && $node->getAttribute('property') == 'og:url') {
			$node->setAttribute('content', $canonical_link);
			continue;
		}
		if ($node->tagName == 'meta' && $node->getAttribute('property') == 'og:image') {
			$_link = ___a( $project['meta']['wp_screenshot'][0], $canonical_link.$project['meta']['screenshot'] );
			if($_link != '') {
				$node->setAttribute('content', $_link);
			} else {
				$remove_nodes[] = $node;
			}
			continue;
		}
		if ($node->tagName == 'link' && $node->getAttribute('rel') == 'publisher') {
			$remove_nodes[] = $node;
			continue;
		}
		if ($node->tagName == 'script' && $node->getAttribute('id') == 'rm-download-source-inline-config') {
			$node->nodeValue = $script_config->nodeValue;
			continue;
		}
		if ($node->tagName == 'script' && $node->getAttribute('id') == 'rm-download-source-async-json-load') {
			$insert_async_json_load = false;
			continue;
		}
		if ($insert_async_json_load && $node->tagName == 'script' && $node->getAttribute('src') == 'build/js/viewer-local_vendor.js') {
			$head->insertBefore($async_script, $node);
			continue;
		}
	}

	foreach($remove_nodes as $node) {
		$head->removeChild($node);
	}

	rm_file_put_contents($path.'/index_patched.html', $html->saveHTML());

	// rebuild html snippets
	update_snippets($project);

	_add_backbone_fix($path.'/build/js/viewer-local_vendor.js', $push_state);
}

function update_project_json($root, &$meta) {
	global $rm_state_array;

	$success = true;
	$index_name = $root.'/index_patched.html';
	$json_script = $root.'/build/json.js';

	$meta = array();

	$lines = file($index_name);
	$fd = fopen($index_name, 'w');

	$json_pattern = '|window.ServerData *= *(.*);|i';

	$config_script_pattern = '|<script [^>]*src=[\'"]?config.js|i';
	$config_script_replace = '<script id="rm-download-source-inline-config" type="text/javascript"></script>'."\n";

	$index_json_str = '';
	$external_json_str = '';

	// process index_patched.html line by line
	foreach( (array)$lines as $line ) {

		if(	preg_match($json_pattern, $line, $json_matches) == 1 ) {

			if( ! _process_project_json( $meta, $index_json_str, $external_json_str, $json_matches[1] ) )
				return false;

			$line = "window.ServerData = {$index_json_str};\n";
			rm_file_put_contents($json_script, "typeof magJsonCallback == 'function' && magJsonCallback({$external_json_str});");

		}

		if ( preg_match($config_script_pattern, $line) ) {

			$line = $config_script_replace;

		}

		_fix_missing_custom_fonts_css($line);

		fputs($fd, $line);

	}
	fclose($fd);

	if( $external_json_str == '' ) {
		$rm_state_array['error'][] = array(
			'project' => -1,
			'caption' => 'Unable to match JSON from index_patched.html',
			'details' => 'update_project_json() at '.$root
		);
		return false;
	}

	return true;
}

function _process_project_json( &$meta, &$index_json_str, &$external_json_str, $match ) {
	global $rm_state_array;
	$json_str = preg_replace_callback('/\\\\x([0-9A-F]{2})/', function ($m) { return chr(hexdec($m[1])); },  $match );

	$json_obj = json_decode($json_str);
	if (!$json_obj) {
		$rm_state_array['error'][] = array(
			'project' => -1,
			'caption' => 'Unable to decode JSON in index_patched.html',
			'details' => 'update_project_json() at '.$root
		);
		return false;
	}

	$meta = array(
			'title' => $json_obj->mags->mag->title,
			'num_id' => $json_obj->mags->mag->num_id,
			'description' => $json_obj->mags->mag->description,
			'uri' => $json_obj->mags->mag->uri,
			'pages' => array()
		);

	foreach ($json_obj->mags->mag->pages as $page) {
		array_push($meta['pages'], array(
			'uri' => $page->uri,
			'num' => $page->num,
			'screenshot' => $page->screenshot,
			'seo_title' => $page->seo->title,
			'seo_description' => $page->seo->description,
			'og_title' => $page->custom_shares->title,
			'og_description' => $page->custom_shares->description,
			'og_image' => $page->custom_shares->image
		));
	}

	// save full json to json.js file
	$external_json_str = json_encode($json_obj->mags->mag);
	if (!$external_json_str) {
		$rm_state_array['error'][] = array(
			'caption' => 'Unable to save full JSON to json.js',
			'details' => 'update_project_json() at '.$root
		);
		return false;
	}

	$meta_short = $json_obj;
	unset($meta_short->mags->mag->pages);

	$index_json_str = json_encode($meta_short);
	if (!$index_json_str) {
		$rm_state_array['error'][] = array(
			'caption' => 'Unable to put back ‘short JSON’ in index_patched.html',
			'details' => 'update_project_json() at '.$root
		);
		return false;
	}

	return true;
}

function get_tmp_upload_dir() {
	return WP_CONTENT_DIR.'/rm-projects/_tmp_upload';
}

function get_tmp_unpack_dir() {
	return WP_CONTENT_DIR.'/rm-projects/_tmp_unpack';
}

function set_screenshots( &$project ) {
	$cover_img = NULL;
	$url_pattern = '|^https?\://|i';

	foreach( $project['meta']['pages'] as $ind => $page ) {
		if(isset($page['og_image']) && $page['og_image'] != '') {

			if( preg_match($url_pattern, $page['og_image']) ) {
				// it is a URL, download it locally
				$tmp_file = download_url($page['og_image']);

				if( is_wp_error($tmp_file) ) continue;

				$new_rel_path = 'img/' . basename($page['og_image']);
				$new_file = $project['full_path'] . '/' . $new_rel_path;

				rm_copy($tmp_file, $new_file);
				@unlink($tmp_file);

				$project['meta']['pages'][$ind]['og_image'] = $new_rel_path;

				if ($page['num'] == 1) {
					$cover_img = $new_rel_path;
				}

			}
		} else if ($page['num'] == 1) {
			$cover_img = get_readyscr($page['screenshot'], '1024');
		}
	}

	$project['meta']['screenshot'] = $cover_img;
}

// ajax multiload method
function rm_ajax_upload_file() {
	check_ajax_referer( 'rm-importer-upload', 'nonce' );

	$upload_dir = get_tmp_upload_dir();
	$file_path = $upload_dir . '/' . $_POST['file'];
	$file_data = rm_decode_chunk( $_POST['file_data'] );
	$stage = $_POST['stage'];

	if( $stage == 0 ) {
		// delete unfinished uploads
		rm_eliminate_dir($upload_dir);
		rm_mkdir($upload_dir);
	}

	if ( false === $file_data ) {
			wp_send_json_error();
	}

	$result = rm_file_put_contents( $file_path, $file_data, FILE_APPEND );

	wp_send_json_success($result);
}

function rm_decode_chunk( $data ) {
	$data = explode( ';base64,', $data );

	if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
	}

	$data = base64_decode( $data[1] );
	if ( ! $data ) {
			return false;
	}

	return $data;
}

function rm_ajax_cancel_upload() {
	check_ajax_referer( 'rm-importer-upload', 'nonce' );

	rm_eliminate_dir( get_tmp_upload_dir() );
	rm_eliminate_dir( get_tmp_unpack_dir() );

	wp_send_json_success();
}

function unpack_tmp_ajax_upload( $file_path ) {
	global $wp_filesystem;
	WP_Filesystem();

	$upload_dir = get_tmp_upload_dir();
	$unpack_dir = get_tmp_unpack_dir();

	if( rm_file_exists($unpack_dir) ) {
		rm_eliminate_dir($unpack_dir);
	}
	rm_mkdir($unpack_dir);

	$success = unzip_file( $file_path , $unpack_dir );
	return $success;
}

function rm_move_folder( $src, &$dst, $create_unique = true ) {
		$success = false;
		$dst_exists = rm_file_exists($dst);

		if( $create_unique && $dst_exists ) {
			$cnt = 2;
      $_tmp = $dst . ' ' . $cnt;

      while( rm_file_exists($_tmp) ) {
      	$cnt += 1; $_tmp = $dst . ' ' . $cnt;
      }

			$dst = $_tmp;
		} else if( $dst_exists ) {
			$success = false;
			return $success;
		}

		$success = rename( $src, $dst );

		return $success;
}

function convert_folder_to_uri($name) {
	$new_name = strtolower($name);
	$new_name = trim($new_name);
	$new_name = preg_replace('/^readymag/i', '', $new_name);
	$new_name = preg_replace('|\s+|', '-', $new_name);
	$new_name = preg_replace('|[\"\*/\\\:\<\>\?\'\|<>]+|', '', $new_name);
	$new_name = trim($new_name, '-');

	return $new_name;
}

function update_snippets($project) {
	global $rm_state_array;

	$project_dir = $project['full_path'];
	$project_url = $project['canonical'];
	$meta = $project['meta'];

	if (!rm_file_exists($project_dir.DIRECTORY_SEPARATOR.'snippets')) {
		$rm_state_array['warning'][] = array(
    	'project' => $project['slug'],
    	'caption' => 'Missing /snippets folder',
    	'details' => 'update_snippets() at '.$project_dir.'/snippets'
    );
		return false;
	}

	$universalSnippet = array(
		'head' => '',
		'body' => array(
			0 => ''
		),
		'file' => $project_dir.'/snippets/___single.html'
	);
	foreach ($meta['pages'] as $page) {
		$pageUri = $page['uri'] ? $page['uri'] : $page['num'];
		$pageSnippetSrc = $project_dir.'/snippets/'.$pageUri.'.html';
		$_fname = $pageUri.'_patched.html';
		if ($page['num'] == 1) $_fname = '1_patched.html';
		$pageSnippetDst = $project_dir.'/snippets/'.$_fname;

		if (!rm_file_exists($pageSnippetSrc)) continue;

		$pageBody = rm_file_get_contents($pageSnippetSrc);
		$hAppId = '';
		$hSiteTwitterUser = '';
		$hSiteTwitterCreator = '';
		$hUrlCanonical = $project_url.($page['num'] == 1 ? '' : $page['uri'].'/');
		$hSeoDescription = ___a($page['seo_title'],$meta['title']);
		$hSeoTitle = ___a($page['seo_description'],$meta['description']);
		$hSiteName = $meta['title'];
		$hOGTitle = ___a($page['og_title'],$meta['title']);
		$hOGDescription = ___a($page['og_description'],$meta['description']);
		$hOGImage = $project_url . ___a( $page['og_image'], get_readyscr($page['screenshot'], '1024'), $meta['screenshot']);

		$tmplHead = "<!doctype html>
		<head>
				<meta charset=\"utf-8\">
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">

				<meta name=\"viewport\" id=\"viewport\" content=\"initial-scale=1.0,minimum-scale=1.0,maximum-scale=10.0,minimal-ui\">
				<meta name=\"mobile-web-app-capable\" content=\"yes\">
				<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
				<meta name=\"apple-mobile-web-app-title\" content=\"{$hSiteName}\">


				<link rel=\"icon\" href=\"img/favicon.ico\" type=\"image/x-icon\">
				<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"img/apple-touch-icon-144x144-precomposed.png\">
				<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"img/apple-touch-icon-114x114-precomposed.png\">
				<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"img/apple-touch-icon-72x72-precomposed.png\">
				<link rel=\"apple-touch-icon-precomposed\" href=\"img/apple-touch-icon-precomposed.png\">
				<!--[if IE]><link rel=\"shortcut icon\" href=\"img/favicon.ico\" type=\"image/x-icon\"/><![endif]-->
				<link rel=\"canonical\" href=\"{$hUrlCanonical}\">
				 <meta content=\"{$hAppId}\" property=\"fb:app_id\">
				 <meta content=\"website\" property=\"og:type\">
				 <meta content=\"{$hUrlCanonical}\" property=\"og:url\">
				 <meta content=\"summary_large_image\" name=\"twitter:card\">
				 <meta content=\"{$hSiteTwitterUser}\" name=\"twitter:site\">
				 <meta content=\"{$hOGDescription}\" name=\"description\">
				 <meta content=\"{$hSiteTwitterCreator}\" name=\"twitter:creator\">
				 <meta content=\"{$hSiteName}\" property=\"og:site_name\">
				 <meta content=\"{$hOGImage}\" property=\"og:image\">
				 <meta content=\"{$hOGTitle}\" property=\"og:title\">
				 <meta content=\"{$hOGDescription}\" property=\"og:description\">
				<title>{$hPageTitle}</title>
					<link rel=\"stylesheet\" type=\"text/css\" href=\"build/css/viewer_desktop.css\">
		</head>";
		$tmplBody = "<body>
			{$pageBody}
		</body>
		</html>";
		rm_file_put_contents($pageSnippetDst, $tmplHead.$tmplBody);

		$universalSnippet['body'][$page['num']] = _extract_snippet_content($pageBody);

		if($page['num'] == 1) {
			$universalSnippet['head'] = $tmplHead;
		}
	}
	ksort($universalSnippet['body']);
	rm_file_put_contents($universalSnippet['file'], $universalSnippet['head'].'<body style="overflow: auto !important"><div id="mags">'.implode(' ',$universalSnippet['body']).'</div></body>');
	return true;
}

function _fix_missing_custom_fonts_css( &$line ) {
	$css_file = $path.'/build/css/custom_fonts.css';
	if (
		!rm_file_exists($css_file) &&
		preg_match('|<link .*href=[\'"]?build/css/custom_fonts.css|', $line)
	)
		$line = "\n";
}

function _extract_snippet_content($raw_html) {
	if (class_exists('DOMDocument')) {
		$html = new DOMDocument();
		@$html->loadHTML($raw_html);
		$page = $html->getElementById('mags');
		// return inner html
		return implode(array_map([$page->ownerDocument,"saveHTML"], iterator_to_array($page->childNodes)));
	} else {
		$_page_content_pattern = '/[\s]*<(div|main) id="mags">([\s\S]*)<\/(main|div)>[\s]*(<div.*class="used-fonts-test|\s)/i';
		preg_match($_page_content_pattern, $pageBody, $pageMatches);
		if(isset($pageMatches[1])) {
			return $pregMatches[1];
		} else {
			return $pregMatches[0];
		}
	}
}

function create_associated_post($project, $p_id) {
	$postarr = array(
		'post_title' => $project['title'],
		'post_type' => 'rm_project',
		'comment_status' => 'closed',
		'meta_input' => array('associated_project' => $p_id),
		'post_content' => '<p>'.$project['meta']['description'].'</p>',
		'post_excerpt' => '<p>'.$project['meta']['description'].'</p>'
	);
	return wp_insert_post($postarr);
}

function upload_post_thumbnail( &$project, $post ) {
	$img_file = untrailingslashit($project['full_path']) . '/' . $project['meta']['screenshot'];
	$tmp_file = get_readyscr($img_file, '_tmp_');
	$desc = '‘'.$project['title'].'’ cover';

	if( !rm_file_exists($img_file) )
		return false;

	rm_copy($img_file, $tmp_file);

	$filearr = array(
		'name' => basename($tmp_file),
		'tmp_name' => $tmp_file
	);

	$thumb_id = media_handle_sideload($filearr, $post, $desc);

	set_post_thumbnail($post, $thumb_id);

	$project['meta']['wp_screenshot'] = wp_get_attachment_image_src($thumb_id, 'full');

	return true;
}