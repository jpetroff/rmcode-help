<?php

function rm_img_shortcode( $atts, $content ) {
	$margin = 46;
	$w = $atts['w'];
	$h = $atts['h'];
	$img_1x = parse_url($atts['f'], PHP_URL_PATH);
	$img_2x = parse_url($atts['rf'], PHP_URL_PATH);
	$ratio = $h/$w;
	$content = $content != '' ? preg_replace("#(</?p>|\n|<br *>)#i", '', $content) : '';
	
	$_p_top = floor($margin * $ratio);
	$_p_bottom = floor(100 * $ratio);
	
	return "<div class='page-content__responsive-wrapper' style='padding-top: {$_p_top}px; padding-bottom: {$_p_bottom}%'><img class=\"page-content__responsive-image\" width=\"$w\" height=\"$h\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7\" v-lazy=\"'$img_1x'\" data-srcset=\"$img_2x 2x\" />{$content}</div>";
}
add_shortcode('img', 'rm_img_shortcode');

function rm_video_shortcode( $atts, $content ) {
	$margin = 46;
	$w = $atts['width'];
	$h = $atts['height'];
	$src = parse_url($atts['src'], PHP_URL_PATH);
	$autoplay = $atts['autoplay'] == 'on' ? 'autoplay' : '';
	$loop = $atts['loop'] == 'on' ? 'loop' : '';
	$controls = $atts['controls'] == 'on' ? 'controls' : '';
	$ratio = $h/$w;
	
	$_p_top = floor($margin * $ratio);
	$_p_bottom = floor(100 * $ratio);
	
	return "<div class='page-content__responsive-wrapper' style='padding-top: {$_p_top}px; padding-bottom: {$_p_bottom}%'>
			<lazy-component tag='div' style='width:{$w}px;height:{$h}px;' class='extra-video-wrapper'>
				<video v-video class=\"page-content__responsive-video\" width=\"$w\" height=\"$h\" v-bind:src=\"'$src'\" $autoplay $controls $loop></video>
			</lazy-component>
			</div>";
}
remove_shortcode('video');
add_shortcode('video', 'rm_video_shortcode');

function rm_recursive_output($id, $current_level, &$levels, &$all) {
	global $create_nav, $current_page;
	
	$link = $current_level == 1 ? $current_page : $current_page."#".$all[$id]->post_name;
	
	if ($current_level == 1 || $current_level == 2) {
		$create_nav[] = array(
			'caption' => $all[$id]->post_title,
			'link' => $link,
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
	
	$pseudo_link = "<a class='direct-anchor' ref='nofollow' href='$link'>#</a>";
	$_sp = ($current_level == 5 ? '.&nbsp;' : '');
	$output .= "<h$_current_level class=\"single-page__header single-page__header-$_current_level\">".$section_title.$_sp.$pseudo_link."</h$_current_level>";
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
	
	$patterns = ["#^(\s*?(</p>)?)#i", "#((<p>)?\s*?)?$#i"];
	$content = preg_replace_callback($patterns, function($matches) {
		return '';
	}, $content);
	
	$content = apply_filters('the_content', $content);
	$content = trim($content, " \n");
	
	if ($content != '') {
		$output = "<div is='hint' header='$header'> $content </div>";
	} else {
		$output = "<div class='def-hint-box def-hint-box_non-interactive'><p>$header</p></div>";
	}
	
	return $output;
}
add_shortcode('hint', 'rm_hint_box_shortcode');
add_shortcode('note', 'rm_hint_box_shortcode');
add_shortcode('hints', 'rm_hint_box_shortcode');
add_shortcode('notes', 'rm_hint_box_shortcode');

add_filter( 'the_content', 'rm_content_filter', 100);
function rm_content_filter( $content ) {
	$emptyp = "#<p>\s*?</p>#i";
	$content = preg_replace_callback($emptyp, function($matches) {
		return '';
	}, $content);
	
	$empty_nbsp = "#<p>\s*?&nbsp;\s*?</p>#i";
	$content = preg_replace_callback($empty_nbsp, function($matches) {
		return '';
	}, $content);
	
	$content = do_shortcode($content);
	
	return $content;
}

add_shortcode('code', 'rm_code_block_shortcode');
function rm_code_block_shortcode( $atts, $content ) {
	$content = trim($content, "\n ");
	$content = preg_replace_callback('#<\s*br\s*/>#i', function($matches) {
		return "";
	}, $content);
	
	$content = preg_replace_callback('#</?p>#i', function($matches) {
		return "";
	}, $content);
	
	return $content;
}