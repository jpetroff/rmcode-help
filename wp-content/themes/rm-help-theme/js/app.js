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
				req.open(method, url+'?'+data);
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
	scrollTop: function(_val, _animate) {
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
				url: 'http://rm.local/wp-admin/admin-ajax.php',
				method: 'POST',
				data: {
					action: 'search',
					query: this.query
				}
			}).then(_.bind(
				function(data) {
					var results = JSON.parse(data);
					for(var i = 0; i < results.length; i++) {
						results[i].post_excerpt = results[i].post_excerpt.replace('...', '');
					}
					this.results = results;
					this.waitingForResults = false;
					console.log(this.results);
				},
				this
				)
			)
		},
		submitSearch: function() {
			this.query = this.value;
			this.waitingForResults = true;
			this._requestResults();
		},
		_calcMaxHeight: function() {
			return this.presentation.height - this.$el.offsetTop - 61 - 50;
		},
		_specialBlur: function() {
			_.delay( _.bind(function(){ this.inputFocus = false; }, this), 200);
		},
		getPresentationParams: function() {
			var pageContent = document.getElementsByClassName('page-content')[0];

			var pageContentClientWidth = pageContent.clientWidth;
			var pageContentLeftOffset = pageContent.offsetLeft;
			var windowClientHeight = window.innerHeight;

			this.presentation.width = pageContentClientWidth;
			this.presentation.left = pageContentLeftOffset;
			this.presentation.height = windowClientHeight;
		},
		showResultPage: function( el ) {
			// console.log(el);
			// return;
			// if(!w.Router) return;

			w.Router.changePage(el);
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
		this.parse_url(w.location, true);
		w.rmSearch.presentation.isFront = this.isFront;
		w.rmSearch.$mount('#search-component-vue');
		this.initPage();
	},
	initPage: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
		w.currentPage.$el.dataset.visible = true;

		_.delay( function() {w.currentPage.localLink(w.Router.url.hash)}, 1);
		// document.addEventListener("DOMContentLoaded", function(event) {
		//
		// });
	},
	changePage: function(url) {
		this.parse_url(url);
		w.rmSearch.presentation.isFront = this.isFront;

		if(this.url.isLocal) {
			w.currentPage.localLink(this.url.hash);
		} else {
			this.asyncLoadStarted = true;

			w.utils.updateDOM(this.hidePage, this);

			w.utils.ajax({
				method: 'GET',
				url: 'http://rm.local/api/page/' + (this.isFront ? '_front' : this.url.relPath)
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

		this.url = {
			location: url.href,
			home: w._home_url.href,
			path: url.pathname,
			relPath: w.utils.untrailingslashit( url.pathname.replace( w._home_url.pathname, '') ),
			query: url.search.replace('?', ''),
			hash: url.hash.replace('#', ''),
			isLocal: (w.location.pathname == url.pathname)
		}

		if(!skipUpdate) history.pushState(null, null, this.url.path + (this.url.hash != '' ? '#' + this.url.hash : '') );

		if (this.url.relPath == '') {
			this.isFront = true;
		} else {
			this.isFront = false;
		}
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
		w.currentPage.$el.dataset.visible = false;
		w.utils.scrollTop(0, false);
		this.pageTransitionStarted = true;
		w.currentPage.$el.addEventListener(w.utils.transitionName,
			_.bind(function() {
				this.pageTransitionStarted = false;
				this.showNewPage();
			}, this)
		)
	}
}

Router.init();
// End of /Users/john/rmsource/rmcode-help/_build/js/router.js
})(window);