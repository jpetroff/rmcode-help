w.Page = function() {
	return {
		data: {
			navItems: {},
			navElements: [],
			scrollOffset: 118,
			scrollSections: [],
			scrollAnimationStarted: false,
			activeSection: ''
		},
		components: {
			'hint': w.components['hint']
		},
		mounted: function() {
			this.recalcAnchorNav();
			this.$on('recalcAnchorNav', this.recalcAnchorNav);
		},
		directives: {
			rlink: {
				bind: function( el, binding, vnode ) {
					el.addEventListener('click', _.bind(function(ev) {
						ev.preventDefault();
						this.linkClick( ev.currentTarget );
					}, vnode.context) );
				}
			},
			navblock: {
				bind: function( el, binding, vnode ) {
					vnode.context.navElements.push(el);
				}
			}
		},
		methods: {
			linkClick: function( el ) {
				w.Router.changePage(el);
			},
			localLink: function(hash) {
				if(
					typeof hash == 'undefined' ||
					hash == null ||
					!this.navItems[hash]
				) return;

				var position = 0;
				position = Math.max(this.navItems[hash].pos - this.scrollOffset + 1, 0);
				this.scrollAnimationStarted = true;

				var navSection = this._getCurrentNavSection(position);
				this.activeSection = navSection[2];
				w.Router && w.Router.updateUrl(w.Router.url.path, w.Router.url.hash, this.navItems[hash].title+' — '+w._site_title);
				w.utils.scrollTop(position, true, _.bind(function() {
					w.utils.updateDOM(function() {this.scrollAnimationStarted = false}, this);
				}, this));
			},
			scrollSpy: function() {
				if(this.scrollAnimationStarted == true) return;
				var pos = w.pageYOffset;
				var navSection = this._getCurrentNavSection(pos);
				// console.log(w.Router.url.hash, navSection[2]);
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
						this.scrollSections.push(
							[
								this.navElements[i].offsetTop - this.scrollOffset,
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