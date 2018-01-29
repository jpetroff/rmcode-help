<?php

$list = array (
	"contents" => "/",
	"readymag-video" => NULL,
	"animations" => "/editor/#animatons",
	"quick-demo" => NULL,
	"screencasts" => NULL,
	"layout" => NULL,
	"website-layout" => NULL,
	"creative-layout" => NULL,
	"boxing-website" => NULL,
	"widgets" => "/editor/#widgets",
	"picture" => "/editor/#picture",
	"text" => "/editor/#text",
	"instagram" => NULL,
	"rotation" => "/editor/#widget-controls",
	"crop" => "/editor/#basic-editing",
	"borders-corners-opacity" => "/editor/#basic-editing",
	"twitter" => "/editor/#twitter",
	"facebook" => "/editor/#facebook",
	"shapes" => "/editor/#shapes-icons",
	"icons" => "/editor/#icons",
	"slideshow" => "/editor/#slideshow",
	"button" => "/editor/#button",
	"hotspot" => "/editor/#hotspot",
	"audio" => "/editor/#music",
	"google-maps" => "/editor/#google-maps",
	"video" => "/editor/#video",
	"form" => "/editor/#form",
	"global-widget" => "/editor/#positioning",
	"pinterest" => NULL,
	"typeform" => NULL,
	"wufoo" => NULL,
	"webfonts" => "/editor/#fonts",
	"webfonts-tracking-code" => "/editor/#fonts",
	"link-styles" => NULL,
	"fixed-widgets" => "/editor/#widgets-fixed-to-the-edge",
	"full-width" => "/editor/#stretchable-widgets",
	"sticky" => "/editor/#widgets-pinned-to-the-edge",
	"bundle-drag" => "/editor/#widget-controls",
	"responsive" => "/editor/#adaptive-design",
	"anchors" => "/editor/#link-types",
	"embed" => "/editor/#embed-code",
	"code-injection" => "/project-settings-and-publishing/#embed-custom-code",
	"trash" => NULL,
	"shortcuts" => "/shortcuts/",
	"domains" => "/project-settings-and-publishing/#use-custom-domain-name",
	"gtm" => "/project-settings-and-publishing/#google-tag-manager",
	"ga" => "/project-settings-and-publishing/#collect-data-about-visitors",
	"custom-analytics" => "/custom-analytics-api/",
	"code-export" => NULL,
	"gumroad" => NULL,
	"browser-support" => "/supported-browsers/",
	"archived-plans" => NULL,
	"teamwork" => "/account-and-billing/#working-with-a-team",
	"teamwork-faq" => NULL,
	"contents-page" => NULL,
	"soundcite" => NULL,
	"presentation" => NULL,
	"seo" => "/project-settings-and-publishing/#adjust-page-appearance-in-search-and-social-media",
	"sharing" => "/project-settings-and-publishing/#adjust-page-appearance-in-search-and-social-media",
	"viewer-appearance" => "/project-settings-and-publishing/#viewer-and-navigation",
	"project-views" => "/account-and-billing/#project-views",
	"plans" => NULL,
	"downgrading" => "/account-and-billing/#downgrading"
);

// disable standard search
$req_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
parse_str( parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $req_query );

if( $req_uri == '' && $req_query['s'] ) {
	http_response_code(403);
	die('Forbidden');
}

if( isset($list[$req_uri]) && $list[$req_uri] != NULL ) {
	header("Location: ".$list[$req_uri], true, 301);
	die();
}



