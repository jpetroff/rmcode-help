<?php
?>
	<script>
		document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
			':35729/livereload.js?snipver=1"></' + 'script>')
	</script>
	<script>
		window._home_url = document.createElement('a'); window._home_url.href = '<?php echo home_url()?>';
		window._site_title = '<?php bloginfo('name')  ?>';
	</script>
	<script src="<? echo get_template_directory_uri(); ?>/js/libs.js"></script>
	<script src="<? echo get_template_directory_uri(); ?>/js/app.js"></script>
	</body>
</html>
