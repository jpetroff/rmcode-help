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
//	return '<pre>'.print_r($q->posts, true).'</pre>';
}
add_shortcode('nav', 'rm_show_menu_shortcode');