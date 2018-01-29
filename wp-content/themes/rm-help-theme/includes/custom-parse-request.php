<?php

// Rewrite rules generated in wp-admin, located in theme-rewrite-rules.php

function rm_query_vars( $query_vars ){
	$query_vars[] = 'api-page';
	$query_vars[] = 'api-search';
//	$query_vars[] = 'limit';
	return $query_vars;
}
add_filter( 'query_vars', 'rm_query_vars' );

function rm_parse_request( $wp ){
	if ( is_admin() ) {
		unset($wp->query_vars['attachment']);
	}
	
	if( array_key_exists( 'api-page', $wp->query_vars ) ) {
		$action_prefix = is_user_logged_in() ? 'wp_ajax_' : 'wp_ajax_nopriv_';
		define('DOING_AJAX', 1);
		do_action( $action_prefix . 'api_page', $wp );
		echo '<!--</html>-->';
		do_action('shutdown');
		wp_die();
	}
	
	if( array_key_exists( 'api-search', $wp->query_vars ) ) {
		if( !isset($wp->query_vars['s']) || $wp->query_vars['s'] == '' ) {
			$wp->query_vars = array( 'error' => '404' );
		} else {
			$action_prefix = is_user_logged_in() ? 'wp_ajax_' : 'wp_ajax_nopriv_';
			define('DOING_AJAX', 1);
			do_action( $action_prefix . 'search', $wp );
			do_action('shutdown');
			wp_die();
		}
		
	}
}
add_action( 'parse_request', 'rm_parse_request' );

add_filter( 'site_url',  'wpadmin_filter', 10, 3 );
function wpadmin_filter( $url, $path, $orig_scheme ) {
	return preg_replace( "/(wp-admin)/", WP_ADMIN_DIR, $url, 1 );
}

add_action( 'login_form', 'redirect_wp_admin' );

function redirect_wp_admin(){
	$redirect_to = $_SERVER['REQUEST_URI'];

	if ( count( $_REQUEST ) > 0 && array_key_exists( 'redirect_to', $_REQUEST ) ) {
		$check_wp_admin = stristr( $_REQUEST['redirect_to'], 'wp-admin' );
		if( $check_wp_admin ) {
			wp_redirect( home_url() );
			exit;
		}
	}
}