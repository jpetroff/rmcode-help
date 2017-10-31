<?php

$templs['left'] = "";

$templs['home'] = "<a href=\"%s\" class=\"second-level__item def-link\" v-rlink>%s</a>";

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

add_action( 'wp_ajax_api_page', 'rm_send_ajax_page' );
add_action( 'wp_ajax_nopriv_api_page', 'rm_send_ajax_page' );

function rm_send_ajax_page( $wp ) {
	global $wp_the_query;
	
	if($wp->query_vars['api-page'] == '_front') {
		$wp->query_vars['page_id'] = get_option( 'page_on_front' );
		$template = '/helper-page-front.php';
	} else {
		$wp->query_vars['pagename'] = $wp->query_vars['api-page'];
		$wp->query_vars['post_type'] = 'page';
		$template = '/helper-page.php';
	}
	
	unset($wp->query_vars['api-page']);
	
	$wp->query_posts();
	
	header('Content-Type: text/html');
	
	include RM_HELP_THEME_DIR.$template;
}