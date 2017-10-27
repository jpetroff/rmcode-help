<?php

$templs['left'] = "";

$templs['home'] = "<a href=\"%s\" class=\"second-level__item def-link\">%s</a>";

$templs['content'] = "";

function rm_show_menu_shortcode( $atts ) {
	global $templs;
	$output = '';
	
	$a = shortcode_atts( array(
		'parent' => NULL,
		'page' => '/',
		'template' => 'left'
	), $atts );
	
	if(!$a['parent']) return $output;
	
	$args = array(
		'post_type' => 'card',
		'post_parent' => $a['parent']
	);
	$q = new WP_Query( $args );
	
	if(count($q->posts) == 0) return $output;
	
	foreach ($q->posts as $card) {
		$url = '/' . trim($a['page']) . '/#' . $card->post_name;
		$newline = sprintf($templs[$a['template']],  $url, $card->post_title);
		$output .= $newline;
	}
	
	return $output;
}
add_shortcode('nav', 'rm_show_menu_shortcode');

function rm_ajax_page_request(){
	add_rewrite_rule( '^api/page/(.*)$', 'index.php?api_page=$matches[1]', 'top' );
	// @TODO: перенести в установку темы
	flush_rewrite_rules();
}
add_action( 'init', 'rm_ajax_page_request' );

function rm_query_vars( $query_vars ){
	$query_vars[] = 'api_page';
	return $query_vars;
}
add_filter( 'query_vars', 'rm_query_vars' );

function rm_parse_request( $wp ){
	if( array_key_exists( 'api_page', $wp->query_vars ) ) {
		$action_prefix = is_user_logged_in() ? 'wp_ajax_' : 'wp_ajax_nopriv_';
		define('DOING_AJAX', 1);
		do_action( $action_prefix . 'api_page', $wp );
		die(0);
	}
}
add_action( 'parse_request', 'rm_parse_request' );

add_action( 'wp_ajax_api_page', 'rm_send_ajax_page' );
add_action( 'wp_ajax_nopriv_api_page', 'rm_send_ajax_page' );

function rm_send_ajax_page( $wp ) {
	global $wp_the_query;
	
	$wp->query_vars['pagename'] = $wp->query_vars['api_page'];
	$wp->query_vars['post_type'] = 'page';
	unset($wp->query_vars['api-page']);
	
	$wp->query_posts();
	
	$post = $wp_the_query->queried_object;
	$content = apply_filters('the_content', $post->post_content);
	
	header('Content-Type: text/html');
	
	echo $content;
}