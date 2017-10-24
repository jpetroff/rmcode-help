<?php

function rm_recursive_output($id, $current_level, &$levels, &$all) {
	global $create_nav, $current_page;
	
	if ($current_level == 1 || $current_level == 2) {
		$create_nav[] = array(
			'caption' => $all[$id]->post_title,
			'link' => $current_level == 1 ? $current_page : $current_page."#".$all[$id]->post_name,
			'level' => $current_level == 1 ? 'top' : 'secondary'
		);
	}
	
	$section_id = $all[$id]->post_name;
	$output = "<div data-level=\"$current_level\" id=\"$section_id\">";
	
	$output .= "<h$current_level class=\"single-page__header-$current_level\">".$all[$id]->post_title."</h$current_level>";
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
	$_all_cards = $q->query( array( 'post_type' => 'card', 'posts_per_page' => '-1' ) );
	
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
	
//	return '<pre>'.print_r($output, true).'</pre>';
	return $output;
}
add_shortcode('output', 'rm_output_shortcode');

function rm_media_send_to_editor( $code, $id, $meta ) {
	$att_meta = wp_get_attachment_metadata( $id );
	$image_size = $meta['image-size'];
	$image_filepath = dirname( wp_get_attachment_url($id) );
	$retina_meta = get_post_meta($id, '_rm_attachment_metadata', true);
	
	$w = $image_size == 'full' ? $att_meta['width'] : $att_meta['sizes'][$image_size]['width'];
	$h = $image_size == 'full' ? $att_meta['height'] : $att_meta['sizes'][$image_size]['height'];
	$fn = $image_size == 'full' ? $image_filepath.'/'.$att_meta['file'] : $image_filepath.'/'.$att_meta['sizes'][$image_size]['file'];
	$rfn = $image_size == 'full' ? $image_filepath.'/'.$retina_meta['file'] : $image_filepath.'/'.$retina_meta['sizes'][$image_size]['file'];
	$prefix = "<p class=\"image-wrapper\" contenteditable=\"false\" >[img w=\"$w\" h=\"$h\" f=\"$fn\" rf=\"$rfn\"]";
	
	$editor_content = "<img src=\"$fn\" width=$w height=$h />";
	
	$suffix = "[/img]</p>";
	
	return $prefix.$editor_content.$suffix;
}
add_filter('media_send_to_editor', 'rm_media_send_to_editor', 0, 3);

function rm_img_shortcode( $atts, $content ) {
	$w = $atts['w'];
	$h = $atts['h'];
	$img_1x = $atts['f'];
	$img_2x = $atts['rf'];
	
	return "<img class=\"page-content__responsive-image\" width=\"$w\" height=\"$h\" src=\"$img_1x\" srcset=\"$img_2x 2x\" />";
}
add_shortcode('img', 'rm_img_shortcode');