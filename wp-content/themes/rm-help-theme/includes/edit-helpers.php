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