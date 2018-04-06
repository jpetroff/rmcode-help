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

		// load logged user → load ga
		this._loadLoggedUser(_.bind(function(user) {
			user = user || {};
			this._loadGAScript(user._id);
			this._loadSupportWidget(user);
		}, this));
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

		if(window.outerWidth <= 700)
			animate = false;

		if(animate == false) {
			w.utils.updateDOM( function() {
				w.scrollTo(0, val);

				if(typeof cb == 'function') cb();
			} );
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
		var height = el.clientHeight;
		// console.log(height);
		var style = getComputedStyle(el);

		height += parseInt(style.marginTop) + parseInt(style.marginBottom);
		return height;
	},
	prepareAnalytics: function() {

	},
	_loadLoggedUser: function(callback) {
		//слушаем событие postMessage от ифрейма который скажет данные о залогиненом пользователе
		w.addEventListener('message', _.bind(function(e) {
			if (e.origin == 'https://my.readymag.com') {

				var data = JSON.parse(e.data)
				if (data.event != 'user') return

				var user = data.message
				//сохраняем данные о текущем юзере туда где они обычно лежат
				window.utils.user = user;

				callback && callback(user)

				document.body.removeChild(frame);
			}
		}, this));

		//создаем ифрейм через который мы будем получать данные о текущем пользователе, если он залогинен на РМ
		//потом ждем пока ифрейм загрузиться
		var frame = document.createElement('iframe');

		frame.style.width = 0;
		frame.style.height = 0;
		frame.style.position = 'absolute';
		frame.style.top = '-999px';
		frame.name = 'rmuser';
		frame.src = 'https://my.readymag.com/get_user_cookies.' + Date.now();
		frame.addEventListener('load', function() {
			//просим ифрейм сказать нам данные по залогиненому юзеру
			//это нужно для того, чтобы код в ифрейме знал кому отсылать данные о юзере (e.source.postMessage...)
			// frame.contentWindow.postMessage('GetLoggedUser', "*");
			window.frames.rmuser.postMessage('GetLoggedUser', "*");
		});
		document.body.appendChild(frame);
	},
	_loadGAScript: function(id, subscription) {
		ga('create', 'UA-33458420-9', 'auto', {name: 'readymag'});
		if(id && subscription) {
			ga('set', 'cd4', id);
			ga('set', 'cd5', subscription);
		}

		var gaScript = document.createElement('script');
		gaScript.src = 'https://www.google-analytics.com/analytics.js';
		gaScript.async = true;
		document.body.appendChild(gaScript);
	},
	_loadSupportWidget: function(user) {
		groove.widget('setWidgetId', '3910cca5-d6cf-0982-cec6-1538812506eb');
		if(user) {
			w.groove.widget('setCustomer', {cl_uri: user.uri, cl_num_id: user.num_id});
		}
		!function(g,r,v){var a,n,c=r.createElement("iframe");(c.frameElement||c).style.cssText="width: 0; height: 0; border: 0",c.title="",c.role="presentation",c.src="javascript:false",r.body.appendChild(c);try{a=c.contentWindow.document}catch(i){n=r.domain;var b=["javascript:document.write('<he","ad><scri","pt>document.domain=","\"",n,"\";</scri","pt></he","ad><bo","dy></bo","dy>')"];c.src=b.join(""),a=c.contentWindow.document}var d="https:"==r.location.protocol?"https://":"http://",s="http://groove-widget-production.s3.amazonaws.com".replace("http://",d);c.className="grv-widget-tag",a.open()._l=function(){n&&(this.domain=n);var t=this.createElement("script");t.type="text/javascript",t.charset="utf-8",t.async=!0,t.src=s+"/loader.js",this.body.appendChild(t)};var p=["<bo",'dy onload="document._l();">'];a.write(p.join("")),a.close()}(window,document);
	},
	_getSubscription: function(user) {
		var ret = user.stripe && user.stripe.subscription_id;

		var type = '', level = '', cycle = '';

		if (!ret || ret.toLowerCase() == 'none') {
			type = 'free';
			level = '';
		} else {

			ret = ret.toLowerCase();

			// ищем тип подписки
			if ( ret && (/yearly/g).test(ret) ) {
				cycle = 'yearly';
			} else if (ret && (/monthly/g).test(ret) ) {
				cycle = 'monthly';
			}

			level = ret;
			level = level.replace(/ /g, '');
			level = level.replace(/_/g, '');
			level = level.replace(/(yearly|monthly)/g, '');
			level = level.replace(/plan/g, '');
			level = level.trim();
			type = 'paid';
		}

		return type + ' ' + level + ' ' + cycle;
	},
}

/*
	GOOGLE ANALYTICS global definitions
 */
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;

/*
	GROOVE WIDGET global definitions
 */
window.groove = window.groove || {}; groove.widget = function(){ groove._widgetQueue.push(Array.prototype.slice.call(arguments)); }; groove._widgetQueue = [];

w.utils.init();

/*
	VUE LAZYLOAD
 */

Vue.use(VueLazyload, {
	lazyComponent: true,
	preLoad: 3
});