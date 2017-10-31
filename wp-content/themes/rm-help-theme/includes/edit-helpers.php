<?php

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


add_action( 'add_meta_boxes', 'rm_card_add_meta_box' );
function rm_card_add_meta_box()
{
	add_meta_box(
		'rm-card-meta-box', // id, used as the html id att
		__( 'Attributes' ), // meta box title, like "Page Attributes"
		'rm_card_meta_box_cb', // callback function, spits out the content
		'card', // post type or page. We'll add this to pages only
		'side', // context (where on the screen)
		'low' // priority, where should this go in the context?
	);
}

/**
 * Callback function for our meta box.  Echos out the content
 */
function rm_card_meta_box_cb( $post )
{
	$post_name = $post->post_name;
	$output = "
		<p class=\"post-attributes-label-wrapper\"><label class=\"post-attributes-label\" for=\"rm_post_name\">Card URI</label></p>
		<input name=\"rm_post_name\" type=\"text\" id=\"rm_post_name\" value=\"$post_name\">
	";
	
	
	$output .= "<p class=\"post-attributes-label-wrapper\"><label class=\"post-attributes-label\" for=\"post_name\">Default Page</label></p>";
	
	if ( $post->post_parent == 0 ) {
		$pages = get_pages();
		$meta = get_post_meta( $post->ID, '_rm_card_attributes', true);
		
		$output .= "<select name='default_page' id='default_page'><option value='(not set)'>(not set)</option>";
		foreach ($pages as $page) {
			$page_id = $page->ID;
			$page_title = $page->post_title;
			$is_selected = (isset($meta['default_page']) && $meta['default_page'] == $page->ID ) ? 'selected' : '';
			$output .= "<option value='$page_id' $is_selected>$page_title</option>";
		}
		$output .= "</select>";
	} else {
		$parents = get_post_ancestors( $post->ID );
		$top_parent_id = $parents[ count($parents) - 1 ];
		$top_parent_meta = get_post_meta( $top_parent_id, '_rm_card_attributes', true);
		$related_page_title = ($top_parent_meta && isset($top_parent_meta['default_page'])) ? get_the_title($top_parent_meta['default_page']) : '(not set)';
		$output .= "<p><strong>$related_page_title</strong></p>";
	}
	echo $output;
}

add_action( 'save_post', 'rm_card_save', 0 );
function rm_card_save( $post_id ) {
	if( $_POST['post_type'] != 'card') return;
	
	$new_post_name = trim(sanitize_title_with_dashes($_POST['rm_post_name']), '-');
	if($new_post_name == '') $new_post_name = trim(sanitize_title_with_dashes($_POST['post_title']), '/');
	$_POST['post_name'] = $new_post_name;
	
	$link_index = get_option('_rm_card_link_index');
	if(!$link_index) $link_index = array();
	if( !isset($_POST['parent_id']) || $_POST['parent_id'] == '') {
		
		// saving index card
		if ( isset($_POST['default_page']) && $_POST['default_page'] != '(not set)' ) {
			$link_index[$post_id] = array( 'permalink' => get_page_link( $_POST['default_page'] ), 'title' => get_the_title( $_POST['default_page'] ) );
			update_post_meta($post_id, '_rm_card_attributes', array( 'default_page' => $_POST['default_page']) );
		} else {
			unset($link_index[$post_id]);
			update_post_meta($post_id, '_rm_card_attributes', array() );
		}
		
	} else {
		
		// saving child card
		$parents = get_post_ancestors( $post_id );
		$top_parent_id = $parents[ count($parents) - 1 ];
		$link_index[$post_id] = (int) $top_parent_id;
		
	}
	
	update_option('_rm_card_link_index', $link_index);
}

add_action( 'delete_post', 'rm_card_delete' );
function rm_card_delete( $post_id ) {
	$post_type = get_post_type( $post_id );
	if( $post_type != 'card' ) return;
	
	$link_index = get_option('_rm_card_link_index');
	
	unset($link_index[$post_id]);
	update_option('_rm_card_link_index', $link_index);
}