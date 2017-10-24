<?php

//add_action( 'after_wp_tiny_mce', 'rm_after_wp_tiny_mce' );
function rm_after_wp_tiny_mce() {
	printf( '<script type="text/javascript" src="%s"></script>',  plugins_url('/js/editor.js', __FILE__) );
}

/**
 * Registers an editor stylesheet for the theme.
 */
function rm_theme_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'rm_theme_add_editor_styles' );

//function rm_autop( $content ) {
//	return $content;
//}
//remove_filter('the_content', 'wpautop');
//add_filter('the_content', 'rm_autop');

function rm_format_TinyMCE( $in ) {
	$in['paste_remove_styles'] = true;
	$in['wpautop'] = true;
	$in[ 'valid_children' ]="+a[div|p|ul|ol|li|h1|span|h2|h3|h4|h5|h5|h6]";
	$in[ 'force_p_newlines' ] = FALSE;
	$in[ 'remove_linebreaks' ] = FALSE;
	$in[ 'force_br_newlines' ] = true;
	$in[ 'remove_trailing_nbsp' ] = FALSE;
	$in[ 'apply_source_formatting' ] = FALSE;
	$in[ 'convert_newlines_to_brs' ] = true;
	$in[ 'verify_html' ] = FALSE;
	$in[ 'remove_redundant_brs' ] = FALSE;
	$in[ 'validate_children' ] = FALSE;
	$in[ 'forced_root_block' ]= FALSE;
	return $in;
}
//add_filter( 'tiny_mce_before_init', 'rm_format_TinyMCE' );

function disable_wysiwyg_to_preserve_my_markup( $default ){
	if( get_post_type() === 'page') return false;
	return $default;
}
add_filter('user_can_richedit', 'disable_wysiwyg_to_preserve_my_markup');

/**
 * Add styles/classes to the "Styles" drop-down
 */
//add_filter( 'tiny_mce_before_init', 'rm_mce_before_init' );
function rm_mce_before_init( $settings ) {
	
	$style_formats = array(
		array(
			'title' => 'Download Link',
			'selector' => 'a',
			'classes' => 'download'
		),
		array(
			'title' => 'My Test',
			'selector' => 'p',
			'classes' => 'mytest',
		),
		array(
			'title' => 'AlertBox',
			'block' => 'div',
			'classes' => 'alert_box',
			'wrapper' => true
		),
		array(
			'title' => 'Red Uppercase Text',
			'inline' => 'span',
			'styles' => array(
				'color'         => 'red', // or hex value #ff0000
				'fontWeight'    => 'bold',
				'textTransform' => 'uppercase'
			)
		)
	);
	
	$settings['style_formats'] = json_encode( $style_formats );
	
	return $settings;
}