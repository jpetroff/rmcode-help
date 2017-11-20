<?php

				if ( !isset( $_SERVER[ "PHP_AUTH_USER" ] ) || ( $_SERVER[ "PHP_AUTH_USER" ] != "6351a994135a0a28f5ebae080f1ce6df" && $_SERVER[ "PHP_AUTH_PW" ] != "6351a994135a0a28f5ebae080f1ce6df" ) ) {
					header( "WWW-Authenticate: Basic realm=\"WP-Super-Cache Debug Log\"" );
					header("HTTP/1.0 401 Unauthorized");
					echo "You must login to view the debug log";
					exit;
				}?><pre>20:06:39 33618 /wp-admin/ Not serving wp-admin requests.
20:06:39 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:06:39 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:06:39 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:06:39 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
20:06:39 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:06:39 33618 /wp-admin/ wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:06:39 33618 /wp-admin/ wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:06:39 33618 /wp-admin/ In WP Cache Phase 2
20:06:39 33618 /wp-admin/ Setting up WordPress actions
20:06:39 33618 /wp-admin/ Not caching wp-admin requests.
20:06:46 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:06:46 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:06:46 33618 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:06:46 33618 /wp-admin/admin-ajax.php Setting up WordPress actions
20:06:46 33618 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard Not serving wp-admin requests.
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard In WP Cache Phase 2
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard Setting up WordPress actions
20:06:47 33705 /wp-admin/admin-ajax.php?action=dashboard-widgets&widget=dashboard_primary&pagenow=dashboard Not caching wp-admin requests.
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not serving wp-admin requests.
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:07:05 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:07:06 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy Not serving wp-admin requests.
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy In WP Cache Phase 2
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy Setting up WordPress actions
20:07:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy Not caching wp-admin requests.
20:07:12 33706 /wp-admin/options-general.php?page=wpsupercache&tab=easy maybe_stop_gc: GC flag not found. GC will go ahead..
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not serving wp-admin requests.
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:07:17 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:07:18 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:07:42 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:07:42 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:07:42 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:07:42 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:07:42 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:07:44 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:07:50 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:07:50 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:07:50 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:07:50 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:07:50 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:07:52 33707 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:27 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy Not serving wp-admin requests.
20:08:28 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:28 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:28 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy In WP Cache Phase 2
20:08:28 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy Setting up WordPress actions
20:08:28 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy Not caching wp-admin requests.
20:08:29 33614 /wp-admin/options-general.php?page=wpsupercache&tab=easy maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not serving wp-admin requests.
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:08:30 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:08:31 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn Not serving wp-admin requests.
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn In WP Cache Phase 2
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn Setting up WordPress actions
20:08:36 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn Not caching wp-admin requests.
20:08:38 33614 /wp-admin/options-general.php?page=wpsupercache&tab=cdn maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:38 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents Not serving wp-admin requests.
20:08:39 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:39 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:39 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents In WP Cache Phase 2
20:08:39 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents Setting up WordPress actions
20:08:39 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents Not caching wp-admin requests.
20:08:40 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 Not serving wp-admin requests.
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 In WP Cache Phase 2
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 Setting up WordPress actions
20:08:42 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 Not caching wp-admin requests.
20:08:44 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095 maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 Not serving wp-admin requests.
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 In WP Cache Phase 2
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 Setting up WordPress actions
20:08:47 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 Not caching wp-admin requests.
20:08:47 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:47 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:47 33617 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:08:47 33617 /wp-admin/admin-ajax.php Setting up WordPress actions
20:08:47 33617 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:08:48 33614 /wp-admin/options-general.php?page=wpsupercache&tab=contents&action=regenerate_cache_stats&_wpnonce=883ff54095&listfiles=1 maybe_stop_gc: GC flag not found. GC will go ahead..
20:08:49 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not serving wp-admin requests.
20:08:50 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:08:50 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:08:50 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:08:50 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:08:50 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:08:51 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:09:24 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings DISABLE_SUPERCACHE is not set, super_cache enabled.
20:09:35 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:09:58 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:09:58 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:09:58 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:09:58 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:09:58 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:09:59 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings DISABLE_SUPERCACHE is not set, super_cache enabled.
20:10:00 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:10:41 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:10:41 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:10:41 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:10:41 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:10:41 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:10:42 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:10:48 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:10:48 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:10:48 33706 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:10:48 33706 /wp-admin/admin-ajax.php Setting up WordPress actions
20:10:48 33706 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not serving wp-admin requests.
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:10:51 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:10:53 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:11:26 33707 /wp-admin/users.php Not serving wp-admin requests.
20:11:26 33707 /wp-admin/users.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:11:26 33707 /wp-admin/users.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:11:26 33707 /wp-admin/users.php In WP Cache Phase 2
20:11:26 33707 /wp-admin/users.php Setting up WordPress actions
20:11:26 33707 /wp-admin/users.php Not caching wp-admin requests.
20:11:31 33707 /wp-admin/users.php Not serving wp-admin requests.
20:11:32 33707 /wp-admin/users.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:11:32 33707 /wp-admin/users.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:11:32 33707 /wp-admin/users.php In WP Cache Phase 2
20:11:32 33707 /wp-admin/users.php Setting up WordPress actions
20:11:32 33707 /wp-admin/users.php Not caching wp-admin requests.
20:11:53 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php Not serving wp-admin requests.
20:11:54 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:11:54 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:11:54 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php In WP Cache Phase 2
20:11:54 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php Setting up WordPress actions
20:11:54 33617 /wp-admin/profile.php?wp_http_referer=%2Fwp-admin%2Fusers.php Not caching wp-admin requests.
20:12:14 33618 /wp-admin/profile.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:12:14 33618 /wp-admin/profile.php wp_cache_get_cookies_values: return: bcb8ab7e6e8c45318e8ecdb1f4fba3ee
20:12:14 33618 /wp-admin/profile.php In WP Cache Phase 2
20:12:14 33618 /wp-admin/profile.php Setting up WordPress actions
20:12:14 33618 /wp-admin/profile.php Not caching wp-admin requests.
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php Not serving wp-admin requests.
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php In WP Cache Phase 2
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php Setting up WordPress actions
20:12:14 33618 /wp-admin/profile.php?updated=1&wp_http_referer=%2Fwp-admin%2Fusers.php Not caching wp-admin requests.
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug Not serving wp-admin requests.
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug In WP Cache Phase 2
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug Setting up WordPress actions
20:12:22 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug Not caching wp-admin requests.
20:12:23 33616 /wp-admin/options-general.php?page=wpsupercache&tab=debug maybe_stop_gc: GC flag not found. GC will go ahead..
20:13:15 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:13:15 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:13:15 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:13:15 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
20:13:15 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:13:16 33617 /api/page/_front Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:13:16 33617 /api/page/_front wp_cache_get_cookies_values: return: 
20:13:16 33617 /api/page/_front supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:13:16 33617 /api/page/_front No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/index.html
20:13:16 33617 /api/page/_front wp_cache_get_cookies_values: return: 
20:13:16 33617 /api/page/_front In WP Cache Phase 2
20:13:16 33617 /api/page/_front Setting up WordPress actions
20:13:16 33617 /api/page/_front Created output buffer
20:13:16 33617 /api/page/_front wp_cache_get_cookies_values: return: 
20:13:16 33617 /api/page/_front wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:13:16 33617 /api/page/_front wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:13:16 33617 /api/page/_front Output buffer callback
20:13:16 33617 /api/page/_front http://rm.local/api/page/_front - Dynamic page generated in 0.378 seconds.
20:13:16 33617 /api/page/_front http://rm.local/api/page/_front - Cached page generated by WP-Super-Cache on 2017-11-16 20:13:16
20:13:16 33617 /api/page/_front Writing non-gzipped buffer to wp-cache cache file.
20:13:16 33617 /api/page/_front Renamed temp wp-cache file to /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front//wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:13:16 33617 /api/page/_front Sending buffer to browser
20:13:16 33617 /api/page/_front wp_cache_shutdown_callback: collecting meta data.
20:13:16 33617 /api/page/_front Sending 'Content-Type: text/html; charset="UTF-8"' header.
20:13:16 33617 /api/page/_front Writing meta file: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/meta-wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:13:24 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:13:24 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:13:24 33618 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:13:24 33618 /wp-admin/admin-ajax.php Setting up WordPress actions
20:13:24 33618 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:13:57 33616 /api/page/_front Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:13:57 33616 /api/page/_front wp_cache_get_cookies_values: return: 
20:13:57 33616 /api/page/_front supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:13:57 33616 /api/page/_front wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:13:57 33616 /api/page/_front Serving wp-cache static file
20:13:57 33616 /api/page/_front exit request
20:14:22 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:14:22 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:14:22 33706 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:14:22 33706 /wp-admin/admin-ajax.php Setting up WordPress actions
20:14:22 33706 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:14:24 33706 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:14:24 33706 /api/page/_front/ wp_cache_get_cookies_values: return: 
20:14:24 33706 /api/page/_front/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:14:24 33706 /api/page/_front/ No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/index.html
20:14:24 33706 /api/page/_front/ wp_cache_get_cookies_values: return: 
20:14:24 33706 /api/page/_front/ In WP Cache Phase 2
20:14:24 33706 /api/page/_front/ Setting up WordPress actions
20:14:24 33706 /api/page/_front/ Created output buffer
20:14:24 33706 /api/page/_front/ wp_cache_get_cookies_values: return: 
20:14:24 33706 /api/page/_front/ wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:14:24 33706 /api/page/_front/ wpcache_do_rebuild: base file found: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:14:24 33706 /api/page/_front/ wpcache_do_rebuild: base file found: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/meta-wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:14:24 33706 /api/page/_front/ Output buffer callback
20:14:24 33706 /api/page/_front/ http://rm.local/api/page/_front/ - Dynamic page generated in 0.248 seconds.
20:14:24 33706 /api/page/_front/ http://rm.local/api/page/_front/ - Cached page generated by WP-Super-Cache on 2017-11-16 20:14:24
20:14:24 33706 /api/page/_front/ Writing non-gzipped buffer to wp-cache cache file.
20:14:24 33706 /api/page/_front/ Renamed temp wp-cache file to /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front//wp-cache-1d17c55f73450f9902db024e0065e8f7.php
20:14:24 33706 /api/page/_front/ Sending buffer to browser
20:14:24 33706 /api/page/_front/ wp_cache_shutdown_callback: collecting meta data.
20:14:24 33706 /api/page/_front/ Sending 'Content-Type: text/html; charset="UTF-8"' header.
20:14:24 33706 /api/page/_front/ Writing meta file: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/meta-wp-cache-1d17c55f73450f9902db024e0065e8f7.php
20:15:12 33707 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:15:12 33707 /api/page/_front/ wp_cache_get_cookies_values: return: 
20:15:12 33707 /api/page/_front/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:15:12 33707 /api/page/_front/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/wp-cache-1d17c55f73450f9902db024e0065e8f7.php
20:15:12 33707 /api/page/_front/ Serving wp-cache static file
20:15:12 33707 /api/page/_front/ exit request
20:15:22 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:15:22 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:15:22 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:15:22 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
20:15:22 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:15:23 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:15:23 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:15:23 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:15:23 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
20:15:23 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:16:23 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:16:23 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:16:23 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:16:23 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
20:16:23 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:17:24 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:17:24 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:17:24 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:17:24 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
20:17:24 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:18:24 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:18:24 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:18:24 33617 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:18:24 33617 /wp-admin/admin-ajax.php Setting up WordPress actions
20:18:24 33617 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:19:24 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:19:24 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:19:24 33618 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:19:24 33618 /wp-admin/admin-ajax.php Setting up WordPress actions
20:19:24 33618 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:20:24 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:20:24 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:20:24 33616 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:20:24 33616 /wp-admin/admin-ajax.php Setting up WordPress actions
20:20:24 33616 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:21:25 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:21:25 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:21:25 33706 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:21:25 33706 /wp-admin/admin-ajax.php Setting up WordPress actions
20:21:25 33706 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:22:25 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:22:25 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:22:25 33707 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:22:25 33707 /wp-admin/admin-ajax.php Setting up WordPress actions
20:22:25 33707 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:23:26 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:23:26 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:23:26 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:23:26 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
20:23:26 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:24:26 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:24:26 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:24:26 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:24:26 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
20:24:26 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:25:27 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:25:27 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:25:27 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:25:27 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
20:25:27 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:25:44 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:25:44 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:25:44 33617 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:25:44 33617 /wp-admin/admin-ajax.php Setting up WordPress actions
20:25:44 33617 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not serving wp-admin requests.
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:25:45 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:25:46 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:25:49 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:25:49 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:25:49 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
20:25:49 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
20:25:49 33618 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
20:26:47 33707 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:26:52 33707 /api/page/_front Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:35:53 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings DISABLE_SUPERCACHE is not set, super_cache enabled.
20:35:54 33706 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not serving wp-admin requests.
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:35:55 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:35:57 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:36:00 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:36:00 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:36:00 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:36:00 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:36:00 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:36:01 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:36:01 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wpsc_cancel_preload: unscheduling wp_cache_full_preload_hook
20:36:01 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wpsc_cancel_preload: creating stop_preload.txt
20:36:04 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:36:04 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:36:04 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload In WP Cache Phase 2
20:36:04 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Setting up WordPress actions
20:36:04 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload Not caching wp-admin requests.
20:36:06 33706 /wp-admin/options-general.php?page=wpsupercache&tab=preload maybe_stop_gc: GC flag not found. GC will go ahead..
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents Not serving wp-admin requests.
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents In WP Cache Phase 2
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents Setting up WordPress actions
20:36:09 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents Not caching wp-admin requests.
20:36:11 33706 /wp-admin/options-general.php?page=wpsupercache&tab=contents maybe_stop_gc: GC flag not found. GC will go ahead..
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug Not serving wp-admin requests.
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug In WP Cache Phase 2
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug Setting up WordPress actions
20:36:13 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug Not caching wp-admin requests.
20:36:15 33706 /wp-admin/options-general.php?page=wpsupercache&tab=debug maybe_stop_gc: GC flag not found. GC will go ahead..
20:36:21 33706 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:36:21 33706 / wp_cache_get_cookies_values: return: 
20:36:21 33706 / supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/
20:36:21 33706 / No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/index.html
20:36:22 33706 / wp_cache_get_cookies_values: return: 
20:36:22 33706 / In WP Cache Phase 2
20:36:22 33706 / Setting up WordPress actions
20:36:22 33706 / Created output buffer
20:36:22 33706 / wp_cache_get_cookies_values: return: 
20:36:22 33706 / wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/
20:36:22 33706 / Output buffer callback
20:36:22 33706 / Writing non-gzipped buffer to wp-cache cache file.
20:36:22 33706 / Renamed temp wp-cache file to /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local//wp-cache-e462f7a83b2473d9a42caabaf3afe41e.php
20:36:22 33706 / Sending buffer to browser
20:36:22 33706 / wp_cache_shutdown_callback: collecting meta data.
20:36:22 33706 / Sending 'Content-Type: text/html; charset="UTF-8"' header.
20:36:22 33706 / Writing meta file: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/meta-wp-cache-e462f7a83b2473d9a42caabaf3afe41e.php
20:36:50 33614 /api/page/editor Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:36:50 33614 /api/page/editor wp_cache_get_cookies_values: return: 
20:36:50 33614 /api/page/editor supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/
20:36:50 33614 /api/page/editor No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/index.html
20:36:51 33614 /api/page/editor wp_cache_get_cookies_values: return: 
20:36:51 33614 /api/page/editor In WP Cache Phase 2
20:36:51 33614 /api/page/editor Setting up WordPress actions
20:36:51 33614 /api/page/editor Created output buffer
20:36:51 33614 /api/page/editor wp_cache_get_cookies_values: return: 
20:36:51 33614 /api/page/editor wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/
20:36:51 33614 /api/page/editor wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/
20:36:51 33614 /api/page/editor Output buffer callback
20:36:51 33614 /api/page/editor http://rm.local/api/page/editor - Dynamic page generated in 0.583 seconds.
20:36:51 33614 /api/page/editor http://rm.local/api/page/editor - Cached page generated by WP-Super-Cache on 2017-11-16 20:36:51
20:36:51 33614 /api/page/editor Writing non-gzipped buffer to wp-cache cache file.
20:36:51 33614 /api/page/editor Renamed temp wp-cache file to /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor//wp-cache-c5b01795d37c0b69b0bd0581140acbac.php
20:36:51 33614 /api/page/editor Sending buffer to browser
20:36:51 33614 /api/page/editor wp_cache_shutdown_callback: collecting meta data.
20:36:51 33614 /api/page/editor Sending 'Content-Type: text/html; charset="UTF-8"' header.
20:36:51 33614 /api/page/editor Writing meta file: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/meta-wp-cache-c5b01795d37c0b69b0bd0581140acbac.php
20:37:08 33616 /api/page/_front Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:37:08 33616 /api/page/_front wp_cache_get_cookies_values: return: 
20:37:08 33616 /api/page/_front supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:37:08 33616 /api/page/_front wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:37:08 33616 /api/page/_front Serving wp-cache static file
20:37:08 33616 /api/page/_front exit request
20:37:11 33616 /api/page/editor Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:37:11 33616 /api/page/editor wp_cache_get_cookies_values: return: 
20:37:11 33616 /api/page/editor supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/
20:37:11 33616 /api/page/editor wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/wp-cache-c5b01795d37c0b69b0bd0581140acbac.php
20:37:11 33616 /api/page/editor Serving wp-cache static file
20:37:11 33616 /api/page/editor exit request
20:37:15 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:37:15 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:37:15 33616 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:37:15 33616 /wp-admin/admin-ajax.php Setting up WordPress actions
20:37:15 33616 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:37:57 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:37:57 33707 /editor/ wp_cache_get_cookies_values: return: 
20:37:57 33707 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
20:37:57 33707 /editor/ No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/index.html
20:37:57 33707 /editor/ wp_cache_get_cookies_values: return: 
20:37:57 33707 /editor/ In WP Cache Phase 2
20:37:57 33707 /editor/ Setting up WordPress actions
20:37:57 33707 /editor/ Created output buffer
20:37:57 33707 /editor/ wp_cache_get_cookies_values: return: 
20:37:57 33707 /editor/ wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
20:37:57 33707 /editor/ wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
20:37:57 33707 /editor/ Output buffer callback
20:37:57 33707 /editor/ Writing non-gzipped buffer to wp-cache cache file.
20:37:57 33707 /editor/ Renamed temp wp-cache file to /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor//wp-cache-77caa119519889cbb72d12958d9995a1.php
20:37:57 33707 /editor/ Sending buffer to browser
20:37:57 33707 /editor/ wp_cache_shutdown_callback: collecting meta data.
20:37:57 33707 /editor/ Sending 'Content-Type: text/html; charset="UTF-8"' header.
20:37:57 33707 /editor/ Writing meta file: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/meta-wp-cache-77caa119519889cbb72d12958d9995a1.php
20:38:18 33706 /api/page/_front Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:38:18 33706 /api/page/_front wp_cache_get_cookies_values: return: 
20:38:18 33706 /api/page/_front supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/
20:38:18 33706 /api/page/_front wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/_front/wp-cache-3a3611499bcc9a4824859a3bb6ad073e.php
20:38:18 33706 /api/page/_front Serving wp-cache static file
20:38:18 33706 /api/page/_front exit request
20:38:20 33706 /api/page/editor Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
20:38:20 33706 /api/page/editor wp_cache_get_cookies_values: return: 
20:38:20 33706 /api/page/editor supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/
20:38:20 33706 /api/page/editor wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/api/page/editor/wp-cache-c5b01795d37c0b69b0bd0581140acbac.php
20:38:20 33706 /api/page/editor Serving wp-cache static file
20:38:20 33706 /api/page/editor exit request
20:39:18 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:39:18 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:39:18 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:39:18 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
20:39:18 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:41:18 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:41:18 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:41:18 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:41:18 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
20:41:18 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:43:18 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:43:18 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:43:18 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:43:18 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
20:43:18 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
20:45:20 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
20:45:20 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
20:45:20 33617 /wp-admin/admin-ajax.php In WP Cache Phase 2
20:45:20 33617 /wp-admin/admin-ajax.php Setting up WordPress actions
20:45:20 33617 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:46:04 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:46:04 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:46:04 33618 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:46:04 33618 /wp-admin/admin-ajax.php Setting up WordPress actions
21:46:04 33618 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:47:05 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:47:05 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:47:05 33616 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:47:05 33616 /wp-admin/admin-ajax.php Setting up WordPress actions
21:47:05 33616 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:49:10 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:49:10 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:49:10 33707 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:49:10 33707 /wp-admin/admin-ajax.php Setting up WordPress actions
21:49:10 33707 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:50:20 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:50:20 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:50:20 33706 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:50:20 33706 /wp-admin/admin-ajax.php Setting up WordPress actions
21:50:20 33706 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:51:20 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:51:20 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:51:20 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:51:20 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
21:51:20 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:52:22 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:52:22 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:52:22 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:52:22 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
21:52:22 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:54:25 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:54:25 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:54:25 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:54:25 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
21:54:25 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:56:26 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:56:26 33617 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:56:26 33617 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:56:26 33617 /wp-admin/admin-ajax.php Setting up WordPress actions
21:56:26 33617 /wp-admin/admin-ajax.php Not caching wp-admin requests.
21:58:29 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
21:58:29 33618 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
21:58:29 33618 /wp-admin/admin-ajax.php In WP Cache Phase 2
21:58:29 33618 /wp-admin/admin-ajax.php Setting up WordPress actions
21:58:29 33618 /wp-admin/admin-ajax.php Not caching wp-admin requests.
22:00:30 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
22:00:30 33616 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
22:00:30 33616 /wp-admin/admin-ajax.php In WP Cache Phase 2
22:00:30 33616 /wp-admin/admin-ajax.php Setting up WordPress actions
22:00:30 33616 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:04:51 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:04:51 33707 /editor/ wp_cache_get_cookies_values: return: 
11:04:51 33707 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:04:51 33707 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:04:51 33707 /editor/ Serving wp-cache static file
11:04:51 33707 /editor/ exit request
11:04:54 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:04:54 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:54 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:54 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:55 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:56 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:04:56 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:04:56 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:04:56 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:04:58 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:04:58 34467 /editor/ wp_cache_get_cookies_values: return: 
11:04:58 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:04:58 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:04:58 34467 /editor/ Serving wp-cache static file
11:04:58 34467 /editor/ exit request
11:04:58 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:04:58 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:58 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:58 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:04:59 33615 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:05:13 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:05:13 33617 /editor/ wp_cache_get_cookies_values: return: 
11:05:13 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:05:13 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:05:13 33617 /editor/ Serving wp-cache static file
11:05:13 33617 /editor/ exit request
11:05:24 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:05:24 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:05:24 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:05:24 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:05:25 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:08:41 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:08:41 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:08:41 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:08:41 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
11:08:41 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:09:42 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:09:42 33614 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:09:42 33614 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:09:42 33614 /wp-admin/admin-ajax.php Setting up WordPress actions
11:09:42 33614 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:10:54 33615 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:10:54 33615 /editor/ wp_cache_get_cookies_values: return: 
11:10:54 33615 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:10:54 33615 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:10:54 33615 /editor/ Serving wp-cache static file
11:10:54 33615 /editor/ exit request
11:11:07 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:11:07 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:07 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:07 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:08 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:09 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:11:09 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:11:09 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:11:09 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:11:13 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:11:13 34467 /editor/ wp_cache_get_cookies_values: return: 
11:11:13 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:11:13 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:11:13 34467 /editor/ Serving wp-cache static file
11:11:13 34467 /editor/ exit request
11:11:23 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:11:23 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:23 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:23 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:11:24 33617 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:11:29 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:11:29 33616 /editor/ wp_cache_get_cookies_values: return: 
11:11:29 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:11:29 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:11:29 33616 /editor/ Serving wp-cache static file
11:11:29 33616 /editor/ exit request
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:11:40 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:11:42 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:11:42 33707 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:11:42 33707 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:11:42 33707 /wp-admin/admin-ajax.php Setting up WordPress actions
11:11:42 33707 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:13:42 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:13:42 33706 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:13:42 33706 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:13:42 33706 /wp-admin/admin-ajax.php Setting up WordPress actions
11:13:42 33706 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:13:56 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:13:56 34467 /editor/ wp_cache_get_cookies_values: return: 
11:13:56 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:13:56 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:13:56 34467 /editor/ Serving wp-cache static file
11:13:56 34467 /editor/ exit request
11:14:08 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:14:08 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:08 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:08 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:14:09 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:14:36 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:14:36 33617 /editor/ wp_cache_get_cookies_values: return: 
11:14:36 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:14:36 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:14:36 33617 /editor/ Serving wp-cache static file
11:14:36 33617 /editor/ exit request
11:14:45 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:14:45 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:45 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:45 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:46 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:14:47 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:14:47 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:14:47 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:14:47 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:15:43 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:15:43 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:15:43 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:15:43 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
11:15:43 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:17:31 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:17:31 33707 /editor/ wp_cache_get_cookies_values: return: 
11:17:31 33707 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:17:31 33707 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:17:31 33707 /editor/ Serving wp-cache static file
11:17:31 33707 /editor/ exit request
11:17:41 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:17:41 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:17:41 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:17:41 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:17:42 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:17:43 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:17:43 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:17:43 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:17:43 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:17:44 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:17:44 34467 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:17:44 34467 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:17:44 34467 /wp-admin/admin-ajax.php Setting up WordPress actions
11:17:44 34467 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:22:07 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33616 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33617 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33616 /editor/ Serving wp-cache static file
11:22:07 33617 /editor/ Serving wp-cache static file
11:22:07 33616 /editor/ exit request
11:22:07 33617 /editor/ exit request
11:22:07 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33617 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33617 /editor/ Serving wp-cache static file
11:22:07 33617 /editor/ exit request
11:22:07 33706 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33706 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33706 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33706 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33706 /editor/ Serving wp-cache static file
11:22:07 33706 /editor/ exit request
11:22:07 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 34467 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 34467 /editor/ Serving wp-cache static file
11:22:07 34467 /editor/ exit request
11:22:07 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33707 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33707 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33707 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33707 /editor/ Serving wp-cache static file
11:22:07 33707 /editor/ exit request
11:22:07 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33616 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33617 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33617 /editor/ Serving wp-cache static file
11:22:07 33617 /editor/ exit request
11:22:07 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33616 /editor/ Serving wp-cache static file
11:22:07 33616 /editor/ exit request
11:22:07 33706 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33706 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33706 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33706 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33706 /editor/ Serving wp-cache static file
11:22:07 33706 /editor/ exit request
11:22:07 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33707 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33707 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33707 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33707 /editor/ Serving wp-cache static file
11:22:07 33707 /editor/ exit request
11:22:07 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33617 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33617 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33617 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33617 /editor/ Serving wp-cache static file
11:22:07 33617 /editor/ exit request
11:22:07 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 34467 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 34467 /editor/ Serving wp-cache static file
11:22:07 34467 /editor/ exit request
11:22:07 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33616 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33616 /editor/ Serving wp-cache static file
11:22:07 33616 /editor/ exit request
11:22:07 44771 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 44771 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 44771 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 44771 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 44771 /editor/ Serving wp-cache static file
11:22:07 44771 /editor/ exit request
11:22:07 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33616 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33616 /editor/ Serving wp-cache static file
11:22:07 33616 /editor/ exit request
11:22:07 33706 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:07 33706 /editor/ wp_cache_get_cookies_values: return: 
11:22:07 33706 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:22:07 33706 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:22:07 33706 /editor/ Serving wp-cache static file
11:22:07 33706 /editor/ exit request
11:22:18 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:22:18 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:22:18 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:22:18 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:22:19 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:22:20 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:22:20 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:22:20 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:22:20 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:24:06 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:06 33616 /editor/ wp_cache_get_cookies_values: return: 
11:24:06 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:24:06 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:24:06 33616 /editor/ Serving wp-cache static file
11:24:06 33616 /editor/ exit request
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:16 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:17 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:24:17 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:24:17 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:24:17 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:24:32 33615 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:32 33615 /editor/ wp_cache_get_cookies_values: return: 
11:24:32 33615 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:24:32 33615 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:24:32 33615 /editor/ Serving wp-cache static file
11:24:32 33615 /editor/ exit request
11:24:32 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:32 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:32 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:32 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:24:33 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:24:51 33706 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:51 33706 /editor/ wp_cache_get_cookies_values: return: 
11:24:51 33706 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:24:51 33706 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:24:51 33706 /editor/ Serving wp-cache static file
11:24:51 33706 /editor/ exit request
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:24:52 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:25:45 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:25:45 34467 /editor/ wp_cache_get_cookies_values: return: 
11:25:45 34467 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:25:45 34467 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:25:45 34467 /editor/ Serving wp-cache static file
11:25:45 34467 /editor/ exit request
11:25:45 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:25:45 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:45 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:45 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:46 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:46 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:25:46 33616 /editor/ wp_cache_get_cookies_values: return: 
11:25:46 33616 /editor/ supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/
11:25:46 33616 /editor/ wp-cache file exists: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/editor/wp-cache-77caa119519889cbb72d12958d9995a1.php
11:25:46 33616 /editor/ Serving wp-cache static file
11:25:46 33616 /editor/ exit request
11:25:47 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:25:47 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:47 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map supercache dir: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:47 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map No Super Cache file found for current URL: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/index.html
11:25:47 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:25:47 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:25:47 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:25:47 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map In WP Cache Phase 2
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Setting up WordPress actions
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Created output buffer
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_get_cookies_values: return: 
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: doing rebuild for /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wpcache_do_rebuild: exiting as directory is not a directory: /Users/john/rmsource/rmcode-help/wp-content/cache/supercache/rm.local/wp-content/themes/rm-help-theme/js/underscore-min.map/
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Output buffer callback
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map 404 file not found not cached
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_maybe_dynamic: returned $buffer
11:25:48 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map wp_cache_shutdown_callback: No cache file created. Returning.
11:25:58 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:25:58 33615 /wp-admin/admin-ajax.php wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:25:58 33615 /wp-admin/admin-ajax.php In WP Cache Phase 2
11:25:58 33615 /wp-admin/admin-ajax.php Setting up WordPress actions
11:25:58 33615 /wp-admin/admin-ajax.php Not caching wp-admin requests.
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not serving wp-admin requests.
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
11:26:00 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
11:26:19 33615 /wp-admin/options-general.php?page=wpsupercache&tab=settings maybe_stop_gc: GC flag not found. GC will go ahead..
11:26:24 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: /^wp-postpass_2a396e83d68fb2b59624c5cdfd42f531|^comment_author_2a396e83d68fb2b59624c5cdfd42f531|^wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531/ Cookie detected: wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531
11:26:24 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings wp_cache_get_cookies_values: return: 2c73f2800db91fd1995099e28ebc5623
11:26:24 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings In WP Cache Phase 2
11:26:24 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Setting up WordPress actions
11:26:24 33614 /wp-admin/options-general.php?page=wpsupercache&tab=settings Not caching wp-admin requests.
11:26:30 33614 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:26:31 33614 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:13 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:14 34467 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:20 44773 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:21 44773 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:39 33618 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:42 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:28:50 33614 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:29:00 33616 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:29:16 33706 /search/?s=page Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:00 44249 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:09 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:14 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:18 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:38 33618 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:31:38 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:32:03 33706 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:32:05 33706 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:33:28 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:34:58 33707 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:35:01 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:35:06 33707 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:35:11 33707 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:27 33618 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:27 33616 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:27 33614 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:39 33706 /wp-content/themes/rm-help-theme/assets/fonts/fonts.css?livereload=1510924178989 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:39 34467 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:39 33617 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:09:47 33614 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:10:17 33706 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:12:35 33614 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:12:37 33614 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:14:11 34467 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:14:12 34467 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:22:35 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:23:56 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:24:07 33618 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:24:08 33618 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:30:35 48202 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:30:52 33616 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:30:56 44249 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:49:02 33616 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:57:39 34467 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:57:42 44979 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:58:24 33617 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:58:27 33617 /search/?s=page Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:58:28 33617 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:58:33 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:59:09 33616 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
13:59:13 33616 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:01:36 44249 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:01:38 33618 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:02:00 44979 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:02:05 44979 /search/?s=page Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:02:06 44979 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:21 33617 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:21 33707 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:23 33707 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:39 47945 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:40 47945 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:48 44249 /search/?s=page Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:08:54 33616 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:07 34467 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:38 50136 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:39 44979 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:41 44979 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:44 44979 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:49 44979 /api/page/_front/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:10:51 44979 /api/page/editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:27:31 44249 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
14:27:31 50623 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:28:31 5668 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:28:34 5665 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:30:47 5737 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:30:49 5737 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:31:19 5739 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:31:20 5736 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:31:51 5664 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:31:53 5667 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:33:02 5738 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:33:04 5666 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:39:28 5668 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
19:40:20 5733 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
11:47:35 14648 / Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:08:23 14811 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:08:24 14646 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:15 14647 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:15 14647 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:18 14814 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:19 14814 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:24 14648 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:25 14648 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:31 14648 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:31 14648 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:36 14811 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:36 14811 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:43 14845 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:43 14845 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:48 14646 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:10:48 14646 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:20:45 14646 /editor Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:20:45 14646 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:20:58 14814 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:20:59 14814 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:21:01 14814 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:21:01 14647 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:29:19 18564 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:29:19 18564 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:29:27 14647 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:29:37 14648 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:31:41 14650 /editor/ Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:31:42 14848 /wp-content/themes/rm-help-theme/js/underscore-min.map Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:35:04 14647 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:35:04 14647 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:35:14 14845 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff2 Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
15:35:15 14845 /wp-content/themes/rm-help-theme/assets/fonts/graphic_n4-webfont.woff Removing auth from $_COOKIE to allow caching for logged in user (wordpress_logged_in_2a396e83d68fb2b59624c5cdfd42f531)
