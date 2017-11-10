w.components = {};
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
	},
	outerHeight: function(el) {
		var height = el.offsetHeight;
		var style = getComputedStyle(el);

		height += parseInt(style.marginTop) + parseInt(style.marginBottom);
		return height;
	}
}

w.utils.init();

// window.groove = window.groove || {}; groove.widget = function(){ groove._widgetQueue.push(Array.prototype.slice.call(arguments)); }; groove._widgetQueue = [];
// groove.widget('setWidgetId', 'INSERT YOUR WIDGET ID HERE');
// groove.widget('setAutoload', false);
// !function(g,r,v){var a,c,n=r.createElement("iframe");(n.frameElement||n).style.cssText="width: 0; height: 0; border: 0",n.title="",n.role="presentation",n.src="javascript:false",r.body.appendChild(n);try{a=n.contentWindow.document}catch(b){c=r.domain;var d="javascript:document.write('<head><script>document.domain=\""+c+"\";</",i="script></head><body></body>')";n.src=d+i,a=n.contentWindow.document}var s="https:"==r.location.protocol?"https://":"http://",p="http://groove-widget-production.s3.amazonaws.com".replace("http://",s);n.className="grv-widget-tag",a.open()._l=function(){c&&(this.domain=c);var t=this.createElement("script");t.type="text/javascript",t.charset="utf-8",t.async=!0,t.src=p+"/loader.js",this.body.appendChild(t)},a.write('<body onload="document._l();">'),a.close()}(window,document);
// document.getElementById('load').addEventListener('click', function() {
// 	groove.widget('load');
// 	this.disabled = true;
// 	document.getElementById('open').addEventListener('click', function() {
// 		groove.widget('open');
// 		this.disabled = true;
// 	});
// });