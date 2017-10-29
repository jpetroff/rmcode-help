<?php

define( 'RM_HELP_THEME_DIR', __DIR__);

// Custom post type 'cards'
include __DIR__.'/includes/cards-type.php';

// Navigation shortcodes
include __DIR__.'/includes/navigation.php';

// content shortcodes
include __DIR__.'/includes/shortcodes.php';

// ajax search
include __DIR__.'/includes/ajax-search.php';

if( is_admin() ) {
	include __DIR__.'/includes/edit-helpers.php';
	include __DIR__.'/includes/tinymce-enhancements.php';
	include __DIR__.'/includes/handle_images.php';
}