(function (w, $) {
	"use strict";

	w.Uploader = {
		state: {
			progress: 0,
			uploadStarted: false,
			dropAttempt: false,
			uploadType: 0, // 0 - r/m account, 1 - upload, 2 - use existing upload
			isModal: false,
			isOpen: false,
			canClose: false,
			alertOnClose: false,
			redirect: '',
			maxSize: 2 * 1024 * 1024,
			hasFileApi: false,
			file: {},
			reader: {},
			nonce: null,
			projectId: '',
			selectedFromUploads: null,
			isPaused: false,
			isError: false
		},

		texts: {
			fileName: 'choose or drop zip',
			finishedUploading: 'unzipping source code...',
			errorLoading: 'Sorry, upload failed'
		},

		$elem: null,

		init: function() {
			this.$elem = $('#rm-upload-form-component');
			this.$form = this.$elem.find('.rm-upload-form');
			this.$ajaxUpload = this.$elem.find('.rm-upload-form__ajax-upload');

			var availableSize = parseInt(this.$form.attr('data-modal'));
			var isModal = this.$form.attr('data-modal') == 'true';

			var initState = {
				isModal: isModal,
				maxSize: (availableSize < this.state.maxSize) ? availableSize : this.state.maxSize,
				uploadType: 1,
				isOpen: !isModal,
				nonce: this.$form.attr('data-nonce'),
				projectId: this.$form.attr('data-pid'),
				canClose: isModal
			}

			this.setState(initState);

			this.$ajaxUpload.find('#simple-project-upload-eqve092').on('change', $.proxy(this.addedFile, this) );

			this.$ajaxUpload.on('drag dragstart dragend dragover dragenter dragleave drop', function(ev)  {
				ev.preventDefault();
				ev.stopPropagation();
			});

			this.$ajaxUpload.on('dragover dragenter', $.proxy(this.startDropAttempt, this));
			this.$ajaxUpload.on('dragleave dragend drop', $.proxy(this.endDropAttempt, this));
			this.$ajaxUpload.on('drop', $.proxy(this.uploadOnDrop, this));

			this.$elem.find('.rm-upload-form__close').on('click', $.proxy(this.closeModal, this));

			this.$elem.find('.method-switcher').on('click', $.proxy(this.switchUploadType, this));

			this.$elem.find('.folder-select').on('change', $.proxy(this.onUploadedSelect, this));
			this.$elem.find('.activate-button').on('click', $.proxy(this.activateUploaded, this));
		},

		addedFile: function(ev) {
			this.start_upload(ev.target.files[0]);
		},

		pauseUpload: function() {
			if(this.state.uploadStarted == false) return;

			this.setState({isPaused: true});
		},

		resumeUpload: function() {
			if(this.state.uploadStarted == true && this.state.isPaused == true) {
				this.upload_file( this._next_slice );
				this.setState({isPaused: false});
			}
		},

		startDropAttempt: function(ev) {
			if(this.state.uploadStarted == true) return;

			this.$ajaxUpload.addClass('drop-attempt');
		},

		endDropAttempt: function(ev) {
			this.$ajaxUpload.removeClass('drop-attempt');
		},

		uploadOnDrop: function(ev) {
			if(this.state.uploadStarted == true) return;

			this.start_upload( ev.originalEvent.dataTransfer.files[0] );
		},

		switchUploadType: function(ev) {
			ev.preventDefault();

			var elem = $(ev.currentTarget);

			if( elem.hasClass('disabled') ) return;

			this.setState({ uploadType: parseInt(elem.attr('data-value')) })
		},

		hideUploadTypeSwitcher: function() {
			this.$elem.find('.rm-upload-form-method').addClass('hide');
		},

		openModal: function(ev) {
			ev.preventDefault();
			this.setState({
				isOpen: true,
				dropAttempt: false,
				progress: 0,
				uploadType: 1,
				uploadStarted: false
			});
		},

		closeModal: function(ev) {
			ev.preventDefault();
			if(this.state.uploadStarted == true && this.state.progress != 100 && !this.state.isError) {
				this.pauseUpload();

				if( confirm('Stop the upload?') ) {
					this.setState({
						uploadStarted: false
					});
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						cache: false,
						data: {
							action: 'rm_cancel_upload',
							nonce: this.state.nonce
						}
					});
				} else {
					this.resumeUpload();
				}
			}

			if( !this.state.uploadStarted || this.state.isError ) {
				this.setState({
					isOpen: false,
					dropAttempt: false,
					progress: 0,
					uploadType: 1,
					uploadStarted: false,
					isPaused: false
				});
			}
		},

		onUploadedSelect: function(ev) {
			this.setState({selectedFromUploads: $(ev.currentTarget).val() });
		},

		activateUploaded: function(ev) {
			ev.preventDefault();

			if(!this.state.selectedFromUploads) return;

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: 'rm_activate_previous_upload',
					file: this.state.selectedFromUploads,
					p_id: this.state.projectId,
					nonce: this.state.nonce
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

		setState: function(newState) {
			var updateStates = [];
			for(var param in newState) {
				if(newState.hasOwnProperty(param) && newState[param] != this.state[param]) {
					this.state[param] = newState[param];
					updateStates.push(param);
				}
			}
			for(var i = 0; i < updateStates.length; i++) {
				this._updateState(updateStates[i]);
			}
		},

		_updateState: function(stateName) {
			if( stateName == 'uploadType' ) {
				this.$elem.find('.method-switcher.current').removeClass('current');
				this.$elem.find('.method-switcher[data-value='+this.state.uploadType+']').addClass('current');

				this.$form.attr('data-type', this.state.uploadType);
			}

			if( stateName == 'uploadStarted' ) {
				if(this.state.uploadStarted == true) {
					this.setState({canClose: true});
					w.onbeforeunload = function() {
						return "Stop the upload?";
					}
				} else {
					this.setState({canClose: this.state.isModal});
					w.onbeforeunload = null;
				}

				if(this.state.uploadStarted == true && this.state.progress != 100) {
					this.$elem.find('.upload-input-wrapper').attr('data-upload-stage', 1);

				} else if (this.state.uploadStarted == true && this.state.progress == 100) {
					this.$elem.find('.upload-input-wrapper').attr('data-upload-stage', 2);

				} else if (this.state.uploadStarted == false) {
					this.$elem.find('.upload-input-wrapper').attr('data-upload-stage', 0);
				}

				// hide upload type switcher
				this.hideUploadTypeSwitcher();
			}

			if( stateName == 'isError' ) {
				if( this.state.isError ) {
					this.$elem.find('.upload-input-wrapper').attr('data-upload-stage', -1);
				}
			}

			if( stateName == 'progress' ) {
				if(this.state.progress > 0 && this.state.uploadStarted != true)
					this.state.progress = 0;

				if(this.state.progress > 100)
					this.state.progress = 100;

				var caption = this.state.progress + '&thinsp;%';
				this.$elem.find('.progress-value').html(caption);
				this.$elem.find('#uploader-progress-svg-bar__percentage-arc').attr('d', this.getArc(this.state.progress, 100, 33, 34));

				if (this.state.uploadStarted == true && this.state.progress == 100) {
					this.$elem.find('.upload-input-wrapper').attr('data-upload-stage', 2);
				}
			}

			if( stateName == 'file' ) {
				if( this.state.file && this.state.file.name )
					this.$elem.find('.uploader-filename .current').text(this.state.file.name);
			}

			if( stateName == 'canClose' ) {
				var stateFunc = this.state.canClose ? 'show' : 'hide';
				this.$elem.find('.rm-upload-form__close')[stateFunc]();
			}

			if( stateName == 'isModal' ) {
				if(this.state.isModal) {
					this.$elem.addClass('rm-upload-form__modal');
					this.state.isOpen = false;
				}
			}

			if( stateName == 'isOpen' ) {
				if( this.state.isOpen == true && this.state.isModal == true )
					this.$elem.fadeIn(200).addClass('rm-upload-form__open');

				if( this.state.isOpen == false && this.state.isModal == true )
					this.$elem.fadeOut(200).removeClass('rm-upload-form__open');
			}

			if( stateName == 'selectedFromUploads' ) {
				if(this.state.selectedFromUploads != '' && this.state.selectedFromUploads != null) {
					this.$elem.find('.activate-button').removeClass('disabled');
				} else {
					this.$elem.find('.activate-button').addClass('disabled');
				}
			}

			if( stateName == 'isPaused') {
				this.$form.find('#uploader-progress-svg-bar').toggleClass('paused', this.state.isPaused);
			}
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
		},

		start_upload: function( file ) {

			this.state.reader = new FileReader();
			this.setState({
				file: file,
				uploadStarted: true,
				isPaused: false
			})

			this._next_slice = 0;
			this.upload_file( 0 );
		},

		upload_file: function( start ) {

			if ( this.state.isPaused ) return;

			this._next_slice = start + this.state.maxSize + 1;
			var blob = this.state.file.slice( start, this._next_slice );
			var stage = 1;

			if (start == 0) {
				stage = 0;
			} else if (this._next_slice > this.state.file.size) {
				stage = -1;
			}

			this.state.reader.onloadend = $.proxy( function( event ) {
				if ( event.target.readyState !== FileReader.DONE ) {
					return;
				}
				$.ajax( {
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						action: 'rm_upload_file',
						file_data: event.target.result,
						file: this.state.file.name,
						file_type: this.state.file.type,
						stage: stage,
						nonce: this.state.nonce
					},
					error: $.proxy(function( jqXHR, textStatus, errorThrown ) {
						this.setState({isError: true});
						console.log( jqXHR, textStatus, errorThrown );
					},this),
					success: $.proxy(function( data ) {
						var size_done = start + this.state.maxSize;
						var percent_done = Math.floor( ( size_done / this.state.file.size ) * 100 );

						if ( this._next_slice < this.state.file.size ) {
							// Update upload progress
							this.setState({progress: percent_done});

							// More to upload, call function recursively
							this.upload_file( this._next_slice );
						} else {

							this.start_processing_uploaded_file();
						}
					}, this)
				} );
			}, this);

			this.state.reader.readAsDataURL( blob );
		},

		start_processing_uploaded_file: function() {
			this.setState({progress: 100, isPaused: false});
			console.log(this.state.projectId);
			$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						action: 'rm_activate_uploaded_file',
						nonce: this.state.nonce,
						p_id: this.state.projectId
					},
					error: $.proxy(function (jqXHR, textStatus, errorThrown) {
						this.setState({isError: true});
						console.log(jqXHR, textStatus, errorThrown);
					}, this),
					success: $.proxy(function (result) {
						var redirect = result.data.redirect;
						w.onbeforeunload = null;
						if (redirect) {
							window.location.href = redirect;
						} else {
							window.location.reload();
						}
					}, this)
				}
			);
		}
	}

	$(document).ready(function() {

		/*
		==================================
		INITIALIZING INTERFACE
		==================================
		 */

		w.Uploader && w.Uploader.init();

		var updateButton = $('#rm-uploader-update-button');
		if(updateButton.length == 1 && w.Uploader) {
			updateButton.on('click', $.proxy(w.Uploader.openModal, w.Uploader));
		}

	});

})(window, jQuery);