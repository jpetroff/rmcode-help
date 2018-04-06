;(function($) {
	"use strict";

	// readAsBinaryString polyfill
	if (FileReader.prototype.readAsBinaryString === undefined) {
		FileReader.prototype.readAsBinaryString = function (fileData) {
			var binary = "";
			var pt = this;
			var reader = new FileReader();
			reader.onload = function (e) {
				var bytes = new Uint8Array(reader.result);
				var length = bytes.byteLength;
				for (var i = 0; i < length; i++) {
					binary += String.fromCharCode(bytes[i]);
				}
				//pt.result  - readonly so assign content to another property
				pt.content = binary;
				pt.onload();
			}
			reader.readAsArrayBuffer(fileData);
		}
	}

	window.rmUploader = new Vue({
		data: {
			state: 1,
			projectId: null,
			redirect: null,
			isModal: false,
			isOpen: false,

			showMenu: false,
			morphAnimation: {
				frame: 0,
				direction: 1,
				timer: null
			},
			upload: {
				progress: 0,
				progressCaption: '0%',
				progressArcCoords: 'M 33 1 A 32 32 0 0 0 33 1',
				reader: null,
				file: null,
				uploadStarted: false,
				isPaused: false,
				_next_slice: 0,
				isError: false,
				maxSize: 2 * 1024 * 1024,
				isDrop: false
			},
			useUploaded: {
				selected: null
			},
			currentStateName: null
		},
		computed: {
			uploadStage: function() {
				if(this.upload.isError)
					return -1;

				if(this.upload.uploadStarted == true && this.upload.progress != 100)
					return 1;

				if (this.upload.uploadStarted == true && this.upload.progress == 100)
					return 2;

				if (this.upload.uploadStarted == false)
					return 0
			}
		},
		watch: {
			'upload.progress': function(val) {
				if(this.state.progress > 0 && this.state.uploadStarted != true)
					this.upload.progress = 0;

				if(this.state.progress > 100)
					this.upload.progress = 100;

				this.upload.progressCaption = this.upload.progress + '%';
				this.upload.progressArcCoords = this.getArc(this.upload.progress, 100, 33, 34);
			},
			'upload.uploadStarted': function(val) {
				console.log(val);
				if (val == true) {
					if(this.morphAnimation.timer) clearTimeout(this.morphAnimation.timer);
					// this.morphAnimation.frame = 0;
					this.morphAnimation.direction = 1;
					this.morphAnimation.timer = setTimeout(this.nextMorphFrame, 10);
				} else {
					if(this.morphAnimation.timer) clearTimeout(this.morphAnimation.timer);
					// this.morphAnimation.frame = 5;
					this.morphAnimation.direction = -1;
					this.morphAnimation.timer = setTimeout(this.nextMorphFrame, 10);
				}
			}
		},
		methods: {
			changeState: function(val, name) {
				if(!val) return;
				if(this.upload.uploadStarted) return;

				this.state = val;
				if(name) this.currentStateName = name;
				this.showMenu = false;
			},
			nextMorphFrame: function() {
				var timeout = 25;
				this.morphAnimation.frame = (this.morphAnimation.frame + this.morphAnimation.direction) % 6;
				if(
					(this.morphAnimation.frame == 5 && this.morphAnimation.direction == 1) ||
					(this.morphAnimation.frame == 0 && this.morphAnimation.direction == -1)
				)
					return;

				// if(this.morphAnimation.frame == 2) timeout = 15;
				this.morphAnimation.timer = setTimeout(this.nextMorphFrame, timeout);
			},


			addedFile: function( input ) {
				console.dir(input.files);
				this.upload.uploadStarted = true;
				this.start_upload( input.files[0] );
			},
			uploadOnDrop: function(_ev) {
				if(this.state.uploadStarted == true) return;
				console.log(_ev);

				var ev = (_ev.originalEvent || _ev);

				this.start_upload( ev.dataTransfer.files[0] );
			},
			start_upload: function( file ) {

				this.upload.reader = new FileReader();
				this.upload.file = file;
				this.upload.uploadStarted = true;
				this.upload.isPaused = false;
				this.upload.isDrop = false;

				this.upload._next_slice = 0;
				this.upload_file( 0 );
			},

			upload_file: function( start ) {

				if ( this.upload.isPaused ) return;

				this.upload._next_slice = start + this.upload.maxSize + 1;
				var blob = this.upload.file.slice( start, this.upload._next_slice );
				var stage = 1;

				if (start == 0) {
					stage = 0;
				} else if (this.upload._next_slice > this.upload.file.size) {
					stage = -1;
				}

				this.upload.reader.onloadend = $.proxy( function( event ) {
					if ( event.target.readyState !== FileReader.DONE ) {
						return;
					}
					console.log(event);
					$.ajax( {
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						cache: false,
						data: {
							action: 'rm_upload_file',
							file_data: event.target.result,
							file: this.upload.file.name,
							file_type: this.upload.file.type,
							stage: stage,
							nonce: this.nonce
						},
						error: $.proxy(function( jqXHR, textStatus, errorThrown ) {
							this.upload.isError = true;
							console.log( jqXHR, textStatus, errorThrown );
						},this),
						success: $.proxy(function( data ) {
							var size_done = start + this.upload.maxSize;
							var percent_done = Math.floor( ( size_done / this.upload.file.size ) * 100 );

							if ( this.upload._next_slice < this.upload.file.size ) {
								// Update upload progress
								this.upload.progress = percent_done;

								// More to upload, call function recursively
								this.upload_file( this.upload._next_slice );
							} else {

								this.start_processing_uploaded_file();
							}
						}, this)
					} );
				}, this);

				this.upload.reader.readAsDataURL( blob );
			},

			start_processing_uploaded_file: function() {
				this.upload.progress = 100;
				this.upload.isPaused = false;
				console.log(this.projectId);
				$.ajax({
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						cache: false,
						data: {
							action: 'rm_activate_uploaded_file',
							nonce: this.nonce,
							p_id: this.projectId
						},
						error: $.proxy(function (jqXHR, textStatus, errorThrown) {
							this.upload.isError = true;
							console.log(jqXHR, textStatus, errorThrown);
						}, this),
						success: $.proxy(function (result) {
							console.log(result);
							var redirect = result.data.redirect;
							window.onbeforeunload = null;
							if (redirect) {
								window.location.href = redirect;
							} else {
								window.location.reload();
							}
						}, this)
					}
				);
			},

			startDropAttempt: function(ev) {
				ev.preventDefault();
				if (this.upload.uploadStarted) return;

				this.upload.isDrop = true;
			},
			endDropAttempt: function(ev) {
				ev.preventDefault();
				if (this.upload.uploadStarted) return;

				this.upload.isDrop = false;
			},

			closeClick: function() {
				if(this.upload.uploadStarted & this.upload.progress < 100) {

					// pause upload
					if (!this.upload.isPaused) {

						this.upload.isPaused = true;

					// resume upload
					} else {
						this.upload.isPaused = false;
						this.upload_file( this.upload._next_slice );
					}

					return;
				}

				// close modal window
				if(this.isModal) {
					this.isOpen = false;
				}
			},

			onSelectUploaded: function(val) {
				console.log(val);
				this.useUploaded.selected = (val == 'none' ? null : val);
			},

			onUseUploadedClick: function() {
				if(!this.useUploaded.selected) return;

				$.ajax( {
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						action: 'rm_activate_previous_upload',
						file: this.useUploaded.selected,
						p_id: this.projectId,
						nonce: this.nonce
					},
					error: $.proxy(function( jqXHR, textStatus, errorThrown ) {
						console.log( jqXHR, textStatus, errorThrown );
					},this),
					success: $.proxy(function( result ) {
						var redirect = result.data.redirect;
						if (redirect) {
							window.location.href = redirect;
						} else {
							window.location.reload();
						}
					}, this)
				} );
			},

			getArc: function(current, total, pathRadius, elementRadius) {

				var value = Math.max(0, Math.min(current || 0, total));
				var maxAngle = 359.9999;
				var percentage = total === 0 ? maxAngle :  (value / total) * maxAngle;
				var start = this._polarToCartesian(elementRadius, pathRadius, percentage);
				var end = this._polarToCartesian(elementRadius, pathRadius, 0);
				var arcSweep = (percentage <= 180 ? 0 : 1);

				return 'M '+ start +' A ' + pathRadius + ' ' + pathRadius + ' 0 ' + arcSweep + ' 0 ' + end;
			},
			_polarToCartesian: function(elementRadius, pathRadius, angleInDegrees) {

				var angleInRadians = (angleInDegrees - 90) * (Math.PI / 180);
				var x = elementRadius + (pathRadius * Math.cos(angleInRadians));
				var y = elementRadius + (pathRadius * Math.sin(angleInRadians));

				return x + ' ' + y;
			}
		},
		mounted: function() {
			var uploaderWrapper = this.$refs.uploaderWrapper;

			$(uploaderWrapper).on('drag dragstart dragend dragover dragenter dragleave drop', function(ev)  {
				ev.preventDefault();
				ev.stopPropagation();
			});

			$(uploaderWrapper).on('dragover dragenter', $.proxy(this.startDropAttempt, this));
			$(uploaderWrapper).on('dragleave dragend drop', $.proxy(this.endDropAttempt, this));

			this.nonce = this.$refs.uploadForm.dataset.nonce;

			var availableSize = this.$refs.uploadForm.dataset.max;
			this.upload.maxSize = (availableSize < this.upload.maxSize) ? availableSize : this.upload.maxSize;

			this.projectId = this.$refs.uploadForm.dataset.pid;

			this.isModal = this.$refs.uploadForm.dataset.modal == 'true';
		},
	});

	window.rmSettings = new Vue({
		data: {
			value: ''
		},
		methods: {
			focus: function() {
				this.$refs.slugInput.focus();
			}
		},
		mounted: function() {
			this.value = this.$refs.slugInput.defaultValue;
		}
	})

	function permalinkChangeInit(_nonce) {
		var control = $('.rm-permalink-wrapper'),
			link = control.find('.permalink'),
			field = link.find('.input-item'),
			mainAction = control.find('.main-action'),
			secondaryAction = control.find('.secondary-action'),
			prevValue = field.text(),
			nonce = _nonce;

		mainAction.on('click', function() {
			if(control.attr('data-state') == '0') {
				control.attr('data-state', '1');
				prevValue = field.text();
				field.attr('contenteditable', 'plaintext-only');
				field.focus();
			} else if(!mainAction.hasClass('disabled')) {
				control.attr('data-state', '0');
				field.attr('contenteditable', 'false');
				mainAction.removeClass('disabled');

				var post_id = $('#post_ID').val(),
					new_slug = field.text(),
					new_title = $('#title').val();

				var params = {
					action: 'rm_save_permalink',
					post_id: parseInt(post_id),
					permalink: new_slug,
					title: new_title,
					nonce: nonce
				};

				console.log(params);

				$.ajax({
					method: 'POST',
					url: ajaxurl,
					data: params,
					complete: function(jqXHR, status) {
						var result = jqXHR.responseJSON;
						field.text(result.data);
						$('#post_name').val(result.data);
					}
				});
			}
		});

		secondaryAction.on('click', function() {
			control.attr('data-state', '0');
			field.attr('contenteditable', 'false');
			field.text(prevValue);
			mainAction.removeClass('disabled');
		});

		link.on('click', function(ev) {
			if(control.attr('data-state') == '1') {
				ev.preventDefault();
			}
		});

		field.on('input', function() {
			if(field.text() == '') {
				mainAction.addClass('disabled');
			} else {
				mainAction.removeClass('disabled');
			}
		});

	};



	$(document).ready(function() {
		// find vue upload component and mount it
		if($('#rm-upload-form-component').length == 1 && window.rmUploader) window.rmUploader.$mount('#rm-upload-form-component');

		// find vue plugin settings component and mount it
		if($('#rm-plugin-settings-app').length == 1 && window.rmSettings) window.rmSettings.$mount('#rm-plugin-settings-app');

		var updateButton = $('#rm-uploader-update-button');
		if(updateButton.length == 1 && window.rmUploader) {
			updateButton.on('click', function() {
				window.rmUploader.isOpen = true;
			});
		}

		var rmCustomTitleDiv = $('#rm-custom-post-title');
		if(rmCustomTitleDiv.length == 1) {
			var permalinkNonce = $('#samplepermalinknonce').val();
			$('#titlediv .inside').detach();
			var prevTitleDiv = $('#titlediv');
			prevTitleDiv.prependTo('#rm-custom-post-title .right-col');

			setTimeout(function() {
				rmCustomTitleDiv.addClass('ready');
			}, 0);

			permalinkChangeInit(permalinkNonce);
		}


	});
})(jQuery);