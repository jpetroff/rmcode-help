<?php

function rm_media_send_to_editor( $code, $id, $meta ) {
	$att_meta = wp_get_attachment_metadata( $id );
	
	if(wp_attachment_is('image', $id)) {
		$image_size = $meta['image-size'];
		$image_filepath = dirname(wp_get_attachment_url($id));
		$retina_meta = get_post_meta($id, '_rm_attachment_metadata', true);
		
		$w = $image_size == 'full' ? $att_meta['width'] : $att_meta['sizes'][$image_size]['width'];
		$h = $image_size == 'full' ? $att_meta['height'] : $att_meta['sizes'][$image_size]['height'];
		$fn = $image_size == 'full' ? $image_filepath . '/' . $att_meta['file'] : $image_filepath . '/' . $att_meta['sizes'][$image_size]['file'];
		$rfn = $image_size == 'full' ? $image_filepath . '/' . $retina_meta['file'] : $image_filepath . '/' . $retina_meta['sizes'][$image_size]['file'];
		
		$fn = parse_url($fn, PHP_URL_PATH);
		$rfn = parse_url($rfn, PHP_URL_PATH);
		
		$prefix = "[img w=\"$w\" h=\"$h\" f=\"$fn\" rf=\"$rfn\"]";
		
		return $prefix;
	}
	
	if(wp_attachment_is('video', $id)) {
		$src = parse_url(wp_get_attachment_url($id), PHP_URL_PATH);
		$scaling = 700 / $att_meta['width'];
		$w = 700;
		$h = floor($att_meta['height'] * $scaling);
		
		return "[video src=\"$src\" width=\"$w\" height=\"$h\" autoplay=on loop=on controls=off]";
	}
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
	// Card URI
	$post_name = $post->post_name;
	$output = "
		<p class=\"post-attributes-label-wrapper\"><label class=\"post-attributes-label\" for=\"rm_post_name\">Card URI</label></p>
		<input name=\"rm_post_name\" type=\"text\" id=\"rm_post_name\" value=\"$post_name\">
	";
	
	// Output level
	$card_meta = get_post_meta( $post->ID, '_rm_card_attributes', true);
	$card_level = 0;
	if( isset($card_meta) && isset($card_meta['output_level']) ) {
		$card_level = (int) $card_meta['output_level'];
	}
	$output .= "
		<p class=\"post-attributes-label-wrapper\"><label class=\"post-attributes-label\" for=\"rm_post_name\">Card URI</label></p>
	";
	
	// Page attribution
	$output .= "<p class=\"post-attributes-label-wrapper\"><label class=\"post-attributes-label\" for=\"post_name\">Level</label></p>";
	$output .= "
		<select name='output_level'>
			<option value ".($card_level == 0 ? 'selected' : '').">default</option>
			<option value='1' ".($card_level == 1 ? 'selected' : '').">h1</option>
			<option value='2' ".($card_level == 2 ? 'selected' : '').">h2</option>
			<option value='3' ".($card_level == 3 ? 'selected' : '').">h3</option>
			<option value='4' ".($card_level == 4 ? 'selected' : '').">h4</option>
		</select>
	";
	
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

add_action( 'save_post', 'rm_card_save' );
function rm_card_save( $post_id ) {
	if( $_POST['post_type'] != 'card') return;
	
	$card_meta  = get_post_meta( $post_id, '_rm_card_attributes', true);
	if( !$card_meta ) $card_meta = array();
	
	// Output level
	if( isset($_POST['output_level']) && $_POST['output_level'] != '' ) {
		$card_meta['output_level'] = (int) $_POST['output_level'];
	} else {
		unset($card_meta['output_level']);
	}
	
	// Card slug
	$new_post_name = trim(sanitize_title_with_dashes($_POST['rm_post_name']), '-');
	if($new_post_name != '') {
		remove_action( 'save_post', 'rm_card_save' );
		
		wp_update_post( array(
			'ID' => $post_id,
			'post_name' => $new_post_name
		) );
		
		add_action( 'save_post', 'rm_card_save' );
	}
	
	// Default page and parent index
	$link_index = get_option('_rm_card_link_index');
	if(!$link_index) $link_index = array();
	if( !isset($_POST['parent_id']) || $_POST['parent_id'] == '') {
		
		// saving index card
		if ( isset($_POST['default_page']) && $_POST['default_page'] != '(not set)' ) {
			$link_index[$post_id] = array( 'permalink' => get_page_link( $_POST['default_page'] ), 'title' => get_the_title( $_POST['default_page'] ) );
//			update_post_meta($post_id, '_rm_card_attributes', array( 'default_page' => $_POST['default_page']) );
			$card_meta['default_page'] = $_POST['default_page'];
		} else {
			unset($link_index[$post_id]);
//			update_post_meta($post_id, '_rm_card_attributes', array() );
			unset($card_meta['default_page']);
		}
		
	} else {
		
		// saving child card
		$parents = get_post_ancestors( $post_id );
		$top_parent_id = $parents[ count($parents) - 1 ];
		$link_index[$post_id] = (int) $top_parent_id;
		
	}
	
	update_post_meta($post_id, '_rm_card_attributes', $card_meta );
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

function rm_tinymce_plugin($plugin_array)
{
	//enqueue TinyMCE plugin script with its ID.
	$plugin_array["rm_tinymce_plugin"] =  get_template_directory_uri() . "/js/editor.js";
	return $plugin_array;
}

add_filter("mce_external_plugins", "rm_tinymce_plugin");

function register_buttons_editor($buttons)
{
	//register buttons with their id.
	array_push($buttons, "hint");
	array_push($buttons, "mdash");
	return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");

add_filter('tiny_mce_before_init', 'rm_filter_tiny_mce_before_init');
function rm_filter_tiny_mce_before_init( $options ) {
	
	if ( ! isset( $options['extended_valid_elements'] ) ) {
		$options['extended_valid_elements'] = '';
	} else {
		$options['extended_valid_elements'] .= ',';
	}
	
	if ( ! isset( $options['valid_children'] ) ) {
		$options['valid_children'] = '';
	} else {
		$options['valid_children'] .= ',';
	}
	
	if ( ! isset( $options['custom_elements'] ) ) {
		$options['custom_elements'] = '';
	} else {
		$options['custom_elements'] .= ',';
	}
	
	$options['custom_elements'] .= 'media-wrapper,hint,iframe,textarea';
	$options['extended_valid_elements'] .= 'div[*],iframe[*],hint[*],media-wrapper[*],a[*],textarea[*]';
	$options['valid_children'] .= '+div[hint|media-wrapper|a],+a[div|p|ul|ol|li|h1|span|h2|h3|h4|h5|h5|h6],+hint[div|p|ul|ol|li|h1|span|h2|h3|h4|h5|h5|h6],+li[media-wrapper]';
	
	$style_formats = array(
		/*
		* Each array child is a format with it's own settings
		* Notice that each array has title, block, classes, and wrapper arguments
		* Title is the label which will be visible in Formats menu
		* Block defines whether it is a span, div, selector, or inline style
		* Classes allows you to define CSS classes
		* Wrapper whether or not to add a new block-level element around any selected elements
		*/
		array(
			'title' => 'H2',
			'block' => 'h2',
			'classes' => 'single-page__header-2',
			'wrapper' => true,
		),
		array(
			'title' => 'H3',
			'block' => 'h3',
			'classes' => 'single-page__header-3',
			'wrapper' => true,
		),
		array(
			'title' => 'H4',
			'block' => 'h4',
			'classes' => 'single-page__header-4',
			'wrapper' => true,
		),
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$options['style_formats'] = json_encode( $style_formats );
	
//	echo '<pre>';
//	var_dump($options['formats']);
//	echo '</pre>';
	
	return $options;
}

is_admin() && add_action( 'pre_get_posts', 'rm_cards_default_sort' );

function rm_cards_default_sort( $query ){
	// Nothing to do:
	if (!$query->is_main_query() || 'card' != $query->get('post_type'))
		return;
	
	$query->set('orderby', 'menu_order');
	$query->set('order', 'ASC');
	
}
