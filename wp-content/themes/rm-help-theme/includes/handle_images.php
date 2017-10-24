<?php

//add_filter('wp_handle_upload_prefilter', 'rm_upload_filter' );
function rm_upload_filter( $file ) {
	var_dump($file);
//	$file['name'] = 'wordpress-is-awesome-' . $file['name'];
	return $file;
}

function rm_jpg_compression($args) {
	return 100;
}
add_filter('jpeg_quality', 'rm_jpg_compression');

function _add_2x( $_filename ) {
	$filename = basename($_filename);
	$extension_pos = strrpos($filename, '.'); // find position of the last dot, so where the extension starts
	$result = substr($filename, 0, $extension_pos) . '@2x' . substr($filename, $extension_pos);
	return dirname($_filename).'/'.$result;
}

function rm_get_attachment_retina( $id ) {
	return get_post_meta( $id, '_rm_attachment_metadata');
}

function rm_update_attachment_retina( $id, $data ) {
	return update_post_meta( $id, '_rm_attachment_metadata', $data);
}

function rm_create_attachment_retina_sizes( $post_id, $post, $att_meta ) {
	
	$retina_meta = $att_meta;
	$file_name = get_attached_file($post_id);
	$file_location = dirname($file_name);
	$retina_original = _add_2x($file_name);
	
	if( !file_exists($retina_original)  ) return;
	
	$image = wp_get_image_editor($retina_original);
	if ( !is_wp_error($image) ) {
		$retina_original_size = $image->get_size();
		
		$retina_meta['file'] = basename( _add_2x($file_name) );
		$retina_meta['width'] = $retina_original_size['width'];
		$retina_meta['height'] = $retina_original_size['height'];
		unset($image);
		
		foreach ($retina_meta['sizes'] as $size_id => $retina_size) {
			$sized_image = wp_get_image_editor( $retina_original );
			$sized_image->set_quality(100);
			$sized_image->resize( $retina_size['width'] * 2, $retina_size['height'] * 2);
			
			$sized_image_name = _add_2x(str_replace('@2x', '', $sized_image->generate_filename($retina_size['width'].'x'.$retina_size['height'])));
			$sized_image->save( $sized_image_name );
			
			$retina_meta['sizes'][$size_id]['file'] = basename($sized_image_name);
			$retina_meta['sizes'][$size_id]['width'] = $retina_size['width'] * 2;
			$retina_meta['sizes'][$size_id]['height'] = $retina_size['height'] * 2;
		}
		
		rm_update_attachment_retina( $post_id, $retina_meta);
	}
}

add_action('add_attachment', 'rm_process_attachment', 99, 2);
function rm_process_attachment( $id ) {
	$att = get_post( $id );
	$image_file = get_attached_file( $id );
	$new_image_file = _add_2x( $image_file );
	
	$image = wp_get_image_editor( $image_file );
	if ( !is_wp_error( $image ) ) {
		$image_size = $image->get_size();
		$image->set_quality(100);
		
		// save original file as @2x
		$image->save( $new_image_file );
		
		// generate half copy
		$new_w = floor($image_size['width'] / 2);
		$new_h = floor($image_size['height'] / 2);
		$image->resize($new_w,$new_h);
		$image->save( $image_file );
	}
	
	rm_create_attachment_retina_sizes( $id, $att, wp_generate_attachment_metadata( $id, $image_file ) );
}