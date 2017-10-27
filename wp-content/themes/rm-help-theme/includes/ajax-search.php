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
	<div class='search-component' id='search-component-vue' v-bind:style=\"{ width: presentation.width + 'px', left: presentation.left + 'px'}\" v-cloack>
		<form role='search' method='POST' action='$action_url'>
			<input type='text' name='s' class='search-component__query-input' v-bind:value='value' v-on:input='queryInput(\$event.target.value)' v-on:focus='inputFocus = true' v-on:blur='inputFocus = false' v-on:keypress.enter.prevent='submitSearch' placeholder='Search feature, setting, shortcuts, etc'>
			<input type='submit' class='search-component__submit' value='Search'>
			<input type='hidden' value='$nonce'>
		</form>
		<div class='search-component__results'
			v-bind:class=\"searchResultsState\"
			v-show=\"searchResultsState != 'hidden'\"
			v-bind:style=\"{ maxHeight: _calcMaxHeight() + 'px'}\"
		>
			<div class='search-component__result-item waiting' v-show=\"searchResultsState == 'waiting'\">waiting</div>
			<div class='search-component__result-item empty' v-show=\"searchResultsState == 'empty'\">Nothing found for <strong>{{query}}</strong></div>
			<a href='#' class='search-component__result-item empty contact' v-show=\"searchResultsState == 'empty'\">Need help? Contact Readymag support</a>
			<a href='#' class='search-component__result-item' v-show=\"searchResultsState == 'success' || searchResultsState == 'inactive'\" v-for='post in results'>
				<div class='result-item__nav'>{{post.post_title}}</div>
				<div class='result-item__excerpt' v-html='post.post_excerpt'></div>
			</a>
		</div>
	</div>
	";
	
	echo $output;
}

add_filter('relevanssi_excerpt_content', 'rm_remove_excerpt_dots', 99, 3);
function rm_remove_excerpt_dots($content, $post, $query) {
	//add whatever you want to $content here
	return str_replace('...', '', $content);
}

function custom_excerpt( $more ) {
	return '';
}
add_filter('excerpt_more', 'custom_excerpt');