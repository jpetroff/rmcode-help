<?php
	if( defined('LOCAL') ) :
?>
	<script>
		document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
			':35729/livereload.js?snipver=1"></' + 'script>')
	</script>
<?php endif; ?>
	<script>
		window._home_url = document.createElement('a'); window._home_url.href = '<?php echo trailingslashit(home_url()); ?>';
		window._site_title = '<?php bloginfo('name');  ?>';
	</script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/libs.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/app.js"></script>
	<!-- BEGIN GROOVE WIDGET CODE -->
	<script id="grv-widget">
		/*<![CDATA[*/
		window.groove = window.groove || {}; groove.widget = function(){ groove._widgetQueue.push(Array.prototype.slice.call(arguments)); }; groove._widgetQueue = [];
		groove.widget('setWidgetId', '3910cca5-d6cf-0982-cec6-1538812506eb');
		!function(g,r,v){var a,n,c=r.createElement("iframe");(c.frameElement||c).style.cssText="width: 0; height: 0; border: 0",c.title="",c.role="presentation",c.src="javascript:false",r.body.appendChild(c);try{a=c.contentWindow.document}catch(i){n=r.domain;var b=["javascript:document.write('<he","ad><scri","pt>document.domain=","\"",n,"\";</scri","pt></he","ad><bo","dy></bo","dy>')"];c.src=b.join(""),a=c.contentWindow.document}var d="https:"==r.location.protocol?"https://":"http://",s="http://groove-widget-production.s3.amazonaws.com".replace("http://",d);c.className="grv-widget-tag",a.open()._l=function(){n&&(this.domain=n);var t=this.createElement("script");t.type="text/javascript",t.charset="utf-8",t.async=!0,t.src=s+"/loader.js",this.body.appendChild(t)};var p=["<bo",'dy onload="document._l();">'];a.write(p.join("")),a.close()}(window,document)
		/*]]>*/
	</script>
	<!-- END GROOVE WIDGET CODE -->
	</body>
</html>
