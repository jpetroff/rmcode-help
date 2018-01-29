w.rmSearch = new Vue({
	data: {
		query: '',
		value: '',
		waitingForResults: false,
		inputFocus: false,
		results: [],
		correction: '',
		presentation: {
			width: 760,
			left: 0,
			height: 300,
			isFront: true,
			paddingScroll: 40,
			scrollCoefficient: 1,
			scrollBarTop: 0,
			scrollBarHeight: 0,
			scrollContainerHeight: 0
		},
		showResultsPanel: false,
		onlyHints: false,
		postponeUntilTransitionEnd: false,
		fullResultsRequested: false,
		hasMore: false,
		modifiedResults: false,
		SHORT_LIMIT: 4
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
		isActive: function() {
			// if(this.value.length != 0 && this.query != this.value)
			// 	return true;

			if(this.value.length != 0 && this.hasMore)
				return true;

			return false;
		},
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

				// HACK: return previously cached value
				return this._computedWatchers.searchResultsState.value;
			}
		},
		encodedQuerySubject: function() {
			if(this.results.length == 0 && this.query.length != 0) {
				return encodeURI('Looking for: ' + this.query);
			}
			return '';
		},
		showSuggestion: function() {
			if(
				this.results.length == 0 ||
				this.correction == ''
			) {
				return false;
			} else {
				return true;
			}
		}
	},
	methods: {
		queryInput: function(val) {
			this.value = val;
			if(val == '') this.query = '';
			this.submitSearch( false, true );
		},
		requestResults: function( _applyLimit ) {
			var applyLimit = _applyLimit ? true : false;
			w.utils.ajax({
				url: w._home_url.href + 'search/',
				method: 'GET',
				data: {
					s: this.query,
					limit: _applyLimit,
					limitNum: this.SHORT_LIMIT
				}
			}).then(_.bind(
				function(data) {
					var results = JSON.parse(data);
					var result_posts = results['posts'];
					var link_index = results['link_index'];

					this.onlyHints = true;
					this.correction = results.suggested ? results.suggested : '';
					this.hasMore = results.has_more;
					this.modifiedResults = results.modified_results;

					for(var i = 0; i < result_posts.length; i++) {
						if(result_posts[i].post_type != 'hint') {
							this.onlyHints = false;
						}

						if (result_posts[i].post_type == 'hint') continue;

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
							if(typeof ind !== 'undefined') {
								result_posts[i].parent_link = link_index[ind]['permalink'];
								result_posts[i].display_link = link_index[ind]['permalink'] + '#' + result_posts[i].post_name;
								result_posts[i].parent_title = link_index[ind]['title'];
							} else {

							}
						}
						result_posts[i].display_title = (result_posts[i].highlighted_title || result_posts[i].post_title) + (result_posts[i].parent_title != '' ? ' &mdash; ' + result_posts[i].parent_title : '');
					}
					this.results = result_posts;
					this.$nextTick(this._calcScroll);
					this.waitingForResults = false;
				},
				this
				)
			)
		},
		_requestResults: _.debounce(function() {
			if(!this.fullResultsRequested) this.requestResults(true);
		}, 500),
		submitSearch: function( returnFocus, useDebounce ) {
			if(!useDebounce && this.isActive == false) {
				return;
			}

			if(returnFocus == true) this.$refs.queryInput.focus();
			this.query = this.value;
			this.waitingForResults = true;
			this.presentation.scrollContainerHeight = 0;
			this.presentation.scrollCoefficient = 1;
			this.onlyHints = false;
			this.correction = '';
			this.hasMore = false;
			if(useDebounce) {
				this.fullResultsRequested = false;
				this._requestResults();
			} else {
				this.fullResultsRequested = true;
				this.requestResults();
			}
		},
		expandResults: function() {
			this.hasMore = false;
			this.$nextTick(this._calcScroll);
		},
		_calcMaxHeight: function() {
			return this.presentation.height - this.$el.offsetTop - 59 - 50;
		},
		_calcScroll: function() {

			var dataHeight = w.utils.outerHeight(this.$refs.dataContainer);
			var maxHeight = this._calcMaxHeight();

			if(dataHeight > maxHeight) {
				this.$refs.scrollContainer.addEventListener('scroll', _.bind(this._performScroll, this));
				this.presentation.scrollCoefficient = (maxHeight - 2 * this.presentation.paddingScroll) / dataHeight;
				this._performScroll()
			} else {
				this.presentation.scrollCoefficient = 1;
				this.$refs.scrollContainer.removeEventListener('scroll', _.bind(this._performScroll, this));
				this.presentation.scrollContainerHeight = 0;
			}
		},
		_performScroll: function() {
			this.presentation.scrollContainerHeight = this._calcMaxHeight();
			this.presentation.scrollBarTop = this.presentation.paddingScroll + this.$refs.scrollContainer.scrollTop * this.presentation.scrollCoefficient;
			this.presentation.scrollBarHeight = this._calcMaxHeight() * this.presentation.scrollCoefficient;
		},
		getPresentationParams: function() {
			var pageContent = document.getElementsByClassName('page-content')[0];

			var pageContentClientWidth = pageContent.clientWidth;
			var pageContentLeftOffset = pageContent.offsetLeft;
			var windowClientHeight = window.innerHeight;

			this.presentation.width = pageContentClientWidth + 60;

			this.presentation.left = pageContentLeftOffset - 30;

			this.presentation.height = windowClientHeight;

			if (this.searchResultsState == 'success') this._calcScroll();

		},
		showResultPage: function( el ) {
			this.inputFocus = false;
			w.Router.changePage(el);
		},
		clearQuery: function() {
			// this._cached_state = this.searchResultsState;
			// this.postponeUntilTransitionEnd = true;

			this.value = '';
			this.query = '';
			// this.correction = '';
			this.$refs.queryInput.focus();
		},
		contactSupport: function(ev) {
			if(!w.groove) {
				return true;
			} else {
				ev.preventDefault();
			}
			var grooveIframeDocument = null;
			w.groove.widget('open');

			var setSubjectCrudeMethod = _.bind(function() {
				var success = false;
				if(grooveIframeDocument == null) {
					var iframes = document.getElementsByTagName('iframe');
					for (var i = 0; i < iframes.length; i++) {
						try {
							if (iframes[i].contentDocument && iframes[i].contentDocument.getElementsByTagName('app').length != 0) {
								grooveIframeDocument = iframes[i].contentDocument;
								success = true;
								break;
							}
						} catch(e) {}
					}
				} else {
					success = true;
				}

				if(success) {
					var subjectInput = grooveIframeDocument.getElementById('subject');
					if(subjectInput) {
						subjectInput.value = 'Looking for: ' + this.query;
						subjectInput.readOnly = true;
						subjectInput.disabled = true;
					} else {
						success = false;
					}
				}
				console.log(success);
				if(!success) {
					w.utils.updateDOM(setSubjectCrudeMethod);
				}
			}, this);

			w.utils.updateDOM(setSubjectCrudeMethod);
		},
		submitAsYouType: function() {
			this.submitSearch();
		},
		applySuggestion: function() {
			// this.query = this.correction;
			this.value = this.correction;
			this.correction = '';
			this.submitSearch( true );
		}
	}
});



// window.rmSearch.$mount('#search-component-vue');


