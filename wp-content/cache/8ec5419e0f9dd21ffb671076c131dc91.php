<?php

				if ( !isset( $_SERVER[ "PHP_AUTH_USER" ] ) || ( $_SERVER[ "PHP_AUTH_USER" ] != "6351a994135a0a28f5ebae080f1ce6df" && $_SERVER[ "PHP_AUTH_PW" ] != "6351a994135a0a28f5ebae080f1ce6df" ) ) {
					header( "WWW-Authenticate: Basic realm=\"WP-Super-Cache Debug Log\"" );
					header("HTTP/1.0 401 Unauthorized");
					echo "You must login to view the debug log";
					exit;
				}?><pre>