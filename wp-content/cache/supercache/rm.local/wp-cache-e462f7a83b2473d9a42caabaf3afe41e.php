<?php die(); ?><html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Readymag Guide</title>
	<link rel="stylesheet" href="http://rm.local/wp-content/themes/rm-help-theme/style.css">
</head>
<body class=" ">

	<div class='search-component' v-bind:class="[ presentation.isFront ? 'search-component_home' : '' ]"
		id='search-component-vue'
		v-bind:style="{ width: presentation.width + 'px', left: presentation.left + 'px'}" v-cloack
	>
		<form role='search' class='query-input-wrapper' method='POST' action='http://rm.local'>
		
			<input type='text' name='s'
				class='search-component__query-input'
				autocomplete='off'
				v-bind:value='value'
				v-on:input='queryInput($event.target.value)'
				v-on:focus='inputFocus = true'
				v-on:keypress.enter.prevent='submitSearch'
				placeholder='Search feature, setting, shortcuts, etc'
				ref='queryInput'
			>
			
			<input type='submit' class='search-component__submit' v-bind:class="[isActive ? 'active' : '']" value='Search' v-on:click.prevent='submitSearch(true)'>
			<div class='search-component__clear' v-show="value.length > 0" v-on:click.prevent='clearQuery'>
				<div class='clear-button'>
					<svg class='clear-button-cross' width="10px" height="10px" viewBox="0 0 10 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="close" stroke="#979797" stroke-width="1" stroke-linecap="round">
							<path d="M1,1 L9,9"></path>
							<path d="M9,1 L1,9"></path>
						</g>
					</svg>
				</div>
			</div>
			<input type='hidden' value='a007756d99'>
		</form>
		<transition name='toggle-results'>
		<div class='search-component__results'
			v-bind:class="searchResultsState"
			v-show="showResultsPanel"
			v-bind:style="{ height: presentation.scrollContainerHeight == 0 ? 'auto' : _calcMaxHeight() + 'px'}"
		>
			<div class='scroll-bar' v-if="presentation.scrollCoefficient < 1" ref='scrollBar' v-bind:style="{top:presentation.scrollBarTop + 'px', height: presentation.scrollBarHeight + 'px'}"></div>
			<div class='search-component__results-scroll-wrapper'
				ref='scrollContainer'
				v-bind:class="[ presentation.scrollCoefficient < 1 ? 'active-scroll' : '']"
				v-bind:style="{ height: presentation.scrollContainerHeight == 0 ? 'auto' : _calcMaxHeight() + 'px'}"
			>
				<div class='search-component__results-data-wrapper'
					ref='dataContainer'
				>
					<div class='search-component__result-item waiting' v-show="searchResultsState == 'waiting'">
						<div class='fake-line-loader' style='width:240px;'></div>
						<div class='fake-line-loader' style='width:450px;'></div>
						<div class='fake-line-loader break' style='width:180px;'></div>
						<div class='fake-line-loader' style='width:450px;'></div>
					</div>
					
					<div class='search-component__result-item empty' v-show="searchResultsState == 'empty'">Nothing found for <strong>{{query}}</strong></div>
					<a 	v-bind:href=" 'mailto:support@readymag.com?subject=' + encodedQuerySubject "
						class='search-component__result-item empty contact' v-show="searchResultsState == 'empty'"
						v-on:click='contactSupport($event)'
					>
							Need help? Contact Readymag support
					</a>
					<a
						v-for='post in results'
						v-bind:href="post.display_link"
						class='search-component__result-item item'
						v-show="searchResultsState == 'success' || searchResultsState == 'inactive'"
						v-on:click.prevent='showResultPage($event.currentTarget)'
					>
						<div class='result-item__nav'>{{post.post_title}}{{post.parent_title != '' ? ' — ' + post.parent_title : ''}}</div>
						<div class='result-item__excerpt' v-html='post.post_excerpt'></div>
					</a>
				</div>
			</div>
		</div>
		</transition>
		<transition name='toggle-results'>
			<div class='search-component__backdrop' v-show="showResultsPanel || inputFocus" v-on:click.prevent.self='inputFocus = false'></div>
		</transition>
	</div>
		<div class="_wrapper" id="app-page">
		
		
	<nav class="left-navigation">
		<div class="rm-logo">
			<svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewbox="0 0 612 140.7" y="0px" x="0px" id="Layer_1" style="box-shadow: none; border-radius: 0px; opacity: 1;" viewBox="1.2000000476837158 0 609.7999877929688 140.6999969482422" preserveAspectRatio="xMidYMid meet" fill="#000000" fill-opacity="1">
				<g>
					<path d="M79,41.1c-19.9,0-35.3,14.6-35.3,35.9c0,21.2,16.1,35.9,35.3,35.9c14.6,0,25.3-7.4,31.5-17.6l-12.9-5.8   c-2.3,5.8-8.6,10.2-17.9,10.2c-13,0-20.7-8.8-20.7-19h52.2l1.5-4.4C112.8,54.9,97.5,41.1,79,41.1z M59.8,67.7   c2.3-7.6,8.5-13.5,19.2-13.5c9.2,0,16.9,5.9,17.7,13.5H59.8z"></path>
					<path d="M609.5,73.3h-26.7v12.3h12.6c-0.7,9.1-9,14.1-18.1,14.1c-15.2,0-21.8-11.1-21.8-22.4c0-11.4,6.6-23,22-23   c8.6,0,15.1,4.5,18.4,10.6l12.5-6.2c-6.2-11.4-16.9-17.6-30.9-17.7c-21.6,0.1-37.1,15.5-37.1,36.3c0,21.7,16.9,35.6,35.7,35.6   C595,112.9,611,99,611,77.7L609.5,73.3z"></path>
					<path d="M17.3,50.5l-0.8-0.7L15,42.5H1.2v68.9h15.3V71.2c0.3-8.5,6.1-15.5,18-15.5h8.1V42.5c-3.1-1.4-4.6-1.4-7.6-1.4   C28.6,41.1,22.7,43.8,17.3,50.5z"></path>
					<polygon points="311.7,90 293.4,42.5 277.6,42.5 304.1,109.2 291.9,140.7 306.3,140.7 344.6,42.5 330.2,42.5  "></polygon>
					<path d="M257.6,48.4l-0.7,0.7l-0.8-0.7c-4.6-4.4-12.4-7.3-19.9-7.3c-19.9,0-36.8,14.6-36.8,35.9c0,21.2,16.9,35.9,36.8,35.9   c7.7,0,15.4-3,19.9-7.4l0.8-0.7l0.7,0.7l1.5,5.9h13.8V0h-15.3V48.4z M236.9,99.6c-14.6,0-22.4-10.2-22.4-22.7s7.8-22.8,22.4-22.8   c13,0,22.2,10.3,22.2,22.8S250,99.6,236.9,99.6z"></path>
					<path d="M175.8,48.4l-0.7,0.7l-0.7-0.7c-4.7-4.4-12.3-7.3-19.9-7.3c-19.9,0-36.8,14.6-36.8,35.9c0,21.2,16.9,35.9,36.8,35.9   c7.6,0,15.3-3,19.9-7.4l0.7-0.7l0.7,0.7l1.6,5.9h13.8V42.5h-13.8L175.8,48.4z M155.1,99.6c-14.5,0-22.4-10.2-22.4-22.7   s7.9-22.8,22.4-22.8c13,0,22.3,10.3,22.3,22.8S168.1,99.6,155.1,99.6z"></path>
					<path d="M427.7,41.1c-6.1,0-13.8,2.9-17.6,7.3l-3.8,4.4c-4-7.2-12-11.7-23-11.7c-6.1,0-13.8,2.9-16.9,7.3l-0.7,0.7l-0.8-0.7   l-1.5-5.9h-13.8v68.9h15.3V69.7c0.3-8.5,7.9-15.5,16.9-15.5c7.7,0,12.3,4.4,12.3,13.2v44h15.4V69.7c0.3-8.5,7.8-15.5,16.9-15.5   c7.6,0,12.3,4.4,12.3,13.2v44h15.3V65.9C453.8,51.3,444.7,41.1,427.7,41.1z"></path>
					<path d="M518.8,48.4l-0.7,0.7l-0.8-0.7c-4.6-4.4-12.2-7.3-19.9-7.3c-19.9,0-36.8,14.6-36.8,35.9c0,21.2,16.9,35.9,36.8,35.9   c7.7,0,15.4-3,19.9-7.4l0.8-0.7l0.7,0.7l1.5,5.9h13.8V42.5h-13.8L518.8,48.4z M498.1,99.6c-14.5,0-22.4-10.2-22.4-22.7   s7.8-22.8,22.4-22.8c13,0,22.3,10.3,22.3,22.8S511.1,99.6,498.1,99.6z"></path>
				</g>
				</svg>
		</div>
	</nav>
	<div class="page-content-wrapper">
		<div class="page-content homepage">
			<h1 class="def-header homepage__main-header">Guide</h1>
			<div class="homepage__menu row">
		<div class="col-third">
			
		<div class="homepage__section-list section-list__editor" style="color:#f00">
				<a href="/editor/" v-rlink class="homepage__section-list__top-level">
					<div class="top-level__icon">
						
					</div>
					<div class="top-level__caption">
						Editor
					</div>
				</a>
				<div class="homepage__section-list__second-level">
		<a href="/editor/#widgets" class="second-level__item def-link" v-rlink>Widgets</a><a href="/editor/#workspace" class="second-level__item def-link" v-rlink>Workspace</a></div>
			</div>
		</div>
		<div class="col-third">
			<div class="homepage__section-list section-list__publishing">
				<a href="#" class="homepage__section-list__top-level">
					<div class="top-level__icon">
					
					</div>
					<div class="top-level__caption">
						Project Settings and&nbsp;Publishing
					</div>
				</a>
				<div class="homepage__section-list__second-level">
					<a href="#" class="second-level__item def-link">Workspace</a>
					<a href="#" class="second-level__item def-link">Widgets</a>
					<a href="#" class="second-level__item def-link">Positioning</a>
					<a href="#" class="second-level__item def-link">Animation</a>
					<a href="#" class="second-level__item def-link">Links</a>
					<a href="#" class="second-level__item def-link">Adaptive</a>
				</div>
			</div>
		</div>
		<div class="col-third">
			<div class="homepage__section-list section-list__account">
				<a href="#" class="homepage__section-list__top-level">
					<div class="top-level__icon">
					
					</div>
					<div class="top-level__caption">
						Account<br>and&nbsp;billing
					</div>
				</a>
				<div class="homepage__section-list__second-level">
					<a href="#" class="second-level__item def-link">Workspace</a>
					<a href="#" class="second-level__item def-link">Widgets</a>
					<a href="#" class="second-level__item def-link">Positioning</a>
					<a href="#" class="second-level__item def-link">Animation</a>
					<a href="#" class="second-level__item def-link">Links</a>
					<a href="#" class="second-level__item def-link">Adaptive</a>
				</div>
			</div>
		</div>
	</div>
	<div class="homepage__subsidiary-menu row">
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Shortcuts</a>
		</div>
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Code Export</a>
		</div>
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Supported Browsers</a>
		</div>
	</div>
	<div class="homepage__subsidiary-menu row">
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Tips</a>
		</div>
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Plugin for WordPress</a>
		</div>
		<div class="col-third subsidiary-menu__single-link">
			<a href="#" class="single-link">Terms and Privacy</a>
		</div>
	</div>
</div>
		</div>
	</div>

		
	</div>
	<script>
		document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
			':35729/livereload.js?snipver=1"></' + 'script>')
	</script>
	<script>
		window._home_url = document.createElement('a'); window._home_url.href = 'http://rm.local/';
		window._site_title = 'Readymag Guide';
	</script>
	<script src="http://rm.local/wp-content/themes/rm-help-theme/js/libs.js"></script>
	<script src="http://rm.local/wp-content/themes/rm-help-theme/js/app.js"></script>
	</body>
</html>

<!-- Dynamic page generated in 0.259 seconds. -->
<!-- Cached page generated by WP-Super-Cache on 2017-11-16 20:36:22 -->
