(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/utils.js

w.utils = {
	// @TODO: add Promise polyfill
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
	}
}
// End of /Users/john/rmsource/rmcode-help/_build/js/utils.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/main.js

w.Page = function() {
	return {
		data: {
			test: ''
		},
		methods: {
			_testajax: function (link) {
				w.Router.changePage(link);
			}
		}
	}
}
// End of /Users/john/rmsource/rmcode-help/_build/js/main.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/router.js

w.Router = {
	pageContainer: '#app-page',
	init: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
	},
	changePage: function(url) {
		console.log(url);
		var pagePath = this.getPageFromURL(url);


		w.currentPage.$el.dataset.transition = 1;

		w.utils.ajax({
			method: 'GET',
			url: 'http://rm.local/api/page/' + pagePath
		}).then(_.bind(this.showPage, this));
	},
	getPageFromURL: function(_url) {
		var url = null;
		var pagePath = '/';

		if (_url && typeof _url.href == 'string') {
			url = _url;
			pagePath = w.utils.untrailingslashit(url.pathname.replace( w._home_url.pathname, ''));
		} else {
			url = document.createElement('a');
			url.href = _url;
			pagePath = w.utils.untrailingslashit(url.pathname.replace( w._home_url.pathname, ''));
		}

		return pagePath || '/';
	},
	showPage: function(data) {
		w.currentPage.$el.innerHTML = data;
		w.currentPage.$el.dataset.transition = 0;
		w.currentPage.$destroy();
		this.init();
	}
}

Router.init();
// End of /Users/john/rmsource/rmcode-help/_build/js/router.js
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
			height: 300
		}
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
			if(this.inputFocus) {

				if (this.query.length > 0 && this.waitingForResults) {
					return 'waiting';
				}

				if (this.query.length > 0 && !this.waitingForResults && this.results.length == 0) {
					if (this.query == this.value) {
						return 'empty';
					}
					else {
						return 'hidden';
					}
				}

				if (
					this.query.length > 0 &&
					!this.waitingForResults &&
					this.results.length > 0
				) {
					if (this.query == this.value) {
						return 'success';
					} else {
						return 'inactive';
					}
				}

				if (this.query.length == 0) {
					return 'hidden';
				}

			} else {

				return 'hidden';

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
		}
	}
});

function initWindowParams() {
	var pageContent = document.getElementsByClassName('page-content')[0];

	var pageContentClientWidth = pageContent.clientWidth;
	var pageContentLeftOffset = pageContent.offsetLeft;
	var windowClientHeight = window.innerHeight;

	window.rmSearch.presentation.width = pageContentClientWidth;
	window.rmSearch.presentation.left = pageContentLeftOffset;
	window.rmSearch.presentation.height = windowClientHeight;
}

initWindowParams();
w.addEventListener('resize', initWindowParams);

window.rmSearch.$mount('#search-component-vue');



// End of /Users/john/rmsource/rmcode-help/_build/js/search.js
})(window);