<?php

add_action( 'wp_ajax_search', 'get_ajax_search_results' );
add_action( 'wp_ajax_nopriv_search', 'get_ajax_search_results' );

function get_ajax_search_results( $wp ) {
	global $modify_suggested, $disable_suggestions;
	$q = new WP_Query();
	$q->query_vars['s'] = $wp->query_vars['s'];
	
//	if($_GET['limit'] == 'true')
//		$q->query_vars['posts_per_page'] = 4;
	
	$modify_suggested = null;
	$disable_suggestions = false;
	
	add_filter('relevanssi_hits_filter', function( $hits ) {
		global $modify_suggested, $disable_suggestions;
		
		if($disable_suggestions) return $hits;
		
		$has_corrections = false;
		$words = explode(" ", $hits[1]);
		
		if(function_exists('pspell_new')) {
			$pspell = pspell_new('en_US');
			
			foreach ($words as $key => $word) {
				if(!pspell_check($pspell, $word)) {
					$suggestions = pspell_suggest($pspell, $word);
					if(count($suggestions) > 0) {
						$words[$key] = $suggestions[0];
						$has_corrections = true;
					}
				}
			}
		}
		
		if($has_corrections)
			$modify_suggested = implode(' ', $words);
		
//		if( DEFINED('LOCAL') )
//			$modify_suggested = 'editor';
		
		return $hits;
	});
	
	relevanssi_do_query($q);
	$link_index = get_option('_rm_card_link_index');
	
	if( $modify_suggested != null && count($q->posts) == 0 ) {
		// if nothing found, try modified suggestion
		$q->query_vars['s'] = $modify_suggested;
		$disable_suggestions = true;
		relevanssi_do_query($q);
	}
	
//	$hasMore = ( count($q->posts) < $q->found_posts ) ? true : false;
	$hasMore = ( (int)$_GET['limitNum'] < count($q->posts) ) ? true : false;
	
	$hints = [];
	if( strpos($q->query_vars['s'], 'page') !== false && strpos($q->query_vars['s'], 'width' ) !== false ) {
		array_push($hints,
			array(
				'post_type' => 'hint',
				'post_excerpt' => 'It is not possible to change page width in Readymag. See <a href="/editor/#dotted-frame" target="_blank">Dotted Frame</a>',
				'display_link' => '#',
				'post_highlighted_title' => 'Hint: changing page width',
				'parent_title' => ''
			)
		);
	}
	
	wp_send_json( array( 'posts' => $hints + $q->posts, 'link_index' => $link_index, 'suggested' => $modify_suggested, 'has_more' => $hasMore, 'modified_results' => $disable_suggestions ) );
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
				autocomplete='off'
				v-bind:value='value'
				v-on:input='queryInput(\$event.target.value)'
				v-on:focus='inputFocus = true'
				v-on:keypress.enter.prevent='expandResults'
				placeholder='Search feature, setting, shortcuts, etc'
				ref='queryInput'
			>
			
			<input type='submit'
				class='search-component__submit' v-bind:class=\"[isActive ? 'active' : '']\"
				value='Search'
				v-on:click.prevent='expandResults'
				v-show=\"query != ''\"
			>
			
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
			v-bind:style=\"{ height: presentation.scrollContainerHeight == 0 ? 'auto' : _calcMaxHeight() + 'px'}\"
		>
			<div class='scroll-bar' v-if=\"presentation.scrollCoefficient < 1\" ref='scrollBar' v-bind:style=\"{top:presentation.scrollBarTop + 'px', height: presentation.scrollBarHeight + 'px'}\"></div>
			<div class='search-component__results-scroll-wrapper'
				ref='scrollContainer'
				v-bind:class=\"[ presentation.scrollCoefficient < 1 ? 'active-scroll' : '']\"
				v-bind:style=\"{ height: presentation.scrollContainerHeight == 0 ? 'auto' : _calcMaxHeight() + 'px'}\"
			>
				<div class='search-component__results-data-wrapper'
					ref='dataContainer'
				>
					<div class='search-component__result-item waiting' v-show=\"searchResultsState == 'waiting'\">
						<div class='fake-line-loader' style='width:240px;'></div>
						<div class='fake-line-loader' style='width:450px;'></div>
						<div class='fake-line-loader break' style='width:180px;'></div>
						<div class='fake-line-loader' style='width:450px;'></div>
					</div>
					<div class='search-component__result-item suggestion' v-show=\"showSuggestion\">
					 	<span v-if='!modifiedResults'>Did you mean</span><span v-if='modifiedResults'>Showing results for</span>&nbsp;<a href='#' class='new-query' v-on:click.prevent='applySuggestion'>{{correction}}</a><span v-if='!modifiedResults' >?</span>
					</div>
					<div class='search-component__result-item empty' v-bind:class=\"[correction != '' ? 'has-correction' : '']\" v-show=\"searchResultsState == 'empty'\">
						<div class='empty-wrapper' >Nothing found for <strong>{{query}}</strong></div>
					</div>
					
					<div
						v-for='(post, index) in results'
						class='search-component__result-item item hint'
						v-show=\"(searchResultsState == 'success' || searchResultsState == 'inactive') && (!hasMore || index < SHORT_LIMIT)\"
						v-if=\"post.post_type == 'hint' \"
					>
						<div class='result-item__nav'><span v-html='post.post_highlighted_title'></span>{{post.parent_title != '' ? ' • ' + post.parent_title : ''}}</div>
						<div class='result-item__excerpt' v-html='post.post_excerpt'></div>
					</div>
					
					<a 	v-bind:href=\" 'mailto:support@readymag.com?subject=' + encodedQuerySubject \"
						class='search-component__result-item empty contact' v-show=\"searchResultsState == 'empty' || onlyHints == true\"
						v-on:click='contactSupport(\$event)'
					>
							Need help? Contact Readymag support
					</a>
					<a
						v-for='(post, index) in results'
						v-bind:href=\"post.display_link\"
						class='search-component__result-item item article'
						v-show=\"(searchResultsState == 'success' || searchResultsState == 'inactive') && (!hasMore || index < SHORT_LIMIT)\"
						v-if=\"post.post_type != 'hint' \"
						v-on:click.prevent='showResultPage(\$event.currentTarget)'
					>
						<div class='result-item__nav'><span v-html='post.post_highlighted_title'></span>{{post.parent_title != '' ? ' • ' + post.parent_title : ''}}</div>
						<div class='result-item__excerpt' v-html='post.post_excerpt'></div>
					</a>
					
					<div 	class='search-component__result-item show-more'
							v-bind:class=\"[correction != '' ? 'has-correction' : '']\"
							v-show=\"isActive\"
							v-on:click='expandResults'
					>
						<div class='empty-wrapper' >Show {{results.length - SHORT_LIMIT}} more results</div>
					</div>
				</div>
			</div>
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