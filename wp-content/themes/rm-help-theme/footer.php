<?php
?>
	<script>
		document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
			':35729/livereload.js?snipver=1"></' + 'script>')
	</script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<? echo get_template_directory_uri(); ?>/js/libs.js"></script>
	<script src="<? echo get_template_directory_uri(); ?>/js/app.js"></script>
	<?php wp_footer(); ?>
	</body>
</html>
