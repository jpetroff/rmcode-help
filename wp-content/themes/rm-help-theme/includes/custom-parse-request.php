<?php

// Rewrite rules generated in wp-admin, located in theme-rewrite-rules.php

function rm_query_vars( $query_vars ){
	$query_vars[] = 'api-page';
	$query_vars[] = 'api-search';
	return $query_vars;
}
add_filter( 'query_vars', 'rm_query_vars' );

function rm_parse_request( $wp ){
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

/**
 * Tell WP Super Cache to cache API endpoints
 *
 * @param string $eof_pattern
 *
 * @return string
 */
function rm_ajax_cache_requests( $eof_pattern ) {
	global $wp_super_cache_comments;
	
	if ( defined( 'DOING_AJAX' ) ) {
		// Accept a JSON-formatted string as an end-of-file marker, so that the page will be cached
		$json_object_pattern     = '^[{].*[}]$';
		$json_collection_pattern = '^[\[].*[\]]$';
		
		$eof_pattern = str_replace(
			'<\?xml',
			sprintf( '<\?xml|%s|%s', $json_object_pattern, $json_collection_pattern ),
			$eof_pattern
		);
		
		// Don't append HTML comments to the JSON output, because that would invalidate it
		$wp_super_cache_comments = false;
	}
	
	return $eof_pattern;
}
//add_filter( 'wp_cache_eof_tags', 'rm_ajax_cache_requests' );