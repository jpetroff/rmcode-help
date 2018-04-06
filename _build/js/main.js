w.Page = function() {
	return {
		data: {
			navItems: {},
			navElements: [],
			scrollOffset: [118, 71],
			scrollSections: [],
			scrollAnimationStarted: false,
			activeSection: '',
			pageHeight: 0
		},
		components: {
			'hint': w.components['hint'],
			'project-views': w.components['project-views']
		},
		mounted: function() {
			this.pageHeight = document.body.clientHeight;
			this.$nextTick(this.recalcAnchorNav);
			this.$on('recalcAnchorNav', this.recalcAnchorNav);
		},
		directives: {
			rlink: {
				bind: function( el, binding, vnode ) {
					var linkHost = el.host || el.hostname;
					var siteHost = w._home_url.host || w._home_url.hostname;
					if (linkHost == siteHost) {

						el.addEventListener('click', _.bind(function (ev) {

							if(!ev.altKey && !ev.ctrlKey && !ev.metaKey && !ev.shiftKey) {
								ev.preventDefault();
								var pos = w.pageYOffset;

								w.history && w.history.replaceState({backPos: pos}, null, w.location.href);
								this.linkClick(ev.currentTarget);
							} else {
								return true;
							}
						}, vnode.context));

					} else {
						el.target = '_blank';
					}
				}
			},
			navblock: {
				bind: function( el, binding, vnode ) {
					vnode.context.navElements.push(el);
				}
			},
			video: {
				bind: function( el, binding, vnode ) {
					if (window.outerWidth < 700) {
						el.autoplay = false;
						el.controls = true;
						if (el.load) el.load();
					}
				}
			}
		},
		methods: {
			linkClick: function( el, state ) {
				if(!state) state = {};
				w.Router.changePage(el, false, state);
			},
			localLink: function(hash,state) {
				if(
					typeof hash == 'undefined' ||
					hash == null ||
					!this.navItems[hash]
				) return;

				if(this.pageHeight != document.body.clientHeight)
					this.recalcAnchorNav();

				var position = 0;
				var _scrollOffset = window.outerWidth > 700 ? this.scrollOffset[0] : this.scrollOffset[1];
				position = Math.max(this.navItems[hash].pos - _scrollOffset + 1, 0);
				this.scrollAnimationStarted = true;

				var navSection = this._getCurrentNavSection(position);
				this.activeSection = navSection[2];
				w.Router && w.Router.updateUrl(w.Router.url.path, w.Router.url.hash, this.navItems[hash].title);

				if (state && state.backPos) {
					position = state.backPos;
				}
				w.utils.scrollTop(position, true, _.bind(function() {
					w.utils.updateDOM(function() {this.scrollAnimationStarted = false}, this);
				}, this));
			},
			scrollSpy: function() {
				if(this.scrollAnimationStarted == true) return;

				var pos = w.pageYOffset;
				var navSection = this._getCurrentNavSection(pos);

				if(w.Router.url.hash != navSection[2]) {
					console.log('changed to ' + navSection[2]);
					this.activeSection = navSection[2];
					w.Router && w.Router.updateUrl(null, navSection[2], navSection[3]);
				}
			},
			_getCurrentNavSection: function(pos) {
				for(var i = 0; i < this.scrollSections.length; i++) {
					if( pos >= this.scrollSections[i][0] && (this.scrollSections[i][1] == 'end' || pos <= this.scrollSections[i][1]) ) {
						return this.scrollSections[i];
					}
				}
			},
			recalcAnchorNav: function() {
				for(var i = 0; i < this.navElements.length; i++) {
					this.navItems[this.navElements[i].id] = {
						pos: this.navElements[i].offsetTop,
						title: this.navElements[i].dataset.title
					}
					var level = parseInt(this.navElements[i].dataset.level);

					if(this.navElements[i].dataset.level <= 2) {
						var hash = level == 1 ? '' : this.navElements[i].id;
						var title = this.navElements[i].dataset.title;
						var _scrollOffset = window.outerWidth > 700 ? this.scrollOffset[0] : this.scrollOffset[1];
						this.scrollSections.push(
							[
								this.navElements[i].offsetTop - _scrollOffset,
								null,
								hash,
								title
							]);
					}
				}
				for(var k = 0; k < this.scrollSections.length; k++) {
					if(k == this.scrollSections.length - 1) {
						this.scrollSections[k][1] = 'end';
					} else {
						this.scrollSections[k][1] = this.scrollSections[k+1][0] - 1;
					}
				}
			}
		}
	}
}