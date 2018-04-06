<?php
define( 'RM_CACHE_PHASE1_INCLUDED', true );

if ( @include(__DIR__ . '/rm-advanced-cache-config.php') ) {

	define( 'RM_CACHE_PHASE1', true );

	include RM_IMP_DIR.'/includes/utils.php';
	include RM_IMP_DIR.'/includes/rm-cache.php';

	$route = rm_importer_parse_request();
	
	send_file_phase1($route, $wp);

}

