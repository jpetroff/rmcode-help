<?php

global $rm_state_array, $rm_plugin_settings;

$rm_projects_folder = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'rm-projects';

manage_update_requests();

// requrements
$has_html_parser = class_exists('DOMDocument');
$has_filesystem_access = is_writable($rm_projects_folder);

$projects = get_project_settings();
$index_list = get_option('rm-imported-projects-index');

echo '<div class="rm-importer-wrapper wrap">';
echo '<h1 class="rm-importer-settings-header">R/m Plugin Settings</h1>';

if(!isset($rm_plugin_settings))
	$rm_plugin_settings = get_option('rm-importer-settings');

$pSlug = str_replace('/', '', $rm_plugin_settings['slug']);
$pCanonicalPrefix = get_home_url().'/';
$pCanonical = $pCanonicalPrefix.($pSlug != '' ? '<span class="slug-item-example">'.$pSlug.'/</span>' : '').'project-url';
$pHardPatch = $rm_plugin_settings['hard_patch'] ? 'checked' : '';
$pMixInLoop = $rm_plugin_settings['mix_in_loop'] ? 'checked' : '';

$settings_card = "
<div class='rm-plugin-settings' id='rm-plugin-settings-app'>
	<form action ='' method='POST'>

		<div class='settings-item-wrapper settings-page-card'>
			<p class='settings-item-label input-label'>
				URL structure
			</p>
			<div class='settings-item'>
				<div class='slug-input-wrapper' v-on:click='focus'>
					<!--<span class='label'>Specify common slug</span>-->
					<span class='base'>{$pCanonicalPrefix}</span>
					<div class='input-wrapper'>
						<input type='text' name='custom-post-slug' class='rm-plugin-settings__input' value='{$pSlug}' autocomplete='off' v-model='value' ref='slugInput' />
						<span class='placeholder' v-show=\"value == ''\">&nbsp;&mdash;&nbsp;enter slug or leave empty</span>
					</div>
				</div>
				<p class='settings-item__p'>Project links would look like <strong>{$pCanonicalPrefix}<span class='slug-sample-part' v-show=\"value != ''\">{{value}}/</span>project-url/</strong></p>
				<input type='hidden' name='prev-custom-post-slug' value='{$pSlug}' />
			</div>
		</div>

		<div class='settings-item-wrapper settings-page-card'>
			<div class='settings-item-label'>
				<label class='rm-switcher'>
					<input class='checkbox' type='checkbox' name='mix-in-loop' {$pMixInLoop}>
					<span class='back'></span><span class='slider'></span>
				</label>
				<span class='settings-item-label__header'>Show R/m projects on taxonomy pages</span>
			</div>
			<div class='settings-item'>
				Show Readymag projects on taxonomy pages like categories, tags and any other pages that display multiple posts.
			</div>
		</div>

		<div class='settings-item-wrapper settings-page-card'>
			<div class='settings-item-label'>
				<label class='rm-switcher'>
					<input class='checkbox' type='checkbox' name='try-hard-patch' {$pHardPatch} >
					<span class='back'></span><span class='slider'></span>
				</label>
				<span class='settings-item-label__header'>Resolve conflicts with a cache plugin</span>
			</div>
			<label class='settings-item'>
				<input type='hidden' name='prev-hard-patch' class='rm-plugin-settings__input-checkbox' value='{$pHardPatch}' />
				If you have a cache plugin installed (WP Super Cache, WP Total Cache or other) and you experience problems, turn on this option.
			</label>
		</div>

		<input type='hidden' name='rm-plugin-settings-verification' value='true' />
		<button type='submit' class='plugin-settings-submit'>Save</button>
	</form>
</div>";

echo $settings_card;

function _print_mark( $success ) {
	if($success)
		return
			"
			<span class='bullet-point bullet-point__yes'>
				<svg width='28px' height='28px' viewBox='0 0 28 28' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
						<g id='icons' stroke='#0073AA' stroke-width='2'>
								<g transform='translate(-1.000000, 0.000000)'>
										<g transform='translate(7.000000, 7.000000)'>
												<path d='M0,8 L7,15'></path>
												<path d='M7,15 L16,0'></path>
										</g>
								</g>
						</g>
				</svg>
			</span>";

	return "
		<span class='bullet-point bullet-point__no'>
			<svg width='28px' height='28px' viewBox='0 0 28 28' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
					<g id='error' stroke='#D54E22' stroke-width='2'>
							<g transform='translate(-1.000000, 0.000000)'>
									<g transform='translate(7.000000, 6.000000)'>
											<path d='M15.5563492,-7.10542736e-15 L0,15.5563492'></path>
											<path d='M2.13162821e-14,-2.84217094e-14 L15.5563492,15.5563492'></path>
									</g>
							</g>
					</g>
			</svg>
		</span>";
}

$has_html_parser_mark = _print_mark($has_html_parser);
$has_filesystem_access_mark = _print_mark($has_filesystem_access);
$correctly_installed_mark = _print_mark(defined('RM_CACHE_PHASE1'));
//$correctly_installed_mark = _print_mark(false);
$php_version_mark = _print_mark(version_compare(phpversion(), '5.2.4', '>='));
$current_version = phpversion();

$requirements_card = "
<div class='card settings-page-card rm-plugin-requirements'>
	<h2 class='section-header'>
		Requirements
	</h2>
	<p class='requirements-p'>Plugin content folder: <span class='inline-code'>{$rm_projects_folder}/</span></p>
	<p class='requirements-p'>
		{$correctly_installed_mark}
		Correct installation
	</p>
	<p class='requirements-p'>
		{$has_html_parser_mark}
		HTML parsing (class exists <span class='inline-code'>DOMDocument</span>)
	</p>
	<p class='requirements-p'>
		{$has_filesystem_access_mark}
		Access to the file system
	</p>
	<p class='requirements-p'>
		{$php_version_mark}
		PHP version ({$current_version}) >= 5.2.4
	</p>
</div>";

echo $requirements_card;

echo "<div class='card settings-page-card rm-plugin-debug'>";
echo "<h2 class='section-header'>Debug</h2>";
echo '<p>Attach this information to the support request (<a href="mailto:support@readymag.com">support@readymag.com</a>)</p>';
echo "<textarea readonly class='rm-wide-textarea' rows=20>";
var_dump($projects);
var_dump($index_list);
var_dump($rm_plugin_settings);
echo '</textarea>';
echo '</div>'; // div.rm-plugin-debug

echo '</div>';