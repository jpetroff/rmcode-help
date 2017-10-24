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
	}
}
// End of /Users/john/rmsource/rmcode-help/_build/js/utils.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/main.js


// End of /Users/john/rmsource/rmcode-help/_build/js/main.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/search.js

w.rmSearch = new Vue({
	data: {
		query: '',
		results: []
	},
	created: function() {
	},
	methods: {
		queryInput: function(val) {
			console.log(val);
			this.query = val;
			this.requestResults();
		},
		requestResults: _.debounce(
			function () {
				w.utils.ajax({
					url: 'http://rm.local/wp-admin/admin-ajax.php',
					method: 'POST',
					data: {
						action: 'search',
						query: this.query
					}
				}).then(_.bind(
						function(data) {
							this.results = JSON.parse(data);
							console.log(this.results);
						},
						this
					)
				)
			},
			// This is the number of milliseconds we wait for the
			// user to stop typing.
			500
		)
	}
});

w.rmSearch.$mount('#search-component-vue');
// End of /Users/john/rmsource/rmcode-help/_build/js/search.js
})(window);