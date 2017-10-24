<?php

add_action('init', 'rm_help_register_card');
function rm_help_register_card() {
	$labels = array(
		'name'               => _x( 'Cards', 'post type general name' ),
		'singular_name'      => _x( 'Card', 'post type singular name' ),
		'menu_name'          => _x( 'Cards', 'admin menu' ),
		'name_admin_bar'     => _x( 'Card', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'card' ),
		'add_new_item'       => __( 'Add New Card' ),
		'new_item'           => __( 'New Card' ),
		'edit_item'          => __( 'Edit Card' ),
		'view_item'          => __( 'View Card' ),
		'all_items'          => __( 'All Cards' ),
		'search_items'       => __( 'Search Cards' ),
		'parent_item_colon'  => __( 'Parent Cards:' ),
		'not_found'          => __( 'No cards found.' ),
		'not_found_in_trash' => __( 'No cards found in Trash.' )
	);
	
	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Help cards' ),
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'page-attributes' )
	);
	
	register_post_type( 'card', $args );
}