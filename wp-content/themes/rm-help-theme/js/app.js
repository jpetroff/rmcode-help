(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/utils.js

w.utils = {
	// @TODO: add Promise polyfill
	init: function() {
		var i,
			undefined,
			el = document.createElement('div'),
			transitions = {
				'transition':'transitionend',
				'OTransition':'otransitionend',  // oTransitionEnd in very old Opera
				'MozTransition':'transitionend',
				'WebkitTransition':'webkitTransitionEnd'
			};

		for (i in transitions) {
			if (transitions.hasOwnProperty(i) && el.style[i] !== undefined) {
				this.transitionName = transitions[i];
				break;
			}
		}
	},
	ajax: function(opts) {
		var data = opts.data || null;
		var method = typeof opts.method !== 'undefined' ? opts.method : 'GET';
		var url = opts.url;

		if (!url) return new Promise(function(resolve,reject){reject(Error('No URL provided'))});

		var query = [];
		if (data != null && typeof data == 'object') {
			for (var key in data) {
				if (!data.hasOwnProperty(key)) continue;
				query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
			}
			data = query.join('&');

			if ('' == data) data = null;
		}

		// console.log(data);

		return new Promise(function(resolve, reject) {
			// Do the usual XHR stuff
			var req = new XMLHttpRequest();

			if (method == 'POST') {
				req.open(method, url);
			} else {
				var dataQuery = data ? '?'+data : '';
				req.open(method, url+dataQuery);
			}
			// console.log(url+'?'+data);

			if (method == 'POST') req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

			req.onload = function() {
				// This is called even on 404 etc
				// so check the status
				if (req.status == 200) {
					// Resolve the promise with the response text
					resolve(req.response);
				}
				else {
					// Otherwise reject with the status text
					// which will hopefully be a meaningful error
					reject(Error(req.statusText));
				}
			};

			// Handle network errors
			req.onerror = function() {
				reject(Error("Network Error"));
			};

			// Make the request
			if (method == 'POST' && data) {
				req.send(data);
			} else {
				req. send();
			}

		});
	},
	untrailingslashit: function(str) {
		if(str.substr(-1) === '/') {
			return str.substr(0, str.length - 1);
		}
		return str;
	},
	updateDOM: function( fn, ctx ) {
		var methodFn = _.defer;
		if(typeof w.requestAnimationFrame == 'function') {
			methodFn = w.requestAnimationFrame;
		}

		if(!ctx) {
			return methodFn( fn );
		} else {
			return methodFn( _.bind(fn, ctx) );
		}
	},
	scrollTop: function(_val, _animate, cb) {
		var animate = (typeof _animate != 'undefined') ? _animate : true;
		var val = parseInt(_val);

		if(animate == false) {
			w.utils.updateDOM( function() {
				w.scrollTo(0, val);
			});
		} else {
			//with animation
			var from = w.pageYOffset;
			var by = _val - from;

			var currentIteration = 0;

			/**
			 * get total iterations
			 * 60 -> requestAnimationFrame 60/second
			 * second parameter -> time in seconds for the animation
			 **/
			var animIterations = Math.round(60 * 0.5);

			(function scroll() {
				var value = w.utils.easeOutCubic(currentIteration, from, by, animIterations);
				w.scrollTo(0, value);
				currentIteration++;
				if (currentIteration < animIterations) {
					requestAnimationFrame(scroll);
				} else if(typeof cb == 'function') {
					cb();
				}
			})();
		}
	},
	easeOutCubic: function(currentIteration, startValue, changeInValue, totalIterations) {
		return changeInValue * (Math.pow(currentIteration / totalIterations - 1, 3) + 1) + startValue;
	}
}

w.utils.init();
// End of /Users/john/rmsource/rmcode-help/_build/js/utils.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/main.js

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
		mounted: function() {
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
				w.utils.scrollTop(position, true, _.bind(function() {this.scrollAnimationStarted = false}, this));
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
			}
		}
	}
}
// End of /Users/john/rmsource/rmcode-help/_build/js/main.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/search.js

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



// End of /Users/john/rmsource/rmcode-help/_build/js/search.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/router.js

w.Router = {
	pageContainer: '#app-page',
	url: null,
	isFront: false,
	asyncLoadStarted: false,
	pageTransitionStarted: false,
	pageData: null,
	init: function() {
		w.addEventListener('popstate', _.bind(function(ev){
			this.changePage(w.location, true);
		}, this), false);

		this.parse_url(w.location, true);
		w.rmSearch.presentation.isFront = this.isFront;
		w.rmSearch.$mount('#search-component-vue');
		this.initPage();
	},
	initPage: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
		w.currentPage.$el.dataset.visible = true;

		if(w.currentPage.navElements.length > 0) {
			w.addEventListener('scroll', this.passScrollParams);
		}

		_.delay( function() {w.currentPage.localLink(w.Router.url.hash)}, 1);
	},
	changePage: function(url, skipUpdate) {
		var needChange = this.parse_url(url, skipUpdate);

		w.rmSearch.presentation.isFront = this.isFront;

		if(this.url.isLocal) {
			w.currentPage.localLink(this.url.hash);
		} else if(needChange) {
			this.asyncLoadStarted = true;

			w.utils.updateDOM(this.hidePage, this);

			w.utils.ajax({
				method: 'GET',
				url: w._home_url + 'api/page/' + (this.isFront ? '_front' : this.url.relPath)
			}).then(_.bind(function(data) {
				this.asyncLoadStarted = false;
				this.pageData = data;
				this.showNewPage();
			}, this));
		}
	},
	parse_url: function(_url, skipUpdate) {
		var url = null;

		if (_url && typeof _url.href == 'string') {
			url = _url;
		} else {
			url = document.createElement('a');
			url.href = _url;
		}

		if(this.url && this.url.location && this.url.location == url.href) {
			console.log('skip parsing – same URL');
			return false;
		}

		var isLocal = this.url && this.url.path && this.url.path == url.pathname;

		this.url = {
			location: url.href,
			home: w._home_url.href,
			path: url.pathname,
			relPath: w.utils.untrailingslashit( url.pathname.replace( w._home_url.pathname, '') ),
			query: url.search.replace('?', ''),
			hash: url.hash.replace('#', ''),
			isLocal: isLocal
		}

		if(!skipUpdate) w.history.pushState(null, null, this.url.path + (this.url.hash != '' ? '#' + this.url.hash : '') );

		if (this.url.relPath == '') {
			this.isFront = true;
			document.title = w._site_title;
		} else {
			this.isFront = false;
		}

		return true;
	},
	showNewPage: function(data) {
		if(this.pageTransitionStarted || this.asyncLoadStarted) return;

		w.utils.updateDOM(function() {
			w.currentPage.$el.innerHTML = this.pageData;
			w.currentPage.$destroy();
			this.initPage();
		}, this);
	},
	hidePage: function() {
		w.removeEventListener('scroll', this.passScrollParams);
		w.currentPage.$el.dataset.visible = false;
		w.utils.scrollTop(0, false);
		this.pageTransitionStarted = true;
		w.currentPage.$el.addEventListener(w.utils.transitionName,
			_.bind(function() {
				this.pageTransitionStarted = false;
				this.showNewPage();
			}, this)
		)
	},
	updateUrl: function( path, _hash, title ) {
		path = path || this.url.path;
		var hash = _hash != '' ? '#'+_hash : '';
		title = title != '' ? title+' — '+w._site_title : w._site_title;

		w.history.replaceState( null, title, path+hash );
		this.url.location = w.location.href;
		this.url.path = w.location.pathname;
		this.url.relPath = w.utils.untrailingslashit( w.location.pathname.replace( w._home_url.pathname, '') );
		this.url.query = w.location.search.replace('?', '');
		this.url.hash = w.location.hash.replace('#', '');
	},
	passScrollParams: function() {
		w.currentPage && w.currentPage.scrollSpy();
	}
}

Router.init();
// End of /Users/john/rmsource/rmcode-help/_build/js/router.js
})(window);