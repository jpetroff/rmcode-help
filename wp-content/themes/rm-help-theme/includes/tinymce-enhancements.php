<?php

/**
 * Registers an editor stylesheet for the theme.
 */
function rm_theme_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'rm_theme_add_editor_styles' );

function disable_wysiwyg_to_preserve_my_markup( $default ){
	if( get_post_type() === 'page') return false;
	return $default;
}
add_filter('user_can_richedit', 'disable_wysiwyg_to_preserve_my_markup');