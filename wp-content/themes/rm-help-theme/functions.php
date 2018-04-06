<?php

define( 'RM_HELP_THEME_DIR', __DIR__);

if( !@include(__DIR__.'/includes/cache-prevent.php') ) {
	function rm_build_timestamp() {
		return '0000000000';
	}
}

// Custom post type 'cards'
include __DIR__.'/includes/cards-type.php';

// Navigation shortcodes
include __DIR__.'/includes/navigation.php';

// content shortcodes
include __DIR__.'/includes/shortcodes.php';

// ajax search
include __DIR__.'/includes/ajax-search.php';

// Custom parse_request for AJAX API
include __DIR__.'/includes/custom-parse-request.php';

if( is_admin() ) {
	include __DIR__.'/includes/theme-rewrite-rules.php';
	include __DIR__.'/includes/edit-helpers.php';
	include __DIR__.'/includes/tinymce-enhancements.php';
	include __DIR__.'/includes/handle-images.php';
}

$foo = function( $args, $assoc_args ) {
	WP_CLI::success( $args[0] . ' ' . $assoc_args['append'] );
};
WP_CLI::add_command( 'foo', $foo );