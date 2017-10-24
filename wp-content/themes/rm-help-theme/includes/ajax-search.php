<?php

add_action( 'wp_ajax_search', 'get_ajax_search_results' );
add_action( 'wp_ajax_nopriv_search', 'get_ajax_search_results' );

function get_ajax_search_results() {
	$req = $_REQUEST['query'];
	
	$q = new WP_Query();
	$q->query_vars['s'] = $req;
	
	relevanssi_do_query($q);
	
	wp_send_json($q->posts);
	wp_die();
}

function show_search_component() {
	$action_url = home_url();
	$nonce = wp_create_nonce('search');
	$output = "
	<div class='search-component' id='search-component-vue'>
		<form role='search' method='POST' action='$action_url'>
			<input type='text' name='s' class='search-component__query-input' v-bind:value='query' v-on:input='queryInput(\$event.target.value)' placeholder='Search feature, setting, shortcuts, etc'>
			<input type='submit' class='search-component__submit' value='Search'>
			<input type='hidden' value='$nonce'>
		</form>
		<div class='search-component__results'>
			<div class='search-component__result-item' v-for=''></div>
		</div>
	</div>
	";
	
	echo $output;
}