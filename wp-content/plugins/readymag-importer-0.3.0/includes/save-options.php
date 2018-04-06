<?php

global $rm_state_array;

function get_project_settings() {
	return get_option('rm-imported-projects');
}

function save_project_settings($obj) {
	// prepare index
	$index_arr = rm_cm_generate_index( $obj );

	update_option('rm-imported-projects-index', $index_arr);

	// DANGER! MESSING AROUND WITH ADVANCED-CACHE
	rm_cm_generate_config( $index_arr );

	return update_option('rm-imported-projects', $obj);
}

function get_folder_index(&$projects) {
	$result = array();
	foreach($projects as $p_id => $project) {
		$result[$project['folder']] = $p_id;
	}
	return $result;
}

function get_dir_contents( $suffix = '', $need_zip = false ) {
	$result = [];

	$rootPath = WP_CONTENT_DIR . '/rm-projects' . $suffix;
	$is_tmp = ($suffix != '');
	$glob_pattern = $need_zip ? '*.zip' : '*';
	$glob_flags = $need_zip ? 0 : GLOB_ONLYDIR;

	if ( !$is_tmp ) {
		$projects = get_project_settings();
		$dir_index = get_folder_index($projects);
	}

	$contents = glob($rootPath . '/'.$glob_pattern , $glob_flags );

	foreach ($contents as $obj) {
		$base = basename($obj);
		if ($is_tmp || !isset($dir_index[$base])) {
			$result[] = $obj;
		}
	}
	return $result;
}

// $stage: 0 - full update, 1 - permalink only
function staged_project_update( $stage, &$project, $p_id ) {
	global $rm_state_array;

	$success = true;

	if( $stage == 0 ) {

		$success = create_patched_index($project['full_path']);

		if (!$success)
			return $success;

		// returns true in case of success, and saves parsed json to $meta
		$meta = NULL;
		$success = update_project_json($project['full_path'], $meta);

		if (!$success)
			return $success;

		$project['async_json'] = true;

		$project['meta'] = $meta;
		$project['title'] = $project['meta']['title'];
		$project['num_id'] = $project['meta']['num_id'];

		if ( !isset($project['post_id']) ) {
			$new_post_id = create_associated_post($project, $p_id);
			$project['post_id'] = $new_post_id;
		}

		// sideload post screenshot
		set_screenshots( $project );

		if ( $project['meta']['screenshot'] && !upload_post_thumbnail( $project, $project['post_id'] ) ) {
			$rm_state_array['warning'][] = array(
				'caption' => 'Unable to find project screenshot',
				'details' => 'staged_project_update() at '.$project['full_path']
			);
		}

	}

	if( $stage <= 1 ) {

		list($post_sample_permalink, $post_name) = get_sample_permalink( $project['post_id'] );
		$project['post_name'] = $post_name;

  	// update permalink according to the post
  	if($project['status'] != 'publish' || $project['status'] != 'private' || $project['status'] != 'protected') {
  		// post is not published, permalink should be generated
			$post_permalink = str_replace( array( '%pagename%', '%postname%' ), $post_name, $post_sample_permalink );
  	} else {
  		// get published post permalink
  		$post_permalink = get_post_permalink( $project['post_id'] );
  	}

		$project['permalink'] = post_to_project_permalink($post_permalink);
		$project['canonical'] = trailingslashit($post_permalink);
		$project['rewrite_rule'] = get_rewrite_rule($project['permalink']);

		update_meta_tags($project);
	}

	return $success;
}

function get_new_project_id( $dir_base, &$projects ) {
	// generate p_id by sanitizing
	$p_id = convert_folder_to_uri($dir_base);

	if ( $p_id == '' )
		$p_id = 'default-uri';

	do {
		$hash = substr(md5(mt_rand()), 0, 7);
	} while( isset($projects[$p_id . '_' . $hash]) );

	return $p_id . '_' . $hash;
}

// saving a temporary directory
function activate_tmp_dir( $tmp_dir, &$projects, &$p_id ) {
	global $rm_state_array;

	$new_project = false;
	$has_backup = false;
	$restore_name = null;
	$backup_name = null;

	if( !isset($p_id) || $p_id == '' )
		$new_project = true;

	// save backup in case of failure
	if( !$new_project && rm_file_exists($projects[$p_id]['full_path']) ) {
		$has_backup = true;
		$restore_name = untrailingslashit( $projects[$p_id]['full_path'] );
		$backup_name = $restore_name.'_'.substr(md5(mt_rand()), 0, 7);
		rename( $restore_name, $backup_name );
	}

	// moving folder
	$dir = WP_CONTENT_DIR . '/rm-projects/' . basename($tmp_dir);
	if( !$new_project && rm_file_exists($dir) )
		rm_eliminate_dir($dir);

	$success = rm_move_folder( $tmp_dir, $dir, $new_project );

	if( !$success ) {
		$rm_state_array['error'][] = array(
			'caption' => 'Unable to rename directory',
			'details' => $permanent_dir
		);
		$rm_state_array['error'][] = array(
			'caption' => 'Project ./'.basename($dir).' has not been activated',
			'details' => $dir
		);

		if( $has_backup ) {
			rm_eliminate_dir( $dir );
			rename( $backup_name, $restore_name );
		}
		return $success;
	}

	if( $new_project ) {
		$dir_base = basename( $dir );
		$p_id = get_new_project_id($dir_base, $projects);

		$projects[$p_id] = array(
			'full_path' => $dir,
			'folder' => $dir_base, // path to tmp dir
			'title' => $p_id,
			'num_id' => -1,
			'pushstate' => false,
			'status' => 'draft' // draft, published, protected, private, deleted, future
		);

		$new_project = true;
	} elseif ( basename( $dir ) != $projects[$p_id]['folder'] ) {
		$projects[$p_id]['full_path'] = $dir;
		$projects[$p_id]['folder'] = basename($dir);
	}

	$success = staged_project_update( 0, $projects[$p_id], $p_id );

	if( $success && $new_project ) {
		$rm_state_array['success'][] = array(
			'caption' => 'Project added'
		);
	} else if ($success && !$new_project) {
		$rm_state_array['success'][] = array(
			'caption' => 'Source code updated'
		);
		if( $has_backup ) {
			rm_eliminate_dir( $backup_name );
		}
	} else if ( !$success && $new_project ) {
		unset($projects[$p_id]);
		$rm_state_array['error'][] = array(
			'caption' => 'Project ./'.basename($tmp_dir).' has not been activated',
			'details' => $tmp_dir
		);
	} else if ( !$success && !$new_project) {
		$rm_state_array['error'][] = array(
			'caption' => 'Project ‘'.$projects[$p_id]['title'].'’ has not been updated',
			'details' => $projects['full_path']
		);

		if( $has_backup ) {
			rm_eliminate_dir( $dir );
			rename( $backup_name, $restore_name );
		}
	}
	return $success;
}

function save_single_post($postarr) {
	global $rm_state_array;
	$projects = get_project_settings();
	$p_id = $postarr['associated_project'];

	$dir = $projects[$p_id]['full_path'];

	if(isset($postarr['post_permalink'])) {

		$success = staged_project_update(1, $projects[$p_id], $p_id);

		if( !$success ) {
			$rm_state_array['error'][] = array(
				'caption' => 'Unable to update post permalink',
				'details' => $dir
			);
		}
	}

	if (isset($postarr['post_status'])) $projects[$p_id]['status'] = $postarr['post_status'];

	if (isset($postarr['has_permalinks'])) $projects[$p_id]['pushstate'] = $postarr['has_permalinks'];

	if(isset($postarr['make_update']) && $postarr['make_update'] == true) {

		$success = staged_project_update(0, $projects[$p_id], $p_id);

		if( $success ) {
			$rm_state_array['success'][] = array(
				'caption' => 'Source code updated'
			);
		} else {
			$rm_state_array['error'][] = array(
				'caption' => 'Source code has not been updated',
				'details' => $dir
			);
		}
	}

	save_project_settings($projects);

	return $projects;
}

function delete_single_post($p_id) {
	$projects = get_project_settings();

	if($p_id == '' || !isset($projects[$p_id]) || !isset($projects[$p_id]['full_path']))
		return;

	rm_eliminate_dir($projects[$p_id]['full_path']);
	unset($projects[$p_id]);
	save_project_settings($projects);
}

function update_post_slug() {
	global $rm_state_array;
	$projects = get_project_settings();
	$overall_success = true;

	foreach($projects as $p_id => $p_data) {
		$success = staged_project_update( 1, $projects[$p_id], $p_id);
		if(!$success) $overall_success = false;
	}
	
	save_project_settings($projects);
	var_dump($overall_success);
	if( !$overall_success ) {
		$rm_state_array['warning'][] = array(
			'caption' => 'Unable to correctly update post permalinks'
		);
	} else {
		$rm_state_array['success'][] = array(
			'caption' => 'URL structure updated'
		);
	}
//	var_dump($rm_state_array);
}

// ajax activation function
function rm_ajax_activate_uploaded_file() {
	check_ajax_referer( 'rm-importer-upload', 'nonce' );

	global $rm_state_array;
	$projects = get_project_settings();

	$p_id = isset($_POST['p_id']) && $_POST['p_id'] != '' ? $_POST['p_id'] : NULL;

	// unpack zip from ./_tmp_upload to ./_tmp_unpack
	$uploaded_zips = get_dir_contents( '/_tmp_upload', true );
	if (count($uploaded_zips) != 1) {
		wp_send_json_error( 'Multiple zip archives in temporary folder' );
	}
	$success = unpack_tmp_ajax_upload($uploaded_zips[0]);
	if( isset($success['errors']) ) {
		wp_send_json_error( $success['errors'] );
	}

	// activate tmp dir
	$unpacked_dirs = get_dir_contents( '/_tmp_unpack' );
	if (count($unpacked_dirs) != 1) {
		$rm_state_array['error'][] = array( 'caption' => 'Multiple uploaded files detected in temporary folder');
		wp_send_json_error( $unpacked_dirs );
	}
	$success = activate_tmp_dir( $unpacked_dirs[0], $projects, $p_id );

	rm_eliminate_dir( get_tmp_unpack_dir() );
	rm_eliminate_dir( get_tmp_upload_dir() );

	update_option('_rm_redirect_state_save', $rm_state_array);

	$redirect = get_edit_post_link( $projects[$p_id]['post_id'], '');

	if( $success ) {
		save_project_settings($projects);
		wp_send_json_success( array(
				'redirect' => $redirect,
				'state' => $rm_state_array
			)
		);
	} else {
		wp_send_json_error( array( 'state' => $rm_state_array ) );
	}
}

function rm_ajax_activate_previous_upload() {
	check_ajax_referer( 'rm-importer-upload', 'nonce' );

	global $rm_state_array;
	$projects = get_project_settings();

	$uploads_dir = WP_CONTENT_DIR . '/rm-projects/uploads';

	$p_id = (isset($_POST['p_id']) && $_POST['p_id'] != '') ? $_POST['p_id'] : NULL;
	$file_name = trim($_POST['file']);
	$file_path = $uploads_dir . '/' . trim($file_name, '/');

	if(!isset($file_name) || !rm_file_exists($file_path) ) {
		wp_send_json_error('file does not exist');
	}

	$is_archive = preg_match('|\.zip$|i', $file_name);

	$success = false;
	$tmp_dir = null;

	if( $is_archive ) {
		$success = unpack_tmp_ajax_upload( $file_path );

		if( isset($success['errors']) ) {
			wp_send_json_error( $success['errors'] );
		}

		$unpacked_dirs = get_dir_contents( '/_tmp_unpack' );
		if (count($unpacked_dirs) != 1) {
			$rm_state_array['error'][] = array( 'caption' => 'Multiple uploaded files detected in temporary folder');
			wp_send_json_error( $unpacked_dirs );
		}

		$tmp_dir = $unpacked_dirs[0];
	} else {
		$tmp_dir = $file_path;
	}

	$success = activate_tmp_dir( $tmp_dir, $projects, $p_id );

	if( $is_archive ) {
		rm_eliminate_dir( get_tmp_unpack_dir() );
		@unlink( $file_path );
	} else {
		rm_eliminate_dir( $file_path );
	}

	update_option('_rm_redirect_state_save', $rm_state_array);

	$redirect = get_edit_post_link( $projects[$p_id]['post_id'], '');

	if( $success ) {
		save_project_settings($projects);
		wp_send_json_success( array(
				'redirect' => $redirect,
				'state' => $rm_state_array
			)
		);
	} else {
		wp_send_json_error( array( 'state' => $rm_state_array ) );
	}
}

function check_rights() {
	if (!is_user_logged_in()){
      die("You Must Be Logged In to Access This");
  }
  if( ! current_user_can('edit_files')) {
      die("Oops sorry you are not authorized to do this");
  }
}

function pre_save_plugin_settings() {
	global $rm_state_array, $rm_plugin_settings;

	if( !isset($rm_plugin_settings) )
		$rm_plugin_settings = get_option('rm-importer-settings');

	if(isset($_POST['rm-plugin-settings-verification']) && $_POST['rm-plugin-settings-verification'] == 'true') {
		check_rights();
		
  		$new_slug = ($_POST['custom-post-slug'] != '') ? str_replace('/', '', $_POST['custom-post-slug']) : '/';
  		$new_hard_patch = (isset($_POST['try-hard-patch']) && $_POST['try-hard-patch'] == 'on') ? true : false;
  		$new_mix = (isset($_POST['mix-in-loop']) && $_POST['mix-in-loop'] == 'on') ? true : false;

  		$new_settings = array(
  			'slug' => $new_slug,
  			'hard_patch' => $new_hard_patch,
  			'mix_in_loop' => $new_mix
  		);

  		update_option('rm-importer-settings', $new_settings);
  		$rm_plugin_settings = $new_settings;

  		$prev_hard_patch = ($_POST['prev-hard-patch'] == 'checked') ? true : false;
		$updated_hard_patch = ($prev_hard_patch != $new_hard_patch);

		if($updated_hard_patch && $new_hard_patch == true) {
			$success = rm_cm_remove_advanced_cache();
			
			if( !$success ) $rm_state_array['warning'][] = array( 'caption' => 'Unable to remove advanced cache inclusions' );
			
			$success = rm_cm_hard_patсh_wp_settings( true );
			
			if( !$success ) {
				$rm_state_array['warning'][] = array(
					'caption' => 'Unable to patch wp-settings.php'
				);
				$new_hard_patch = false;
				$need_save = true;
			} else {
				$rm_state_array['success'][] = array(
					'caption' => 'Option ‘Resolve conflicts with a cache plugin’ updated'
				);
			}
		} elseif( $updated_hard_patch && $new_hard_patch == false ) {
      		rm_cm_remove_hard_patch();

			$success = rm_cm_activate_advanced_cache( true );
	
			if( !$success ) {
				$rm_state_array['warning'][] = array( 'caption' => 'Unable to activate advanced-cache.php' );
			}
      	}

  } else {
  	rm_cm_check_advanced_cache();
  }
}
add_action( 'plugins_loaded', 'pre_save_plugin_settings' );

function manage_update_requests() {
	global $rm_plugin_settings;
	check_rights();
	

	if (isset($_GET['force']) && $_GET['force'] == 'true') {
		$empty = array();
		save_project_settings($empty);
	}

	//  plugin settings are saved in plugins_loaded hook
	if(isset($_POST['rm-plugin-settings-verification']) && $_POST['rm-plugin-settings-verification'] == 'true') {
		check_rights();

		$prev_slug = ($_POST['prev-custom-post-slug'] != '') ? str_replace('/', '', $_POST['prev-custom-post-slug']) : '/';
		$new_slug = ($_POST['custom-post-slug'] != '') ? str_replace('/', '', $_POST['custom-post-slug']) : '/';
		$updated_slug = ($prev_slug != $new_slug);
		
		if($updated_slug) {
			update_post_slug();
		}
	}

}

function post_to_project_permalink($post_permalink) {
	return trim(str_replace(home_url(),'',$post_permalink),'/');
}

function get_rewrite_rule($project_permalink) {
	return $project_permalink.'/?(.*)?';
}

function rm_ajax_save_permalink() {
	wp_verify_nonce( $_POST['nonce'], 'rm_save_permalink' );
	
	$p_id = $_POST['post_id'];
	$title = $_POST['title'];
	$permalink = $_POST['permalink'];
	
	$permalink = trim(sanitize_title($permalink));
	if( '' == $permalink ) {
		$permalink = trim(sanitize_title($title));
	}
	
	wp_send_json_success($permalink);
	wp_die();
}
