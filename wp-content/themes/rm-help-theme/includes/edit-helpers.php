<?php

function rm_test_shortcode( $atts, $content ) {
	return $content.'!';
}
add_shortcode('test', 'rm_test_shortcode');