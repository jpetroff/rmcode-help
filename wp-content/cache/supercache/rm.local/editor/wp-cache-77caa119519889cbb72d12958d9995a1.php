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
		
		
	<article class="page-content-wrapper single-page" >
		<div class="page-content page-content_narrow">
			
			<div class="card_level_1" data-level="1" data-title="Editor"  v-navblock><h1 class="single-page__header-1">Editor</h1><p>Editor is where you design your projects, adding and customizing widgets on each page as necessary. Your workspace also includes Project Menu (M), in which you can access general settings, overview and rearrange all pages, and work with templates.</p>
<div is='hint' header='Note'> <p>
 Some types of content and attributes are not saved in templates:</p>
<ul>
<li>Paragraphs and link styles;</li>
<li>Fixed On All Pages widgets.</li>
</ul>
 </div></div><div class="card_level_2" data-level="2" data-title="Widgets" id='widgets' v-navblock><h2 class="single-page__header-2">Widgets</h2></div><div class="card_level_3" data-level="3" data-title="Test" id='test' v-navblock><h3 class="single-page__header-3">Test</h3><p>You can add fonts to your project using Typekit, Webtype, Google Fonts, Type.today. On paid plans you can upload your own fonts in WOFF format.</p>
<p>Make sure not to use Typekit fonts in projects that you are exporting: these fonts are replaced by defaults due to the license restrictions.</p>
<video class="page-content__responsive-video" width="700" height="393.75" src="http://rm.local/wp-content/uploads/inviting_collaborator.mp4" autoplay  loop></video></div><div class="card_level_3" data-level="3" data-title="Adding widgets" id='adding-widgets' v-navblock><h3 class="single-page__header-3">Adding widgets</h3><p>Click Add Widget (W) on the widget bar to create new widgets.</p>


<img class="page-content__responsive-image" width="700" height="474" src="http://help-test.readymag.net/wp-content/uploads/Widgets.png" srcset="http://help-test.readymag.net/wp-content/uploads/Widgets@2x.png 2x" /></div><div class="card_level_3" data-level="3" data-title="Widgets panel" id='widgets-panel' v-navblock><h3 class="single-page__header-3">Widgets panel</h3><p>When you add new widget, it appears in Widgets (Q) panel on the widget bar. Think of widgets as layers in any graphic editor — you can freely move and resize them, change their opacity, align and group several widgets together, and arrange them by placing above or underneath each other. To move your widget around the page, simply click and drag it to a new position.</p>
<p>If you hover over a widget in the panel, two icons appear: eye and lock. The Eye makes your widget invisible, while Lock (L) allows you to pin it down on the page.</p>


<img class="page-content__responsive-image" width="700" height="474" src="http://help-test.readymag.net/wp-content/uploads/Widgets.png" srcset="http://help-test.readymag.net/wp-content/uploads/Widgets@2x.png 2x" /></div><div class="card_level_2" data-level="2" data-title="Workspace" id='workspace' v-navblock><h2 class="single-page__header-2">Workspace</h2></div><div class="card_level_3" data-level="3" data-title="Dotted Frame" id='dotted-frame' v-navblock><h3 class="single-page__header-3">Dotted Frame</h3><p>To correctly appear on all screens, the content on your page (including sticky and fixed widgets) should always fit within 1024px wide area, marked with a dotted frame. A widget outside the dotted frame may not appear on small screens.</p>
<p>By default, content on the desktop is centered, and never scaled. The mobile layout of your page is always scaled and centered to fit the screen width.</p>
<p>Read more about %Positioning% widgets and %Mobile layouts%.</p>


<img class="page-content__responsive-image" width="700" height="474" src="http://help-test.readymag.net/wp-content/uploads/Dotted-frame_2X-700x474.png" srcset="http://help-test.readymag.net/wp-content/uploads/Dotted-frame_2X-700x474@2x.png 2x" /></div><div class="card_level_3" data-level="3" data-title="Preview mode" id='preview-mode' v-navblock><h3 class="single-page__header-3">Preview mode</h3><p>To see how your project will appear published, click Preview (P) in the top right corner at any time. The same button will return you to Edit (P) mode.</p></div><div class="card_level_3" data-level="3" data-title="Project Menu" id='project-menu' v-navblock><h3 class="single-page__header-3">Project Menu</h3><p>Click Project Menu (M) in the top <a v-rlink="" href="http://rm.local/editor/#adding-widgets">right</a> corner of the workspace, where you can:</p>
<ul>
	<li style="font-weight: 400;"><span style="font-weight: 400;">Rearrange and duplicate pages</span></li>
	<li style="font-weight: 400;"><span style="font-weight: 400;">Archive and restore archived pages</span></li>
	<li style="font-weight: 400;"><span style="font-weight: 400;">Add blank page or a page from the template</span></li>
	<li style="font-weight: 400;"><span style="font-weight: 400;">Create your page templates</span></li>
	<li style="font-weight: 400;"><span style="font-weight: 400;">Access project settings</span></li>
</ul></div><div class="card_level_4" data-level="4" data-title="Project Settings" id='project-settings' v-navblock><h4 class="single-page__header-4">Project Settings</h4><p>Click Project Settings beside your project’s title to access General, Privacy, Domain, and Viewer attributes. Here you can change the title, description, URL, and public visibility of your project, use %&lt;/&gt; Code Embedding% to add custom scripts in your project’s HTML header, set password protection and custom domain name, hide standard interface elements, change viewer options and publish your project when it’s ready.</p>
<p>Read more about %Project Settings and Publishing%.</p>


<img class="page-content__responsive-image" width="700" height="394" src="http://help-test.readymag.net/wp-content/uploads/Project-Settings-700x394.png" srcset="http://help-test.readymag.net/wp-content/uploads/Project-Settings-700x394@2x.png 2x" /></div><div class="card_level_4" data-level="4" data-title="Templates" id='templates' v-navblock><h4 class="single-page__header-4">Templates</h4><p>Templates are pre-designed pages. You can save any page — from your project as template. They appear in My Templates collection, accessible through Add Page menu in all your projects. You can also select multiple ready-to-use Microsites, Presentations, Photo Stories, and Longreads in R/m Templates.</p>


<img class="page-content__responsive-image" width="700" height="394" src="http://help-test.readymag.net/wp-content/uploads/Templates-700x394.png" srcset="http://help-test.readymag.net/wp-content/uploads/Templates-700x394@2x.png 2x" />

<video class="page-content__responsive-video" width="700" height="393.75" src="http://rm.local/wp-content/uploads/inviting_collaborator.mp4" autoplay  loop></video>
<p>Templates allow you to transfer pages between projects. Save the page as a template, switch to a different project, and add this page from the newly created template.</p>
<ol>
	<li>Test</li>
	<li>New line</li>
</ol>


<div is='hint' header='Notes'> <p>Some types of content and attributes are not saved in templates:</p>
<ol>
<li>Paragraphs and link styles;</li>
<li>Fixed On All Pages widgets.</li>
</ol>
<ul>
<li>Paragraphs and link styles;</li>
<li>Fixed On All Pages widgets.</li>
</ul>
 </div></div><div class="card_level_3" data-level="3" data-title="Page" id='page' v-navblock><h3 class="single-page__header-3">Page</h3><p>Creating a project in Editor is similar to designing a layout in Adobe Photoshop or Sketch. You can arrange widgets freely on the page. Any new project is created with a blank page and two default widgets, %Background% and %Grid &amp; Guides%, in Widgets (Q) panel.</p></div>		</div>
	</article>
	
	
	<nav class="left-navigation">
		<a href="/" v-rlink class="rm-guide-backlink left-navigation__link">Readymag Guide</a>
		
		<div class="page-navigation">
			<a href="http://rm.local/editor/"  v-bind:class="[(activeSection == '') ? 'current' : '']" class="left-navigation__link page-navigation__top" v-rlink>Editor</a><a href="http://rm.local/editor/#widgets"  v-bind:class="[(activeSection == 'widgets') ? 'current' : '']" class="left-navigation__link page-navigation__secondary" v-rlink>Widgets</a><a href="http://rm.local/editor/#workspace"  v-bind:class="[(activeSection == 'workspace') ? 'current' : '']" class="left-navigation__link page-navigation__secondary" v-rlink>Workspace</a>		</div>
	</nav>
		
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

<!-- Dynamic page generated in 0.466 seconds. -->
<!-- Cached page generated by WP-Super-Cache on 2017-11-16 20:37:57 -->
