<?php
/**
 * Plugin Name: Readymag Importer β
 * Plugin URI: https://wordpress.readymag.com/
 * Description: Integrate exported Readymag projects into your Wordpress site
 * Version: 0.3.1
 * Author: Readymag
 * Author URI: https://readymag.com/
 */

defined( 'ABSPATH' ) OR exit;

if( !defined('RM_IMP_DIR') )
	define( 'RM_IMP_DIR', __DIR__ );

if( !defined('RM_IMPORTER_UTILS_LOADED') )
	include RM_IMP_DIR.'/includes/utils.php';

if( !defined('RM_CACHE_MODULE') )
	include RM_IMP_DIR.'/includes/rm-cache.php';

if( is_admin() ) {
	include RM_IMP_DIR.'/includes/config-manager.php';
	include RM_IMP_DIR.'/includes/save-options.php';
	include RM_IMP_DIR.'/includes/uploader.php';
	include RM_IMP_DIR.'/includes/ajax-uploader-component.php';
	
}


define( 'RM_CACHE_PHASE2', true );


 /**
  * =================================================
  *
  * GLOBAL STATE FOR MANAGING ERRORS AND MESSAGES
  *
  * =================================================
  */

global $rm_state_array, $rm_plugin_settings;

$rm_state_array = array(
	'error' => array(),
	'success' => array(),
	'warning' => array()
);


/**
 * =================================================
 *
 * SETTINGS MENU: R/M PROJECTS
 *
 * =================================================
 */

/** Step 2 (from text above). */
add_action( 'admin_menu', 'rm_importer_menu' );

/** Step 1. */
function rm_importer_menu() {
	add_submenu_page( 'edit.php?post_type=rm_project', 'Upload Project', '→ Add Project', 'manage_options', 'rm-upload-project', 'rm_upload_page');
	add_submenu_page( 'edit.php?post_type=rm_project', 'Settings', 'Settings', 'manage_options', 'rm-importer-settings', 'rm_importer_settings');
}

/** Step 3. */
function _rm_importer_settings() {

	// from save-options.php
	manage_update_requests();

	include RM_IMP_DIR.'/includes/menu-project-list.php';
}

function rm_upload_page() {
	include RM_IMP_DIR.'/includes/menu-upload.php';
}

function rm_importer_settings() {
	include RM_IMP_DIR.'/includes/menu-importer-settings.php';
}

add_action('admin_enqueue_scripts', 'rm_importer_settings_scripts');
function rm_importer_settings_scripts($hook) {
	global $post_type;

	// styles
	if (
		($hook == 'post.php' && isset($post_type) && $post_type == 'rm_project') ||
		($hook == 'rm_project_page_rm-upload-project') ||
		($hook == 'rm_project_page_rm-importer-settings') ||
		($hook == 'edit.php' && $_GET['post_type'] == 'rm_project' )
	) {
		wp_enqueue_script( 'vuejs', plugins_url('assets/vue.min.js', __FILE__) );
		wp_enqueue_style( 'rm_importer_admin_css', plugins_url('assets/rm-importer-styles.css', __FILE__) );
		wp_enqueue_script( 'rm_importer_upload_js', plugins_url('assets/rm-upload-script.js', __FILE__) );
	}

	if( $hook == 'post.php' && isset($post_type) && $post_type == 'rm_project' ) {
		wp_enqueue_script( 'vuejs', plugins_url('assets/vue.min.js', __FILE__) );
		wp_enqueue_script( 'rm_importer_upload_js', plugins_url('assets/rm-upload-script.js', __FILE__) );
	}

	// scripts
	if ($hook == 'rm_project_page_rm-upload-project') {
		wp_enqueue_script( 'vuejs', plugins_url('assets/vue.min.js', __FILE__) );
		wp_enqueue_script( 'rm_importer_upload_js', plugins_url('assets/rm-upload-script.js', __FILE__) );
	}
}

add_action('admin_init', 'rm_importer_admin_init');
function rm_importer_admin_init() {

	// from includes/upload.php
	add_action( 'wp_ajax_rm_upload_file', 'rm_ajax_upload_file' );

	// from includes/upload.php
	add_action( 'wp_ajax_rm_cancel_upload', 'rm_ajax_cancel_upload' );

	// from includes/save-options.php
	add_action( 'wp_ajax_rm_activate_uploaded_file', 'rm_ajax_activate_uploaded_file' );

	// from includes/save-options.php
	add_action( 'wp_ajax_rm_activate_previous_upload', 'rm_ajax_activate_previous_upload' );
	add_action( 'wp_ajax_rm_save_permalink', 'rm_ajax_save_permalink' );
	
}

add_action('admin_head', 'rm_importer_css_fixes');
function rm_importer_css_fixes() {
  echo "<style>
    #menu-posts-rm_project .wp-menu-image {
    	-webkit-background-size: 16px auto !important;
    	background-size: 16px auto !important;
    	height: 34px !important;
    }
  </style>";
}

/**
 * =================================================
 *
 * REGISTER CUSTOM POST TYPE
 *
 * =================================================
 */

function rm_post_type() {
	global $rm_plugin_settings;

	$menu_icon = "
		<svg width='16px' height='16px' viewBox='0 0 16 16' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
			<g fill=\"#9EA3A8\">
				<path d='M1.5,0 L14.5,0 C15.3284271,-1.52179594e-16 16,0.671572875 16,1.5 L16,14.5 C16,15.3284271 15.3284271,16 14.5,16 L1.5,16 C0.671572875,16 1.01453063e-16,15.3284271 0,14.5 L0,1.5 L0,1.5 C-1.01453063e-16,0.671572875 0.671572875,1.52179594e-16 1.5,0 L1.5,0 Z M14.1000004,1 L1,14.1000004 L1.47198486,14.5245361 L1.9000001,15 L15.0023804,1.9000001 L14.5741577,1.42694092 L14.1000004,1 Z' id='Combined-Shape'></path>
			</g>
    </svg>
	";

	if( !isset($rm_plugin_settings) )
		$rm_plugin_settings = get_option('rm-importer-settings');

  register_post_type( 'rm_project',
    array(
      'labels' => array(
        'name' => __( 'R/m Projects' ),
        'singular_name' => __( 'R/m Project' ),
        'edit_item' => __('Project Settings'),
        'new_item' => __('New Project'),
        'all_items' => __('All Projects'),
        'add_new_item' => __('Upload')
      ),
      'public' => true,
      'has_archive' => 'specials',
      'rewrite' => array('slug'=> $rm_plugin_settings['slug'] ,'with_front'=>false),
      'supports' => array(
      	'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes'
      ),
      'taxonomies' => array('category', 'post_tag'),
      'capabilities' => array(
      	'create_posts' => 'do_not_allow'
      ),
      'map_meta_cap' => true,
      'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode($menu_icon)
    )
  );
}
add_action( 'init', 'rm_post_type' );

function mix_rm_posts_in_loop( $query ) {
	global $rm_plugin_settings;

	if( !isset($rm_plugin_settings) )
		$rm_plugin_settings = get_option('rm-importer-settings');

	if(
		$rm_plugin_settings['mix_in_loop'] == true &&
		!is_admin() &&
		$query->is_main_query() &&
		(
			$query->is_front_page() ||
			$query->is_archive() ||
			$query->is_category() ||
			$query->is_date() ||
			$query->is_day() ||
			$query->is_year() ||
			$query->is_month() ||
			$query->is_front_page() ||
			$query->is_tag()
		)
	) {
		$post_type = array('post');
		if(isset($query->query_vars->post_type)) $post_type = $query->query_vars->post_type;
		$post_type[] = 'rm_project';
		$query->set( 'post_type',  $post_type );
	}
	return $query;
}
add_action( 'pre_get_posts', 'mix_rm_posts_in_loop' );

/**
 * =================================================
 *
 * POST AND PAGE EDIT PARAM
 *
 * =================================================
 */

add_action('edit_form_after_title', 'show_rm_project__after');
function show_rm_project__after ($post) {
	if ($post->post_type != 'rm_project') return;
	include RM_IMP_DIR.'/includes/menu-project-settings.php';
}

add_action('save_post', 'rm_save_post');
function rm_save_post($post_id) {
	global $rm_state_array;

	if($_POST['post_type'] != 'rm_project') return;

	$has_permalinks = $_POST['rm-project-pushstate'] == 'on' ? true : false;
	$make_update = $_POST['rm-project-update-source'] == 'on' ? true : false;

	$associated_project = $_POST['associated_project'];
	if(!isset($associated_project)) $associated_project = get_project_by_post_id($post_id);

	$post_permalink = NULL;
	if ($_POST['post_status'] != 'publish') {
		list($post_sample_permalink, $post_name) = get_sample_permalink($new_post_id);
		$post_permalink = str_replace( array( '%pagename%', '%postname%' ), $post_name, $post_sample_permalink );
	} else {
		$post_permalink = get_post_permalink($post_id);
	}

	$post_status = $_POST['post_status'];
	if ( $post_status == 'publish' && (	$_POST['visibility'] == 'password' || $_POST['post_password'] != '' ) )
		$post_status = 'protected';

	$postarr = array(
		'post_status' => $post_status,
		'post_permalink' => $post_permalink,
		'associated_project' => $associated_project,
		'has_permalinks' => $has_permalinks,
		'make_update' => $make_update
	);

	save_single_post($postarr);

	update_option('_rm_redirect_state_save', $rm_state_array);
}

add_action('before_delete_post', 'rm_delete_post');
function rm_delete_post($post_id) {
	global $post_type;
	if ($post_type != 'rm_project') return;

	$associated_project = get_project_by_post_id($post_id);

	if($associated_project === false) return;

	delete_single_post($associated_project);
}

add_action('wp_trash_post', 'rm_trash_post');
function rm_trash_post($post_id) {
	$associated_project = get_project_by_post_id($post_id);
	if($associated_project === false) return;

	$postarr = array(
		'post_status' => 'deleted',
		'associated_project' => $associated_project
	);
	save_single_post($postarr);
}

add_filter('preview_post_link', 'rm_filter_preview_link', 0, 2);
function rm_filter_preview_link( $link, $post ) {
	if ($post->post_type != 'rm_project') return $link;

	list($sample_permalink, $post_name) = get_sample_permalink( $post );
	return str_replace( array('%postname%', '%pagename%'), $post_name, $sample_permalink);
}

add_filter('post_type_link', 'rm_filter_post_link', 0, 2);
function rm_filter_post_link( $link, $post ) {
	if ($post->post_type != 'rm_project') return $link;
	return trailingslashit($link);
}

add_action('manage_rm_project_posts_columns', 'rm_project_list');
function rm_project_list($defaults) {
	$new_array = array();
	foreach($defaults as $key => $value) {
		if ($key == 'title') $new_array['thumbnail'] = 'Cover';
		$new_array[$key] = $defaults[$key];
	}
	return $new_array;
}

add_action( 'manage_rm_project_posts_custom_column', 'rm_project_list_fill_table', 10, 2 );
function rm_project_list_fill_table($column_name, $post_id) {
	if ($column_name == 'thumbnail') {
		$thumb = get_the_post_thumbnail_url($post_id, 'small');
		echo '<img class="rm-list-thumbnail" src="'.$thumb.'" />';
	}
}

function rm_admin_notices() {
	global $rm_state_array;
	flush_messages();
}
add_action( 'admin_notices', 'rm_admin_notices' );

/**
 * =================================================
 *
 * CATCHING REQUESTS TO STATIC PAGES
 *
 * =================================================
 */

function add_static_queries($qvars) {
	$qvars[] = 'is_rm_project';
	$qvars[] = 'rm_route_object';
	return $qvars;
}
add_filter('query_vars', 'add_static_queries', 0);


function redirect_static_request($wp) {

	if ( is_admin() ) return $wp;

	$route = rm_importer_parse_request();

	send_file_phase2($route, $wp);

	return $wp;
}


function rm_canonical_redirect( $redirect_url, $requested_url ) {
	global $wp_query;
	if ($wp_query->query['is_rm_project'] == true && substr($redirect_url, -1) != '/') {
		return false;
	}
	return true;
}


if( !defined('RM_CACHE_PHASE1') || defined('RM_CACHE_REQUIRE_PHASE2') ) {
	add_action('parse_request', 'redirect_static_request', 0);
	add_filter('redirect_canonical', 'rm_canonical_redirect', 10, 2);
}

/**
 * =================================================
 *
 * ACTIVATION AND DEACTIVATION
 *
 * =================================================
 */

function rm_on_plugin_activate() {
	global $rm_state_array;

	if ( ! current_user_can( 'activate_plugins' ) )
		return;

	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "activate-plugin_{$plugin}" );

	$rm_projects_folder = WP_CONTENT_DIR . '/rm-projects';
	if (!rm_file_exists($rm_projects_folder)) {
		rm_mkdir($rm_projects_folder);
	}

	$rm_uploads_folder = $rm_projects_folder . '/uploads';
	if (!rm_file_exists($rm_uploads_folder)) {
		rm_mkdir($rm_uploads_folder);
	}

	$current_projects = get_option('rm-imported-projects');
	if( ! $current_projects ) {
		$current_projects = array();
	}

	if( ! get_option('rm-importer-settings') )
		update_option('rm-importer-settings', array(
			'slug' => '/',
			'hard_patch' => false,
			'mix_in_loop' => false
		));

	save_project_settings($current_projects);

	$rm_state_array['warning'][] = array(
		'caption' => '<strong>Readymag Importer</strong>: before using the plugin, check requirements in the <a href="/wp-admin/edit.php?post_type=rm_project&page=rm-importer-settings">settings</a>.',
		'_unescaped' => true
	);

	update_option('_rm_redirect_state_save', $rm_state_array);

}

function rm_on_plugin_deactivate() {
	if ( ! current_user_can( 'activate_plugins' ) )
			return;

	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "deactivate-plugin_{$plugin}" );

	rm_cm_remove_advanced_cache();
	rm_cm_remove_hard_patch();
}

function rm_on_plugin_uninstall() {
	if ( ! current_user_can( 'activate_plugins' ) )
		return;

	$projects = get_option('rm-imported-projects');

	foreach($projects as $project)
		wp_delete_post( $project['post_id'], true );

	delete_option('rm-imported-projects');
	delete_option('rm-imported-projects-index');
	delete_option('_rm_redirect_state_save');
	delete_option('rm-importer-settings');

	unlink(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache.php');
	unlink(WP_CONTENT_DIR . '/rm-projects/rm-advanced-cache-config.php');

	return true;
}

register_activation_hook( __FILE__, 'rm_on_plugin_activate' );
register_deactivation_hook( __FILE__, 'rm_on_plugin_deactivate' );
register_uninstall_hook( __FILE__, 'rm_on_plugin_uninstall' );