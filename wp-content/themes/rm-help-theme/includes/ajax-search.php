<?php

add_action( 'wp_ajax_search', 'get_ajax_search_results' );
add_action( 'wp_ajax_nopriv_search', 'get_ajax_search_results' );

function get_ajax_search_results( $wp ) {
	$q = new WP_Query();
	$q->query_vars['s'] = $wp->query_vars['s'];
	
	relevanssi_do_query($q);
	$link_index = get_option('_rm_card_link_index');
	
	wp_send_json( array( 'posts' => $q->posts, 'link_index' => $link_index ) );
	wp_die();
}

function show_search_component() {
	$action_url = home_url();
	$nonce = wp_create_nonce('search');
	$output = "
	<div class='search-component' v-bind:class=\"[ presentation.isFront ? 'search-component_home' : '' ]\"
		id='search-component-vue'
		v-bind:style=\"{ width: presentation.width + 'px', left: presentation.left + 'px'}\" v-cloack
	>
		<form role='search' class='query-input-wrapper' method='POST' action='$action_url'>
		
			<input type='text' name='s'
				class='search-component__query-input'
				v-bind:value='value'
				v-on:input='queryInput(\$event.target.value)'
				v-on:focus='inputFocus = true'
				v-on:keypress.enter.prevent='submitSearch'
				placeholder='Search feature, setting, shortcuts, etc'
				ref='queryInput'
			>
			
			<input type='submit' class='search-component__submit' value='Search' v-on:click.prevent='submitSearch(true)'>
			<div class='search-component__clear' v-show=\"value.length > 0\" v-on:click.prevent='clearQuery'>
				<div class='clear-button'>
					<svg class='clear-button-cross' width=\"10px\" height=\"10px\" viewBox=\"0 0 10 10\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
						<g id=\"close\" stroke=\"#979797\" stroke-width=\"1\" stroke-linecap=\"round\">
							<path d=\"M1,1 L9,9\"></path>
							<path d=\"M9,1 L1,9\"></path>
						</g>
					</svg>
				</div>
			</div>
			<input type='hidden' value='$nonce'>
		</form>
		<transition name='toggle-results'>
		<div class='search-component__results'
			v-bind:class=\"searchResultsState\"
			v-show=\"showResultsPanel\"
			v-bind:style=\"{ maxHeight: _calcMaxHeight() + 'px'}\"
		>
			<div class='search-component__result-item waiting' v-show=\"searchResultsState == 'waiting'\">
				<div class='fake-line-loader' style='width:240px;'></div>
				<div class='fake-line-loader' style='width:450px;'></div>
				<div class='fake-line-loader break' style='width:180px;'></div>
				<div class='fake-line-loader' style='width:450px;'></div>
			</div>
			
			<div class='search-component__result-item empty' v-show=\"searchResultsState == 'empty'\">Nothing found for <strong>{{query}}</strong></div>
			<a href='#' class='search-component__result-item empty contact' v-show=\"searchResultsState == 'empty'\">Need help? Contact Readymag support</a>
			
			<a
				v-for='post in results'
				v-bind:href=\"post.display_link\"
				class='search-component__result-item item'
				v-show=\"searchResultsState == 'success' || searchResultsState == 'inactive'\"
				v-on:click.prevent='showResultPage(\$event.currentTarget)'
			>
				<div class='result-item__nav'>{{post.post_title}}{{post.parent_title != '' ? ' — ' + post.parent_title : ''}}</div>
				<div class='result-item__excerpt' v-html='post.post_excerpt'></div>
			</a>
		</div>
		</transition>
		<transition name='toggle-results'>
			<div class='search-component__backdrop' v-show=\"showResultsPanel || inputFocus\" v-on:click.prevent.self='inputFocus = false'></div>
		</transition>
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