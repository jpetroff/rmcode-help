<?php

$templs['home'] = "<a href=\"%s\" class=\"second-level__item def-link\" v-rlink>%s</a>";

$templs['content'] = "";

function rm_show_menu_shortcode( $atts ) {
	global $templs;
	$output = '';
	
	$a = shortcode_atts( array(
		'parent' => NULL,
		'page' => NULL,
		'template' => 'home',
		'color' => '#ff0000',
		'icon' => ''
	), $atts );
	
	if(!$a['parent']) return $output;
	
	$args = array(
		'post_type' => 'card',
		'post_parent' => $a['parent']
	);
	$q = new WP_Query( $args );
	
	$link_index = get_option('_rm_card_link_index');
	
	$parent_card = (int) $a['parent'];
	$setPage = $a['page'] ? $a['page'] : trim(parse_url($link_index[$parent_card]['permalink'], PHP_URL_PATH), '/');
	
	if($a['template'] == 'home') {
		$setTitle = $link_index[$parent_card]['title'];
		$setIcon = $a['icon'];
		$hasColor = $a['color'] ? 'style="color:'.$a['color'].'"' : '';
		$output .= "
		<div class=\"homepage__section-list section-list__editor\" $hasColor>
				<a href=\"/$setPage/\" v-rlink class=\"homepage__section-list__top-level\">
					<div class=\"top-level__icon\">
						$setIcon
					</div>
					<div class=\"top-level__caption\">
						$setTitle
					</div>
				</a>
				<div class=\"homepage__section-list__second-level\">
		";
	}
	
	
	if(count($q->posts) != 0) {
		foreach ($q->posts as $card) {
			$url = '/' . $setPage . '/#' . $card->post_name;
			$newline = sprintf($templs[$a['template']],  $url, $card->post_title);
			$output .= $newline;
		}
	}
	
	if($a['template'] == 'home') {
		$output .= "</div>
			</div>";
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