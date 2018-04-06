<?php
global $rm_state_array;

$projects = get_option('rm-imported-projects');

$sPostID = $post->ID;
$sProject = get_post_meta($post->ID, 'associated_project', true);

$project = $projects[$sProject];

$pScreenshot = $project['meta']['wp_screenshot'][0];
$pTitle = $project['title'];
$pDescription = $project['meta']['description'] != '' ? $project['meta']['description'] : '<span class="fade-description">(Silence is gold. Description is empty.)</span>';
$pNumid = $project['meta']['num_id'];
$pPushstate = ($project['pushstate'] == true ? 'checked' : '' );

$pEditBacklink = '';
if ($projects[$sProject]['meta']['num_id']) $pEditBacklink = "
	<div class='edit-backlink-wrapper flat-button settings-item'>
		<a href='https://my.readymag.com/edit/{$projects[$sProject]['meta']['num_id']}/contents' class='edit-backlink' target=_blank>Open in Readymag Editor</a>
	</div>
";

$arrSamplePermalink = get_sample_permalink($post->ID);
$pPermalink = str_replace(array('%pagename%', '%postname%'), "<span class='active input-item'>".$arrSamplePermalink[1]."</span>", $arrSamplePermalink[0]);
$sPermalink = str_replace(array('%pagename%', '%postname%'), $arrSamplePermalink[1], $arrSamplePermalink[0]);

$settings_form = "
<div class='rm-post-wrapper postbox' id='rm-custom-post-title'>
	<input type='hidden' value='{$sProject}' name='associated-project' />
	<div class='project-item'>
		<div class='left-col'>
			<div class='project-screenshot'><img class='project-screenshot-img' src='{$pScreenshot}' /></div>
		</div>
		<div class='right-col'>
			<div class='description-section'>
				<p class='project-description'>
					{$pDescription}
				</p>
			</div>
		</div>
		<div class='settings-section'>
			<div class='settings-row featured-image'>
				<div class='flat-button' id='change-featured'>
					Change Featured Image
				</div>
			</div>
			<div class='settings-row'>
				<div class='flat-button settings-item' id='rm-uploader-update-button'>
					Update Project
				</div>
				{$pEditBacklink}
			</div>
		</div>
	</div>
</div>
<div class='rm-permalink-wrapper postbox' data-state='0'>
	<input type='hidden' id='rm-permalink-nonce' value='".wp_create_nonce('rm_save_permalink')."'>
	<span class='rm-permalink-wrapper__item main-label'>Permalink</span>
	<a href='{$sPermalink}' target='_blank' class='rm-permalink-wrapper__item permalink'>
		{$pPermalink}
	</a>
	<div class='rm-permalink-wrapper__item main-action' >
		<span class='label change'>change</span>
		<span class='label save'>done</span>
	</div>
	<div class='rm-permalink-wrapper__item secondary-action'>
		<span class='label'>cancel</span>
	</div>
</div>
<div class='rm-feed-content-disclaimer'>
	The content below will only appear<br /> on taxonomy pages like categories and tags
</div>
";


echo $settings_form;
echo print_upload_component( 'update' , true, $sProject );






