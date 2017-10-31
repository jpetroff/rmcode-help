<?php

add_action('after_switch_theme', 'rm_help_setup_options');
function rm_help_setup_options () {
	flush_rewrite_rules();
}

add_action('generate_rewrite_rules', 'rm_generate_rewrite_rules');
function rm_generate_rewrite_rules( $wp_rewrite ) {
	$ajax_rules = array(
		'^api/page/(.*)$' => 'index.php?api-page=$matches[1]',
		'^search$' => 'index.php?api-search=true'
	);
	
	$wp_rewrite->rules = $ajax_rules + $wp_rewrite->rules;
	file_put_contents(RM_HELP_THEME_DIR.'/rewrite.log', print_r($wp_rewrite->rules, true) );
	return $wp_rewrite->rules;
}