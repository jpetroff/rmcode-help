w.Page = function() {
	return {
		data: {
			navItems: {},
			navElements: [],
			scrollOffset: 118
		},
		mounted: function() {
			for(var i = 0; i < this.navElements.length; i++) {
				this.navItems[this.navElements[i].id]= this.navElements[i].offsetTop;
			}
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
				var position = 0;
				if (hash != '') {
					position = Math.max(this.navItems[hash] - this.scrollOffset, 0);
				}
				console.log(position);
				w.utils.scrollTop(position);
			}
		}
	}
}