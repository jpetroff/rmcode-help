<?php

global $rm_plugin_settings;

/**
 * =====================================================
 *
 * GENERATE CONFIG AND CHECK PLUGGABLE ADVANCED CACHE
 *
 * =====================================================
 */

function rm_cm_generate_index( &$projects ) {
	global $rm_plugin_settings;
	$index_arr = [];

	$sample_permalink = NULL;

	foreach($projects as $p_id => $project_settings) {
		if(!$p_id) continue;

		if(!isset($sample_permalink)) {
			list($sample_permalink) = get_sample_permalink($project_settings['post_id']);
		}
		$index_arr[$project_settings['post_name']] = array(
			'folder' => $project_settings['folder'],
			'status' => $project_settings['status'],
			'has_permalinks' => $project_settings['pushstate'],
			'post_id' => $project_settings['post_id']
		);
	}

	if ($sample_permalink == NULL) {
		$sample_permalink = rtrim(home_url(),'/').str_replace('/','',$rm_plugin_settings['slug']).'/%pagename%/';
	}

	$index_arr['&sample_permalink'] = $sample_permalink;

	return $index_arr;
}

function rm_cm_check_advanced_cache() {
	global $rm_state_array, $rm_plugin_settings;

	$success = false;

	if( !isset($rm_plugin_settings) )
		$rm_plugin_settings = get_option('rm-importer-settings');

	// copy R/m Advanced Cache addon to WP_CONTENT_DIR

	if( !defined( 'RM_CACHE_PHASE1_CONFIG_INCLUDED') && !rm_file_exists(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache-config.php') ) {
		$projects = get_project_settings();
		rm_cm_generate_config($projects, false);
	}

	if( !defined('RM_CACHE_PHASE1_INCLUDED') ) {

		if( !rm_file_exists(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache.php') )
    		rm_copy(RM_IMP_DIR . '/rm-advanced-cache.php', WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache.php');

		if( $rm_plugin_settings['hard_patch'] == true ) {

			$success = rm_cm_hard_patсh_wp_settings();

		} else {

			// enable WP_CACHE if necessary AND
			// set own advanced-cache.php file or inject R/m include into an existing
			$success = rm_cm_add_config_cache() && rm_cm_activate_advanced_cache();

		}

	} else {
		$success = true;
	}

	return $success;
}

function rm_cm_generate_config( $index_arr, $check_cache = true ) {
	$template = rm_file_get_contents( RM_IMP_DIR . '/rm-advanced-cache-config.ptmp');

	if ( $template === false )
		return;

	$permalink = $index_arr['&sample_permalink'];
	$permalink_obj = parse_url($permalink);

	$eol = defined('PHP_EOL') ? PHP_EOL : '\n';
	$ind = "\t\t";

	$index_str = '';
	$_first = true;
	foreach ( $index_arr as $post_name => $project_data ) {
		if ($post_name == '&sample_permalink')
			continue;

		if($_first == false)
			$index_str .= ',' . $eol;

		$_first = false;
		$index_str .= $ind." \"".$post_name."\" => array( ";
		$index_str .= " \"folder\" => \"".addslashes($project_data['folder'])."\", ";
		$index_str .= " \"status\" => \"".addslashes($project_data['status'])."\", ";
		$index_str .= " \"has_permalinks\" => ".($project_data['has_permalinks'] ? 'true' : 'false').", ";
		$index_str .= " \"post_id\" => ".intval($project_data['post_id'])." ";
		$index_str .= ")";

	}

	$permalink_str = '';
	$_first = true;
	foreach( $permalink_obj as $part => $value ) {
		if($_first == false)
			$permalink_str .= ',' . $eol;

		$_first = false;
		$permalink_str .= $ind."\"".$part."\" => \"".addslashes($value)."\"";
	}

	$template = str_replace('{{index_array}}', $index_str, $template);
	$template = str_replace('{{parse_permalink_array}}', $permalink_str, $template);
	$template = str_replace('{{plugin_directory}}', RM_IMP_DIR, $template);

	rm_file_put_contents(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache-config.php', $template);

	if( $check_cache )
		rm_cm_check_advanced_cache();
}

function rm_cm_add_config_cache() {
	$global_config_file = rtrim(ABSPATH, '/') . '/wp-config.php';

	$success = true;
	$define_line =  "\t\tdefine( 'WP_CACHE', true );";

	if (
		!defined('WP_CACHE') ||
		defined( 'WP_CACHE' ) && constant( 'WP_CACHE' ) == false
	) {

		$success = false;

		// try replacing an existing line
		$success = rm_replace_line("|define *\( *'WP_CACHE|", $define_line, $global_config_file);

		if( ! $success )
			// try adding the line
			$success = rm_add_lines("|define *\( *'DB_NAME'|", $define_line, $global_config_file, true);
	}

	return $success;
}

function rm_cm_activate_advanced_cache( $force = false ) {
	$success = true;
	$include_line = "!defined('RM_CACHE_PHASE1_INCLUDED') && @include(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache.php');";
	$wp_cache_file = WP_CONTENT_DIR . '/advanced-cache.php';

	if( !defined( 'RM_CACHE_PHASE1' ) || $force ) {
		$success = false;

		if(rm_file_exists($wp_cache_file)) {

			// check if the line exists
			$success = rm_replace_line("|include *\( *WP_CONTENT_DIR *\. *'/rm-projects/rm-advanced-cache\.php'|", $include_line , $wp_cache_file);

			// try adding the line
			if( ! $success )
				$success = rm_add_lines("|<\?php|", $include_line, $wp_cache_file);

		} else {
			$success = rm_copy(RM_IMP_DIR . '/advanced-cache.php', $wp_cache_file);
		}
	}

	return $success;
}

function rm_cm_hard_patсh_wp_settings( $force = true ) {
	$wp_settings_file = rtrim(ABSPATH, '/') . '/wp-settings.php';
	$include_line =  "!defined('RM_CACHE_PHASE1_INCLUDED') && @include(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache.php');";

	$success = true;

	if( !defined( 'RM_CACHE_PHASE1' ) || $force ) {
		$success = false;

		if( rm_file_exists($wp_settings_file) ) {
			$success = rm_replace_line("|include *\( *WP_CONTENT_DIR *\. *'/rm-projects/rm-advanced-cache\.php'|", $include_line, $wp_settings_file);

			if( ! $success )
				$success = rm_add_lines("|if *\( *WP_CACHE|", $include_line, $wp_settings_file, true);
		}

	}

	return $success;
}

function rm_cm_remove_hard_patch() {
	$wp_settings_file = rtrim(ABSPATH, '/') . '/wp-settings.php';

	return rm_replace_line("|include *\( *WP_CONTENT_DIR *\. *'/rm-projects/rm-advanced-cache\.php'|", '', $wp_settings_file);
}

function rm_cm_remove_advanced_cache() {
	$wp_cache_file = WP_CONTENT_DIR . '/advanced-cache.php';
	$global_config_file = rtrim(ABSPATH, '/') . '/wp-config.php';

	$success = false;

	if( rm_file_exists($wp_cache_file) ) {
		$wp_cache_file_content = rm_file_get_contents($wp_cache_file);

		// check if advanced-cache.php was added by our plugin
		$found = false;
		$lines = file($wp_cache_file);
		foreach( (array)$lines as $line ) { if ( preg_match('|// Readymag Importer advanced-cache.php|i', $line)) { $found = true; break;	}	}

		if( $found ) {
			@unlink($wp_cache_file);
			$success = true;

			if( rm_file_exists($global_config_file) ) {
				$success = rm_replace_line("|define *\( *'WP_CACHE|", '', $global_config_file);
			} else {
				$success = false;
			}
		} else {
			$success = rm_replace_line("|include *\( *WP_CONTENT_DIR *\. *'/rm-projects/rm-advanced-cache\.php'|", '' , $wp_cache_file);
		}
	}

	return $success;
}
