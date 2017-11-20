<?php

function rm_img_shortcode( $atts, $content ) {
	$w = $atts['w'];
	$h = $atts['h'];
	$img_1x = $atts['f'];
	$img_2x = $atts['rf'];
	
	return "<img class=\"page-content__responsive-image\" width=\"$w\" height=\"$h\" src=\"$img_1x\" srcset=\"$img_2x 2x\" />";
}
add_shortcode('img', 'rm_img_shortcode');

function rm_video_shortcode( $atts, $content ) {
	$w = $atts['width'];
	$h = $atts['height'];
	$src = $atts['src'];
	$autoplay = $atts['autoplay'] == 'on' ? 'autoplay' : '';
	$loop = $atts['loop'] == 'on' ? 'loop' : '';
	$controls = $atts['controls'] == 'on' ? 'controls' : '';
	
	return "<video class=\"page-content__responsive-video\" width=\"$w\" height=\"$h\" src=\"$src\" $autoplay $controls $loop></video>";
}
remove_shortcode('video');
add_shortcode('video', 'rm_video_shortcode');

function rm_recursive_output($id, $current_level, &$levels, &$all) {
	global $create_nav, $current_page;
	
	if ($current_level == 1 || $current_level == 2) {
		$create_nav[] = array(
			'caption' => $all[$id]->post_title,
			'link' => $current_level == 1 ? $current_page : $current_page."#".$all[$id]->post_name,
			'level' => $current_level == 1 ? 'top' : 'secondary',
			'post_name' => $all[$id]->post_name
		);
	}
	
	$card_meta = get_post_meta( $id, '_rm_card_attributes', true);
	$_current_level = $current_level;
	if( $card_meta && isset($card_meta['output_level']) && $card_meta['output_level'] != 0) {
		$_current_level = $card_meta['output_level'];
	}
	
	$section_id = $all[$id]->post_name;
	$section_id_decl = $_current_level != 1 ? "id='$section_id'" : '';
	$section_title = $all[$id]->post_title;
	$output = "<div class=\"card_level_$_current_level\" data-level=\"$_current_level\" data-title=\"$section_title\" $section_id_decl v-navblock>";
	
	$output .= "<h$_current_level class=\"single-page__header-$_current_level\">".$section_title."</h$_current_level>";
	$output .= apply_filters('the_content', $all[$id]->post_content);
	
	$output .= "</div>";
	
	if ($levels[$id]) {
		foreach ($levels[$id] as $next_id) {
			$output .= rm_recursive_output($next_id, $current_level + 1, $levels, $all);
		}
	}
	
	return $output;
}


function rm_output_shortcode( $_atts ) {
	global $create_nav;
	
	$output = '';
	$atts = shortcode_atts( array(
		'parent' => NULL,
		'all' => false
	), $_atts);
	
	if(!$atts['parent']) return $output;
	
	$q = new WP_Query();
	$_all_cards = $q->query( array( 'post_type' => 'card', 'posts_per_page' => '-1', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
	
	$all_cards = [];
	foreach ($_all_cards as $item) {
		$all_cards[$item->ID] = $item;
	}
	
	$_cards = get_page_children( $atts['parent'], $all_cards );
	$cards = [];
	$levels = [];
	foreach ($_cards as $_card) {
		$cards[$_card->ID] = $_card;
		
		if(!$levels[$_card->post_parent]) $levels[$_card->post_parent] = [];
		array_push($levels[$_card->post_parent], $_card->ID);
	}
	
	$output = rm_recursive_output($atts['parent'], 1, $levels, $all_cards);
	
	return $output;
}
add_shortcode('output', 'rm_output_shortcode');

function rm_hint_box_shortcode( $atts, $content, $tag) {
	$header = (isset($atts['title']) && $atts['title'] != '') ? $atts['title'] : ucfirst($tag);
	
	$pattern = "#</?p *>#i";
	$content = wpautop(preg_replace($pattern, '', $content));
	
	$emptyp = "#<p>\s*</p>#i";
	$content = preg_replace($emptyp, '', $content);
	
	$output = "<div is='hint' header='$header'> $content </div>";
	
	return $output;
}
add_shortcode('hint', 'rm_hint_box_shortcode');
add_shortcode('note', 'rm_hint_box_shortcode');
add_shortcode('hints', 'rm_hint_box_shortcode');
add_shortcode('notes', 'rm_hint_box_shortcode');