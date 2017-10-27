<?php
include 'header.php';
?>
	<div class="_wrapper">
		<?php show_search_component(); ?>
		<article class="page-content-wrapper single-page" id="app-page">
			<div class="page-content page-content_narrow">
				
				<?php
				global $create_nav;
				$create_nav = array();
				
				global $current_page;
				
				if ( have_posts() ) {
					the_post();
					$current_page = get_permalink();
					the_content();
				}
				?>
			</div>
			
			
			
			
		</article>
		
		
		<nav class="left-navigation">
			<a href="/" class="rm-guide-backlink left-navigation__link">Readymag Guide</a>
			
			<div class="page-navigation">
<!--				<a href="#" class="left-navigation__link page-navigation__top">Editor</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary">Workspace</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary current">Widgets</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary">Positioning</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary">Animation</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary">Links</a>-->
<!--				<a href="#" class="left-navigation__link page-navigation__secondary">Adaptive</a>-->
				<?php
					foreach ($create_nav as $nav_item) {
						echo "<a href=\"${nav_item['link']}\" class=\"left-navigation__link page-navigation__${nav_item['level']}\">${nav_item['caption']}</a>";
					}
				?>
			</div>
		</nav>
	</div>
<?php
include 'footer.php';
