
	<article class="page-content-wrapper single-page" >
		<div class="page-content page-content_narrow">
			
			<?php
			global $create_nav;
			$create_nav = array();
			
			global $current_page;
			
			if ( defined('DOING_AJAX') ) {
				global $wp_the_query;
				$wp_the_query->the_post();
			} elseif ( have_posts() ) {
				the_post();
			}
			
			$current_page = get_permalink();
			the_content();
			?>
		</div>
	</article>
	
	
	<nav class="left-navigation">
		<a href="/" v-rlink class="rm-guide-backlink left-navigation__link">Readymag Guide</a>
		
		<div class="page-navigation">
			<?php
			foreach ($create_nav as $nav_item) {
				echo "<a href=\"${nav_item['link']}\" class=\"left-navigation__link page-navigation__${nav_item['level']}\" v-rlink>${nav_item['caption']}</a>";
			}
			?>
		</div>
	</nav>
