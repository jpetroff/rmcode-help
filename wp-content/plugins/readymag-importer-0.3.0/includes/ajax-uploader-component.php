<?php

// outputs uploader form
// $type = 'create' | 'update'
function print_upload_component( $type, $modal = false, $p_id = '' ) {
	global $rm_state_array;

	$new_dirs = get_dir_contents('/uploads');
	$new_zips = get_dir_contents('/uploads', true );

  $root_path = WP_CONTENT_DIR.'/rm-projects';
  list( $max_size, $max_text ) = _return_max_upload_size();
  $nonce = wp_create_nonce( 'rm-importer-upload' );

  $modalClass = $modal ? 'rm-upload-form__modal' : '';
  $modalValue = $modal ? 'true' : 'false';
  $modalVueBinding = $modal ? "v-show='isOpen' v-cloak" : '';

  $inactive_folders = '<optgroup label="Folders">';
	foreach($new_dirs as $dir_str) {
		$dir_caption = basename($dir_str);
		$new_dir_tmpl = "<option class='new-uploaded-dir' value='{$dir_caption}'>{$dir_caption}</option>";
		$inactive_folders .= $new_dir_tmpl;
	}
	$inactive_folders .= '</optgroup>';

	$inactive_zips = '<optgroup label="Archives">';
	foreach($new_zips as $zip_str) {
		$zip_caption = basename($zip_str);
		$new_zip_tmpl = "<option class='new-uploaded-dir' value='{$zip_caption}'>{$zip_caption}</option>";
		$inactive_zips .= $new_zip_tmpl;
	}
	$inactive_zips .= '</optgroup>';

	$upload_output = "
	<div class='rm-upload-form-wrapper {$modalClass}' {$modalVueBinding}>
		<div class='rm-upload-form-component'>
			<div class='rm-upload-form' v-cloak ref='uploadForm' data-max={$max_size}  data-nonce='{$nonce}' data-pid='{$p_id}' data-modal='{$modalValue}'>
				<div class='rm-upload-form__close'
					v-show=\"isModal || upload.uploadStarted\"
					v-on:click='closeClick'
				>
					<svg width='17px' height='17px' viewBox='0 0 17 17' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
							<g id=\"close\" fill=\"#8C8C8C\">
								<path d=\"M9.51015254,8.5 L15.7907906,14.780638 C16.0697365,15.0595839 16.0697365,15.5118446 15.7907906,15.7907906 C15.5118446,16.0697365 15.0595839,16.0697365 14.780638,15.7907906 L8.5,9.51015254 L2.21936199,15.7907906 C1.94041606,16.0697365 1.48815536,16.0697365 1.20920944,15.7907906 C0.930263519,15.5118446 0.930263519,15.0595839 1.20920944,14.780638 L7.48984746,8.5 L1.20920944,2.21936199 C0.930263519,1.94041606 0.930263519,1.48815536 1.20920944,1.20920944 C1.48815536,0.930263519 1.94041606,0.930263519 2.21936199,1.20920944 L8.5,7.48984746 L14.780638,1.20920944 C15.0595839,0.930263519 15.5118446,0.930263519 15.7907906,1.20920944 C16.0697365,1.48815536 16.0697365,1.94041606 15.7907906,2.21936199 L9.51015254,8.5 Z\" id=\"Combined-Shape\"></path>
							</g>
					</svg>
				</div>
				
				<div class='rm-upload-form__menu-wrapper'>
				
					<div class='rm-upload-form__current'
						v-on:click='showMenu = !upload.uploadStarted'
					>
						{{ currentStateName || 'upload exported project' }}
						<svg v-show=\"upload.uploadStarted == false\" width=\"8px\" height=\"6px\" viewBox=\"0 0 8 6\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
							<g fill=\"#C9C9C9\">
								<polygon id=\"Triangle-2\" points=\"4 5 1 1 7 1\"></polygon>
							</g>
						</svg>
					</div>
					
					<transition name='menu-reveal'>
						<div 	class='rm-upload-form__menu' id='rm-upload-form__menu-control'
								v-show='showMenu'
								v-on:click='changeState(\$event.target.dataset.value, \$event.target.innerText)'
						>
							<div class='menu-item' data-value=1>upload exported project</div>
							<div class='menu-item' data-value=2>use uploaded project</div>
							<div class='menu-item' data-value=0>connect r/m account</div>
						</div>
					</transition>
				</div>
				
				<transition name='switch-tab'>
				
					<label class='rm-upload-form__ajax-upload rm-upload-form_tab' for='simple-project-upload-eqve092' data-state=1
						v-show=\"state == 1\"
						v-on:drop.prevent=\"uploadOnDrop(\$event)\"
						ref='uploaderWrapper'
						v-bind:class=\"[ upload.isDrop ? 'drop-attempt' : '']\"
					>
						<div class='rm-upload-form__uploader-wrapper'>
							<div class='upload-input-wrapper' v-bind:data-upload-stage='uploadStage'>
								<div class='uploader-progress'>
								
									<div class='morph-anim-item morph-anim-init' v-show=\"morphAnimation.frame == 0\">
										<svg width=\"70px\" height=\"70px\" viewBox=\"0 0 70 70\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
											<g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(-93.000000, -151.000000)\">
												<g transform=\"translate(105.000000, 158.000000)\">
													<path d=\"M31.3679296,0 L30.6666667,0 L2,0 C0.8954305,2.02906125e-16 -1.3527075e-16,0.8954305 0,2 L-2.22044605e-16,54 C3.83744532e-15,55.1045695 0.8954305,56 2,56 L44,56 C45.1045695,56 46,55.1045695 46,54 L46,15.2727273 L46,14.4090199 C46,13.3334532 45.5668462,12.303206 44.7982866,11.5507701 L34.1662162,1.14175014 C33.4186548,0.409871789 32.4141103,6.91324708e-15 31.3679296,7.10542736e-15 Z\" id=\"Shape\" stroke=\"#0071AA\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" fill-rule=\"nonzero\"></path>
													<g transform=\"translate(19.000000, 3.000000)\" fill=\"#0073AA\">
														<path d=\"M5,2 L5,4 L6,4 C6.55228475,4 7,4.44771525 7,5 C7,5.55228475 6.55228475,6 6,6 L5,6 L5,8 L6,8 C6.55228475,8 7,8.44771525 7,9 C7,9.55228475 6.55228475,10 6,10 L5,10 L5,12 L6,12 C6.55228475,12 7,12.4477153 7,13 C7,13.5522847 6.55228475,14 6,14 L5,14 L5,16 L6,16 C6.55228475,16 7,16.4477153 7,17 C7,17.5522847 6.55228475,18 6,18 L5,18 L5,20 L6,20 C6.55228475,20 7,20.4477153 7,21 C7,21.5522847 6.55228475,22 6,22 L5,22 L5,24 L6,24 C6.55228475,24 7,24.4477153 7,25 C7,25.5522847 6.55228475,26 6,26 L5,26 L5,28 L6,28 C6.55228475,28 7,28.4477153 7,29 C7,29.5522847 6.55228475,30 6,30 L4,30 C3.44771525,30 3,29.5522847 3,29 L3,28 L2,28 C1.44771525,28 1,27.5522847 1,27 C1,26.4477153 1.44771525,26 2,26 L3,26 L3,24 L2,24 C1.44771525,24 1,23.5522847 1,23 C1,22.4477153 1.44771525,22 2,22 L3,22 L3,20 L2,20 C1.44771525,20 1,19.5522847 1,19 C1,18.4477153 1.44771525,18 2,18 L3,18 L3,16 L2,16 C1.44771525,16 1,15.5522847 1,15 C1,14.4477153 1.44771525,14 2,14 L3,14 L3,12 L2,12 C1.44771525,12 1,11.5522847 1,11 C1,10.4477153 1.44771525,10 2,10 L3,10 L3,8 L2,8 C1.44771525,8 1,7.55228475 1,7 C1,6.44771525 1.44771525,6 2,6 L3,6 L3,4 L2,4 C1.44771525,4 1,3.55228475 1,3 C1,2.44771525 1.44771525,2 2,2 L3,2 L3,1 C3,0.44771525 3.44771525,1.01453063e-16 4,0 L6,0 C6.55228475,-1.01453063e-16 7,0.44771525 7,1 C7,1.55228475 6.55228475,2 6,2 L5,2 Z\" id=\"Combined-Shape\"></path>
														<path d=\"M3.18558711,37.3713875 L0.840656829,33.5200502 C0.553441041,33.0483241 0.703016222,32.4330801 1.17474235,32.1458643 C1.33143167,32.0504622 1.51134472,32 1.69479253,32 L6.38465309,32 C6.93693784,32 7.38465309,32.4477153 7.38465309,33 C7.38465309,33.1834478 7.33419086,33.3633609 7.23878879,33.5200502 L4.89385852,37.3713875 C4.60664273,37.8431136 3.99139875,37.9926888 3.51967262,37.705473 C3.38322428,37.6223949 3.26866523,37.5078358 3.18558711,37.3713875 Z\" id=\"Triangle\"></path>
													</g>
												</g>
											</g>
										</svg>
									</div>
									
									<div class='morph-anim-item morph-anim-1' v-show=\"morphAnimation.frame == 1\">
										<svg width=\"70px\" height=\"70px\" viewBox=\"0 0 70 70\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
											<g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(-209.000000, -151.000000)\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
												<path d=\"M254,158 L251.666667,158 L223,158 C221.895431,158 221,158.895431 221,160 L221,212.00002 C221,213.10459 221.895431,214.00002 223,214.00002 L265.000012,214.000021 C266.104581,214.000021 267.000012,213.10459 267.000012,212.000021 C267.000012,212.000021 267.000012,212.00002 267.000012,212.00002 L267,173.272727 L266.999999,171.521692 C266.999999,170.982647 266.891046,170.449163 266.679686,169.953284 C265.415225,166.986697 263.938663,164.543936 262.25,162.625 C260.416667,160.541667 257.666667,159 254,158 Z\" id=\"Shape\" stroke=\"#2C89B6\" stroke-width=\"2\" fill-rule=\"nonzero\"></path>
											</g>
										</svg>
									</div>
									
									<div class='morph-anim-item morph-anim-2' v-show=\"morphAnimation.frame == 2\">
										<svg width=\"70px\" height=\"70px\" viewBox=\"0 0 70 70\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
											<g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(-319.000000, -151.000000)\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
												<path d=\"M331,160 L331,212.000042 C331,213.104611 331.895431,214.000042 333,214.000042 L375.00003,214.000042 C376.104599,214.000042 377.00003,213.104611 377.00003,212.000042 L377.00003,160 C377.00003,158.895431 376.104599,158 375.00003,158 L333,158 C331.895431,158 331,158.895431 331,160 Z\" id=\"Shape\" stroke=\"#6CAAC7\" stroke-width=\"2\" fill-rule=\"nonzero\"></path>
											</g>
										</svg>
									</div>
									
									<div class='morph-anim-item morph-anim-3' v-show=\"morphAnimation.frame == 3\">
										<svg width=\"70px\" height=\"70px\" viewBox=\"0 0 70 70\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
											<g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(-439.000000, -151.000000)\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
												<path d=\"M452.513213,159.789494 C447.524895,165.735995 445.547019,203.485195 452.513213,211.789494 C459.479408,220.093793 490.826795,218.56819 496.513213,211.789494 C502.199632,205.010798 502.226625,166.600369 496.513213,159.789494 C490.799801,152.978619 457.501531,153.842993 452.513213,159.789494 Z\" id=\"Shape\" stroke=\"#BDD3DD\" stroke-width=\"2\" fill-rule=\"nonzero\"></path>
											</g>
										</svg>
									</div>
									
									<div class='morph-anim-item morph-anim-4' v-show=\"morphAnimation.frame == 4\">
										<svg width=\"70px\" height=\"70px\" viewBox=\"0 0 70 70\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
											<g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(-562.000000, -151.000000)\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
												<path d=\"M576.732764,160.969026 C565.482764,171.469026 565.052057,197.23671 575.732764,209.969026 C586.413472,222.701341 609.577636,220.882721 618.732764,209.969026 C627.887893,199.055331 627.357764,171.719026 617.732764,160.969026 C608.107764,150.219026 587.982764,150.469026 576.732764,160.969026 Z\" id=\"Shape\" stroke=\"#DBE2E5\" stroke-width=\"2\" fill-rule=\"nonzero\"></path>
											</g>
										</svg>
									</div>
									
									<div class='morph-anim-item morph-anim-final' v-show=\"morphAnimation.frame == 5\">
										<svg id='uploader-progress-svg-bar' width='68px' height='68px' viewBox='0 0 68 68' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
											<circle fill='none' cx='34' cy='34' r='33' style='stroke: rgb(234, 234, 234); stroke-width: 2;'></circle>
											<path id='uploader-progress-svg-bar__percentage-arc' fill='none' style='stroke-width: 2; stroke: #0073AA' v-bind:d=\"upload.progressArcCoords\"></path>
										</svg>
									</div>
									
									<span class='center-icon progress-value'>{{ upload.progressCaption }}</span>
									
									<i class='center-icon success-icon'>
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
									</i>
									
									<i class='center-icon error-icon'>
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
									</i>
									
									
								</div>
								<div class='uploader-filename'>
									<span class='caption default'>choose or drop zip</span>
									<span class='caption current'>{{ upload.file && upload.file.name }}</span>
									<span class='caption finished'>extracting source from zip</span>
									<span class='caption error'>sorry, upload failed</span>
									<span class='caption drop'>drop file</span>
								</div>
							</div>
							<input type='file' id='simple-project-upload-eqve092' class='hidden-uploader' name='project-upload' accept='application/zip'
								v-on:change='addedFile(\$event.currentTarget)'
								ref='uploaderInput'
							/>
						</div>
					</label>
					
				</transition><transition name='switch-tab'>
				
					<div class='rm-upload-form__use-uploaded rm-upload-form_tab' data-state=2
						v-show=\"state == 2\"
					>
						<p class='method-description method-description_adjacent'>
							<span class='bullet'>1</span>
							
							Upload exported zip file or unzipped folder to</br>
							<span class='project-folder inline-code'>{$root_path}/uploads/</span></br>
							through ssh, ftp or any other transfer method.
						</p>
						
						<p class='method-description'>
							<span class='bullet'>2</span>
							Choose uploaded folder or archive from the list:
						</p>
						
						<div class='folder-select-wrapper'>
							<select class='folder-select' v-on:change=\"onSelectUploaded(\$event.currentTarget.value)\">
								<option selected value='none' disabled>(zip or folder)</option>
								{$inactive_folders}
								{$inactive_zips}
							</select>
							<div class='select-triangle'>
								<svg width='8px' height='6px' viewBox='0 0 8 6' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
									<g transform='translate(-588.000000, -269.000000)' fill='#444444'>
											<g transform='translate(286.000000, 178.000000)'>
													<polygon id='Triangle-2' points='306 97 302 91 310 91'></polygon>
											</g>
									</g>
								</svg>
							</div>
						</div>
						<div class='activate-button' v-bind:class=\"[ ( useUploaded.selected ? '' : 'disabled' ) ]\" v-on:click.prevent='onUseUploadedClick'>{$type}</div>
					</div>
					
				</transition><transition name='switch-tab'>
					
					<div class='rm-upload-form__rm-account rm-upload-form_tab' data-state=0
						v-show=\"state == 0\"
					>
						<h2 class='header'>We’ll make it happen later</h2>
						<div class='coming-soon-emblem'>
							<svg width=\"139px\" height=\"139px\" viewBox=\"0 0 139 139\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
								<defs>
									<linearGradient x1=\"6.55748304%\" y1=\"69.104435%\" x2=\"95.7508711%\" y2=\"42.9037296%\" id=\"linearGradient-1\">
										<stop stop-color=\"#FFC155\" offset=\"0%\"></stop>
										<stop stop-color=\"#FFA200\" offset=\"100%\"></stop>
									</linearGradient>
								</defs>
								<g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
									<g id=\"emblem\">
										<g transform=\"translate(3.000000, 3.000000)\">
											<polygon id=\"Star\" fill=\"url(#linearGradient-1)\" transform=\"translate(66.500000, 66.500000) rotate(-360.000000) translate(-66.500000, -66.500000) \" points=\"66.5 129.520001 58.8304334 134.569286 52.4767305 127.939958 43.8758843 131.156008 39.1566463 123.279059 30.0558028 124.500608 27.207672 115.771021 18.0631855 114.936815 17.2289791 105.792328 8.49939235 102.944197 9.72094091 93.8433537 1.84399187 89.1241157 5.06004186 80.5232695 -1.56928638 74.1695666 3.47999886 66.5 -1.56928638 58.8304334 5.06004186 52.4767305 1.84399187 43.8758843 9.72094091 39.1566463 8.49939235 30.0558028 17.2289791 27.207672 18.0631855 18.0631855 27.207672 17.2289791 30.0558028 8.49939235 39.1566463 9.72094091 43.8758843 1.84399187 52.4767305 5.06004186 58.8304334 -1.56928638 66.5 3.47999886 74.1695666 -1.56928638 80.5232695 5.06004186 89.1241157 1.84399187 93.8433537 9.72094091 102.944197 8.49939235 105.792328 17.2289791 114.936815 18.0631855 115.771021 27.207672 124.500608 30.0558028 123.279059 39.1566463 131.156008 43.8758843 127.939958 52.4767305 134.569286 58.8304334 129.520001 66.5 134.569286 74.1695666 127.939958 80.5232695 131.156008 89.1241157 123.279059 93.8433537 124.500608 102.944197 115.771021 105.792328 114.936815 114.936815 105.792328 115.771021 102.944197 124.500608 93.8433537 123.279059 89.1241157 131.156008 80.5232695 127.939958 74.1695666 134.569286\"></polygon>
											<g id=\"truck\" transform=\"translate(14.000000, 39.000000)\">
												<path d=\"M38.5,42 C38.6508534,42.9943108 38.6508534,43.0056892 38.5,44 L52.5,44 C52.3491466,43.0056892 52.3491466,42.9943108 52.5,42 L38.5,42 Z\" id=\"Shape\" fill=\"#FFFFFF\" fill-rule=\"nonzero\"></path>
												<path d=\"M29,10.5 C29.0099381,9.53103142 29.765625,9 30.5,9 L51,9 C52.1155596,9.00591414 52.8133436,10.4174004 53.12,11.49 L59.26,33 C60.1874535,32.6155092 60.2219297,32.5260516 61.21875,32.40625 L54.9375,10.53125 C54.2609287,8.1691731 53.4570514,7.00739203 51,7 L30.5,7 C28.8905736,7.00291828 26.9874994,8.24989584 27,10.5 L27,32.38 C27.659553,32.2563424 28.3896484,32.2406921 29,32.3826294 C29,31.6299438 29,10.5 29,10.5 Z\" id=\"Shape\" fill=\"#FFFFFF\" fill-rule=\"nonzero\"></path>
												<path d=\"M101.042798,40.7550645 C101.042798,39.9266374 100.371225,39.7550645 99.5427979,39.7550645 L71.6996153,39.699491 L71.6996153,5.86949099 C71.6996153,5.04106386 71.5280424,4.36949099 70.6996153,4.36949099 C69.8711882,4.36949099 69.6996153,5.04106386 69.6996153,5.86949099 L69.6996153,39.999491 C69.6996153,40.8279181 70.7011882,41.699491 71.5296153,41.699491 L99.5427979,41.7550645 C100.371225,41.7550645 101.042798,41.5834917 101.042798,40.7550645 Z\" id=\"Shape\" fill=\"#FFFFFF\" fill-rule=\"nonzero\" transform=\"translate(85.371207, 23.062278) rotate(-16.000000) translate(-85.371207, -23.062278) \"></path>
												<circle id=\"Oval-11\" stroke=\"#FFFFFF\" stroke-width=\"2\" cx=\"28\" cy=\"43\" r=\"7\"></circle>
												<circle id=\"Oval-11\" stroke=\"#FFFFFF\" stroke-width=\"2\" cx=\"63\" cy=\"43\" r=\"7\"></circle>
												<g id=\"block\" transform=\"translate(87.690861, 23.355325) rotate(-16.000000) translate(-87.690861, -23.355325) translate(74.690861, 10.355325)\" fill=\"#FFFFFF\">
													<path d=\"M2.17788254,0.246123165 L23.1778825,0.246123165 C24.282452,0.246123165 25.1778825,1.14155367 25.1778825,2.24612316 L25.1778825,23.2461232 C25.1778825,24.3506927 24.282452,25.2461232 23.1778825,25.2461232 L2.17788254,25.2461232 C1.07331304,25.2461232 0.177882539,24.3506927 0.177882539,23.2461232 L0.177882539,2.24612316 C0.177882539,1.14155367 1.07331304,0.246123165 2.17788254,0.246123165 Z M9.60719913,15.8039099 L7.15123556,13.6064688 L7.15123556,13.5695371 L9.60719913,11.372096 L8.38845029,10.2456766 L4.6768061,13.588003 L8.38845029,16.9303293 L9.60719913,15.8039099 Z M14.9285063,8.26982621 L13.1003831,8.26982621 L10.3489652,19.1462363 L12.1770885,19.1462363 L14.9285063,8.26982621 Z M15.6702718,15.8039099 L16.8890207,16.9303293 L20.6006649,13.588003 L16.8890207,10.2456766 L15.6702718,11.372096 L18.1262354,13.5695371 L18.1262354,13.6064688 L15.6702718,15.8039099 Z\" id=\"Combined-Shape\"></path>
												</g>
												<path d=\"M5.5,31 L17.5,31\" id=\"Line-7\" stroke=\"#FFFFFF\" stroke-width=\"2\" stroke-linecap=\"round\"></path>
												<path d=\"M0.5,37 L12.5,37\" id=\"Line-7\" stroke=\"#FFFFFF\" stroke-width=\"2\" stroke-linecap=\"round\"></path>
											</g>
										</g>
									</g>
								</g>
							</svg>
						</div>
					</div>
					
				</transition>
			</div>
		</div>
	</div>
	";

	if($modal) {
		$upload_output = "<div id='rm-upload-form-component'><transition name='modal-transition'>".$upload_output."</transition></div>";
	} else {
		$upload_output = "<div id='rm-upload-form-component'>".$upload_output."</div>";
	}
	return $upload_output;
}

function _return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last)
    {
        case 'g':
        $val *= 1024;
        case 'm':
        $val *= 1024;
        case 'k':
        $val *= 1024;
    }
    return $val;
}

function _return_max_upload_size() {
	$max_upload_size = _return_bytes(ini_get('upload_max_filesize'));
  $max_post_size = _return_bytes(ini_get('post_max_size'));
  if ($max_post_size <= $max_upload_size) {
  	$max_bytes = $max_post_size;
  	$max_text = ini_get('post_max_size');
  } else {
  	$max_bytes = $max_upload_size;
  	$max_text = ini_get('upload_max_filesize');
  }

  return [ $max_bytes, $max_text ];
}
