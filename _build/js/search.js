w.rmSearch = new Vue({
	data: {
		query: '',
		value: '',
		waitingForResults: false,
		inputFocus: false,
		results: [],
		presentation: {
			width: 760,
			left: 0,
			height: 300,
			isFront: true
		},
		showResultsPanel: false
	},
	beforeMount: function() {
		this.getPresentationParams();
		w.addEventListener('resize', _.bind(this.getPresentationParams, this));
	},
	directives: {
		ref: {
			bind: function(el, binding, vnode) {
				console.log(vnode);
				if (!vnode.context.$vrefs) vnode.context.$vrefs = {};
				if (!vnode.context.$vrefs[binding.expression]) vnode.context.$vrefs[binding.expression] = [];
				vnode.context.$vrefs[binding.expression].push(el);
			}
		}
	},
	computed: {
		searchResultsState: function() {

			if (this.query.length > 0 && this.waitingForResults) {
				if (this.inputFocus) {
					this.showResultsPanel = true;
				} else {
					this.showResultsPanel = false;
				}
				return 'waiting';
			}

			if (this.query.length > 0 && !this.waitingForResults && this.results.length == 0) {

				if (this.query == this.value && this.inputFocus) {
					this.showResultsPanel = true;
				} else {
					this.showResultsPanel = false;
				}
				return 'empty';
			}

			if (
				this.query.length > 0 &&
				!this.waitingForResults &&
				this.results.length > 0
			) {
				if (this.inputFocus) {
					this.showResultsPanel = true;
				} else {
					this.showResultsPanel = false;
				}
				if (this.query == this.value) {
					return 'success';
				} else {
					return 'inactive';
				}
			}

			if (this.query.length == 0) {
				this.showResultsPanel = false;
				return 'empty';
			}
		}
	},
	methods: {
		queryInput: function(val) {
			this.value = val;
			if(val == '') this.query = '';
		},
		_requestResults: function() {
			w.utils.ajax({
				url: w._home_url.href + 'search/',
				method: 'GET',
				data: {
					s: this.query
				}
			}).then(_.bind(
				function(data) {
					var results = JSON.parse(data);
					var result_posts = results['posts'];
					var link_index = results['link_index'];
					for(var i = 0; i < result_posts.length; i++) {
						result_posts[i].post_excerpt = result_posts[i].post_excerpt.replace('...', '');
						var ind = result_posts[i].ID;
						if(
							typeof link_index[ind] !== 'undefined' &&
							typeof link_index[ind].permalink !== 'undefined'
						) {
							result_posts[i].display_link = link_index[ind]['permalink'];
							result_posts[i].parent_title = '';
						} else {
							ind = link_index[result_posts[i].ID];
							result_posts[i].parent_link = link_index[ind]['permalink'];
							result_posts[i].display_link = link_index[ind]['permalink'] + '#' + result_posts[i].post_name;
							result_posts[i].parent_title = link_index[ind]['title'];
						}

					}
					this.results = result_posts;
					this.waitingForResults = false;
				},
				this
				)
			)
		},
		submitSearch: function( returnFocus ) {
			if(returnFocus == true) this.$refs.queryInput.focus();
			this.query = this.value;
			this.waitingForResults = true;
			this._requestResults();
		},
		_calcMaxHeight: function() {
			return this.presentation.height - this.$el.offsetTop - 61 - 50;
		},
		getPresentationParams: function() {
			var pageContent = document.getElementsByClassName('page-content')[0];

			var pageContentClientWidth = pageContent.clientWidth;
			var pageContentLeftOffset = pageContent.offsetLeft;
			var windowClientHeight = window.innerHeight;

			this.presentation.width = this.presentation.isFront ? pageContentClientWidth : (pageContentClientWidth + 60);

			this.presentation.left = this.presentation.isFront ? pageContentLeftOffset : (pageContentLeftOffset - 30);

			this.presentation.height = windowClientHeight;

		},
		showResultPage: function( el ) {
			this.inputFocus = false;
			w.Router.changePage(el);
		},
		clearQuery: function() {
			this.query = '';
			this.value = '';
			this.$refs.queryInput.focus();
		}
	}
});



// window.rmSearch.$mount('#search-component-vue');


