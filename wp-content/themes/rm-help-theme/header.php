<?php
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Readymag Guide</title>
	<link rel="stylesheet" href="<? echo get_template_directory_uri(); ?>/style.css">
	<script>
		window._search_nonce = '<?php echo wp_create_nonce('search'); ?>';
		window._ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?php wp_head(); ?>
</head>
<body class=" <? if (is_user_logged_in()) echo '_logged_user'; ?>">
