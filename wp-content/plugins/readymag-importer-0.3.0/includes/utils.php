<?php

define( 'RM_IMPORTER_UTILS_LOADED', true );

/**
 * =================================================
 *
 * FILESYSTEM OPERATIONS
 *
 * =================================================
 */

function rm_file_get_contents( $file ) {
	return @file_get_contents($file);
}

function rm_file_put_contents( $file, $content, $flags = 0 ) {
	return @file_put_contents($file, $content, $flags);
}

function rm_is_writable( $file ) {
	return @is_writable($file);
}

function rm_file_exists( $file ) {
	return @file_exists($file);
}

function rm_is_file( $file ) {
	return @is_file($file);
}

function rm_copy( $src, $dst ) {
	return @copy($src, $dst);
}

function rm_mkdir( $dir ) {
	return @mkdir($dir);
}

function rm_eliminate_dir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rm_eliminate_dir($dir."/".$object); else @unlink($dir."/".$object);
       }
     }
     reset($objects);
     @rmdir($dir);
   }
}

/**
 * =================================================
 *
 * VARIOUS FUNCTIONS
 *
 * =================================================
 */

function rm_replace_line($old, $new, $my_file) {
	if ( rm_is_file( $my_file ) == false ) {
		return false;
	}
	if (!rm_is_writable($my_file)) {
		return false;
	}

	$found = false;
	$lines = file($my_file);
	foreach( (array)$lines as $line ) {
		if ( preg_match($old, $line)) {
			$found = true;
			break;
		}
	}
	if ($found) {
		$fd = fopen($my_file, 'w');
		foreach( (array)$lines as $line ) {
			if ( !preg_match( $old, $line ) ) {
				fputs($fd, $line);
			} elseif ( $new != '' ) {
				fputs($fd, "$new //added by Readymag Importer plugin\n");
			}
		}
		fclose($fd);
	}
	return $found;
}

function rm_add_lines($position_line, $new, $file, $before = false) {
	$lines = file($file);
	$fd = fopen($file, 'w');
	$done = false;
	foreach( (array)$lines as $line ) {
		if ( $done || !preg_match($position_line, $line) ) {
			fputs($fd, $line);
		} else {

			if(!$before) fputs($fd, $line);
			foreach( (array)$new as $new_line ) {
				fputs($fd, "$new_line // added by Readymag Importer plugin\n");
			}
			if($before) fputs($fd, $line);
			$done = true;

		}
	}
	fclose($fd);
	return $done;
}

function get_project_by_post_id( $post_id ) {
	$projects = get_project_settings();

	foreach($projects as $p_id => $settings) {
		if( $settings['post_id'] == $post_id )
			return $p_id;
	}
	return false;
}

// return first non empty alternative
function ___a(...$strings) {
	foreach($strings as $str) {
		if ($str != '') return $str;
	}
}

// add suffix to a Readymag file name
function get_readyscr($uri,$size) {
	$arr = explode('.',$uri);
	$arr[0] .= '_'.$size;
	return implode('.',$arr);
}

function __grind_halt(...$args) {
	echo '<pre>';
	foreach($args as $var) {
		var_dump($var);
	}
	echo '</pre>';
	exit;
}

function flush_messages($print = true) {
	global $rm_state_array;

	$_saved_state = get_option('_rm_redirect_state_save');
	if ($_saved_state != false) {
		$rm_state_array = _merge_messages($rm_state_array, $_saved_state);
		update_option('_rm_redirect_state_save', '');
	}

	$result = '';
	foreach($rm_state_array as $type => $collection) {
		$class = 'notice notice-'.$type.' is-dismissible';
		foreach($collection as $message) {
			$prnt_str = '<div class="%1$s"><p>%2$s</p></div>';
			if ($message['details']) $prnt_str = '<div class="%1$s"><p class=rm-notice-header>%2$s</p><p class=rm-notice-details>%3$s</p></div>';

			$result .= sprintf($prnt_str,
				esc_attr($class),
				$message['_unescaped'] == true ? $message['caption'] : esc_html($message['caption']),
				esc_html($message['details'])
			);
		}
	}
	$rm_state_array = array(
		'error' => array(),
		'success' => array(),
		'warning' => array()
	);

	if ($print) echo $result;
	return $result;
}

function _merge_messages( $state_1, $state_2 ) {
	$state_1['error'] = array_merge($state_1['error'], $state_2['error']);
	$state_1['warning'] = array_merge($state_1['warning'], $state_2['warning']);
	$state_1['success'] = array_merge($state_1['success'], $state_2['success']);

	return $state_1;
}