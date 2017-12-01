<?php

$templs['home'] = "<a href=\"%s\" class=\"second-level__item def-link\" v-rlink>%s</a>";

$templs['content'] = '<a href="%1$s" class="content-navigation__item"><div class="content-navigation__item_icon">%3$s</div><div class="content-navigation__item_caption">%2$s</div></a>';

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
		'post_parent' => $a['parent'],
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	$q = new WP_Query( $args );
	
	$link_index = get_option('_rm_card_link_index');
	
	$parent_card = (int) $a['parent'];
	$setPage = $a['page'] ? $a['page'] : trim(parse_url($link_index[$parent_card]['permalink'], PHP_URL_PATH), '/');
	
	if($a['template'] == 'home') {
		$setTitle = $link_index[$parent_card]['title'];
		$setIcon = $a['icon'];
		$hasColor = $a['color'] ? 'style="color:'.$a['color'].'"' : '';
		$iconColor = $a['color'] ? 'style="background:'.$a['color'].'"' : '';
		$output .= "
		<div class=\"homepage__section-list section-list__editor\" $hasColor>
				<a href=\"/$setPage/\" v-rlink class=\"homepage__section-list__top-level\">
					<div class=\"top-level__icon\" $iconColor>
						$setIcon
					</div>
					<div class=\"top-level__caption\">
						$setTitle
					</div>
				</a>
				<div class=\"homepage__section-list__second-level\">
		";
		
		if(count($q->posts) != 0) {
			foreach ($q->posts as $card) {
				$url = '/' . $setPage . '/#' . $card->post_name;
				$newline = sprintf($templs['home'],  $url, $card->post_title);
				$output .= $newline;
			}
		}
		
		$output .= "</div>
			</div>";
	}
	
	if($a['template'] == 'content') {
		$posts_cnt = count($q->posts);
		$rows = intdiv($posts_cnt, 3);
		$curr_row = -1;
		$item_cnt = 0;
		foreach ($q->posts as $card) {
			$url = '/' . $setPage . '/#' . $card->post_name;
			
			$post_thumb = get_the_post_thumbnail_url($card->ID, 'card-thumb');
			$post_thumb_2x = get_the_post_thumbnail_url($card->ID, 'card-thumb-2x');
			
			if(!$post_thumb) {
				$post_thumb = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
				$img_elem = '<img src="'.$post_thumb.'" width=205 height=180 />';
			} else {
				$img_elem = '<img src="'.$post_thumb.'" srcset="'.$post_thumb_2x.' 2x" />';
			}
			
			$newline = sprintf($templs['content'],  $url, $card->post_title, $img_elem);
			
			$row_class = '';
			
			if($item_cnt % 3 == 0) {
				$curr_row += 1;
				
				if($curr_row == 0)
					$row_class .= ' single-page__content-navigation_first-row';
				
				if($curr_row == $rows)
					$row_class .= ' single-page__content-navigation_last-row';
				
				if($curr_row != 0)
					$output .= "</div>";
				
				$output .= "<div class=\"single-page__content-navigation row $row_class\">";
			}
			
			$output .= $newline;
			
//			if($item_cnt % 3 == 0)
			$item_cnt++;
		}
		$output .= "</div>";
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