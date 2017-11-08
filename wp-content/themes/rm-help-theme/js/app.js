(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/pace.modified.js

var AjaxMonitor, Bar, DocumentMonitor, ElementMonitor, ElementTracker, EventLagMonitor, Evented, Events, NoTargetError, Pace, RequestIntercept, SOURCE_KEYS, Scaler, SocketRequestTracker, XHRRequestTracker, animation, avgAmplitude, bar, cancelAnimation, cancelAnimationFrame, defaultOptions, extend, extendNative, getFromDOM, getIntercept, handlePushState, ignoreStack, init, now, options, requestAnimationFrame, result, runAnimation, scalers, shouldIgnoreURL, shouldTrack, source, sources, uniScaler, _WebSocket, _XDomainRequest, _XMLHttpRequest, _i, _intercept, _len, _pushState, _ref, _ref1, _replaceState,
	__slice = [].slice,
	__hasProp = {}.hasOwnProperty,
	__extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	__indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

defaultOptions = {
	catchupTime: 100,
	initialRate: .03,
	minTime: 250,
	ghostTime: 100,
	maxProgressPerFrame: 20,
	easeFactor: 1.25,
	startOnPageLoad: false,
	restartOnPushState: false,
	restartOnRequestAfter: true,
	target: 'body',
	elements: {
		checkInterval: 100,
		selectors: ['body']
	},
	eventLag: {
		minSamples: 10,
		sampleCount: 3,
		lagThreshold: 3
	},
	ajax: {
		trackMethods: ['GET'],
		trackWebSockets: false,
		ignoreURLs: ['/search']
	}
};

now = function() {
	var _ref;
	return (_ref = typeof performance !== "undefined" && performance !== null ? typeof performance.now === "function" ? performance.now() : void 0 : void 0) != null ? _ref : +(new Date);
};

requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame;

if (requestAnimationFrame == null) {
	requestAnimationFrame = function(fn) {
		return setTimeout(fn, 50);
	};
	cancelAnimationFrame = function(id) {
		return clearTimeout(id);
	};
}

runAnimation = function(fn) {
	var last, tick;
	last = now();
	tick = function() {
		var diff;
		diff = now() - last;
		if (diff >= 33) {
			last = now();
			return fn(diff, function() {
				return requestAnimationFrame(tick);
			});
		} else {
			return setTimeout(tick, 33 - diff);
		}
	};
	return tick();
};

result = function() {
	var args, key, obj;
	obj = arguments[0], key = arguments[1], args = 3 <= arguments.length ? __slice.call(arguments, 2) : [];
	if (typeof obj[key] === 'function') {
		return obj[key].apply(obj, args);
	} else {
		return obj[key];
	}
};

extend = function() {
	var key, out, source, sources, val, _i, _len;
	out = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
	for (_i = 0, _len = sources.length; _i < _len; _i++) {
		source = sources[_i];
		if (source) {
			for (key in source) {
				if (!__hasProp.call(source, key)) continue;
				val = source[key];
				if ((out[key] != null) && typeof out[key] === 'object' && (val != null) && typeof val === 'object') {
					extend(out[key], val);
				} else {
					out[key] = val;
				}
			}
		}
	}
	return out;
};

avgAmplitude = function(arr) {
	var count, sum, v, _i, _len;
	sum = count = 0;
	for (_i = 0, _len = arr.length; _i < _len; _i++) {
		v = arr[_i];
		sum += Math.abs(v);
		count++;
	}
	return sum / count;
};

getFromDOM = function(key, json) {
	var data, e, el;
	if (key == null) {
		key = 'options';
	}
	if (json == null) {
		json = true;
	}
	el = document.querySelector("[data-pace-" + key + "]");
	if (!el) {
		return;
	}
	data = el.getAttribute("data-pace-" + key);
	if (!json) {
		return data;
	}
	try {
		return JSON.parse(data);
	} catch (_error) {
		e = _error;
		return typeof console !== "undefined" && console !== null ? console.error("Error parsing inline pace options", e) : void 0;
	}
};

Evented = (function() {
	function Evented() {}

	Evented.prototype.on = function(event, handler, ctx, once) {
		var _base;
		if (once == null) {
			once = false;
		}
		if (this.bindings == null) {
			this.bindings = {};
		}
		if ((_base = this.bindings)[event] == null) {
			_base[event] = [];
		}
		return this.bindings[event].push({
			handler: handler,
			ctx: ctx,
			once: once
		});
	};

	Evented.prototype.once = function(event, handler, ctx) {
		return this.on(event, handler, ctx, true);
	};

	Evented.prototype.off = function(event, handler) {
		var i, _ref, _results;
		if (((_ref = this.bindings) != null ? _ref[event] : void 0) == null) {
			return;
		}
		if (handler == null) {
			return delete this.bindings[event];
		} else {
			i = 0;
			_results = [];
			while (i < this.bindings[event].length) {
				if (this.bindings[event][i].handler === handler) {
					_results.push(this.bindings[event].splice(i, 1));
				} else {
					_results.push(i++);
				}
			}
			return _results;
		}
	};

	Evented.prototype.trigger = function() {
		var args, ctx, event, handler, i, once, _ref, _ref1, _results;
		event = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
		if ((_ref = this.bindings) != null ? _ref[event] : void 0) {
			i = 0;
			_results = [];
			while (i < this.bindings[event].length) {
				_ref1 = this.bindings[event][i], handler = _ref1.handler, ctx = _ref1.ctx, once = _ref1.once;
				handler.apply(ctx != null ? ctx : this, args);
				if (once) {
					_results.push(this.bindings[event].splice(i, 1));
				} else {
					_results.push(i++);
				}
			}
			return _results;
		}
	};

	return Evented;

})();

Pace = window.Pace || {};

window.Pace = Pace;

extend(Pace, Evented.prototype);

options = Pace.options = extend({}, defaultOptions, window.paceOptions, getFromDOM());

_ref = ['ajax', 'document', 'eventLag', 'elements'];
for (_i = 0, _len = _ref.length; _i < _len; _i++) {
	source = _ref[_i];
	if (options[source] === true) {
		options[source] = defaultOptions[source];
	}
}

NoTargetError = (function(_super) {
	__extends(NoTargetError, _super);

	function NoTargetError() {
		_ref1 = NoTargetError.__super__.constructor.apply(this, arguments);
		return _ref1;
	}

	return NoTargetError;

})(Error);

Bar = (function() {
	function Bar() {
		this.progress = 0;
	}

	Bar.prototype.getElement = function() {
		var targetElement;
		if (this.el == null) {
			targetElement = document.querySelector(options.target);
			if (!targetElement) {
				throw new NoTargetError;
			}
			this.el = document.createElement('div');
			this.el.className = "pace pace-active";
			document.body.className = document.body.className.replace(/ pace-done/g, '');
			document.body.className += ' pace-running';
			this.el.innerHTML = '<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>';
			if (targetElement.firstChild != null) {
				targetElement.insertBefore(this.el, targetElement.firstChild);
			} else {
				targetElement.appendChild(this.el);
			}
		}
		return this.el;
	};

	Bar.prototype.finish = function() {
		var el;
		el = this.getElement();
		el.className = el.className.replace(' pace-active', '');
		el.className += ' pace-inactive';
		document.body.className = document.body.className.replace(' pace-running', '');
		return document.body.className += ' pace-done';
	};

	Bar.prototype.update = function(prog) {
		this.progress = prog;
		return this.render();
	};

	Bar.prototype.destroy = function() {
		try {
			this.getElement().parentNode.removeChild(this.getElement());
		} catch (_error) {
			NoTargetError = _error;
		}
		return this.el = void 0;
	};

	Bar.prototype.render = function() {
		var el, key, progressStr, transform, _j, _len1, _ref2;
		if (document.querySelector(options.target) == null) {
			return false;
		}
		el = this.getElement();
		transform = "translate3d(" + this.progress + "%, 0, 0)";
		_ref2 = ['webkitTransform', 'msTransform', 'transform'];
		for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
			key = _ref2[_j];
			el.children[0].style[key] = transform;
		}
		if (!this.lastRenderedProgress || this.lastRenderedProgress | 0 !== this.progress | 0) {
			el.children[0].setAttribute('data-progress-text', "" + (this.progress | 0) + "%");
			if (this.progress >= 100) {
				progressStr = '99';
			} else {
				progressStr = this.progress < 10 ? "0" : "";
				progressStr += this.progress | 0;
			}
			el.children[0].setAttribute('data-progress', "" + progressStr);
		}
		return this.lastRenderedProgress = this.progress;
	};

	Bar.prototype.done = function() {
		return this.progress >= 100;
	};

	return Bar;

})();

Events = (function() {
	function Events() {
		this.bindings = {};
	}

	Events.prototype.trigger = function(name, val) {
		var binding, _j, _len1, _ref2, _results;
		if (this.bindings[name] != null) {
			_ref2 = this.bindings[name];
			_results = [];
			for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
				binding = _ref2[_j];
				_results.push(binding.call(this, val));
			}
			return _results;
		}
	};

	Events.prototype.on = function(name, fn) {
		var _base;
		if ((_base = this.bindings)[name] == null) {
			_base[name] = [];
		}
		return this.bindings[name].push(fn);
	};

	return Events;

})();

_XMLHttpRequest = window.XMLHttpRequest;

_XDomainRequest = window.XDomainRequest;

_WebSocket = window.WebSocket;

extendNative = function(to, from) {
	var e, key, _results;
	_results = [];
	for (key in from.prototype) {
		try {
			if ((to[key] == null) && typeof from[key] !== 'function') {
				if (typeof Object.defineProperty === 'function') {
					_results.push(Object.defineProperty(to, key, {
						get: function() {
							return from.prototype[key];
						},
						configurable: true,
						enumerable: true
					}));
				} else {
					_results.push(to[key] = from.prototype[key]);
				}
			} else {
				_results.push(void 0);
			}
		} catch (_error) {
			e = _error;
		}
	}
	return _results;
};

ignoreStack = [];

Pace.ignore = function() {
	var args, fn, ret;
	fn = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
	ignoreStack.unshift('ignore');
	ret = fn.apply(null, args);
	ignoreStack.shift();
	return ret;
};

Pace.track = function() {
	var args, fn, ret;
	fn = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
	ignoreStack.unshift('track');
	ret = fn.apply(null, args);
	ignoreStack.shift();
	return ret;
};

shouldTrack = function(method) {
	var _ref2;
	if (method == null) {
		method = 'GET';
	}
	if (ignoreStack[0] === 'track') {
		return 'force';
	}
	if (!ignoreStack.length && options.ajax) {
		if (method === 'socket' && options.ajax.trackWebSockets) {
			return true;
		} else if (_ref2 = method.toUpperCase(), __indexOf.call(options.ajax.trackMethods, _ref2) >= 0) {
			return true;
		}
	}
	return false;
};

RequestIntercept = (function(_super) {
	__extends(RequestIntercept, _super);

	function RequestIntercept() {
		var monitorXHR,
			_this = this;
		RequestIntercept.__super__.constructor.apply(this, arguments);
		monitorXHR = function(req) {
			var _open;
			_open = req.open;
			return req.open = function(type, url, async) {
				if (shouldTrack(type)) {
					_this.trigger('request', {
						type: type,
						url: url,
						request: req
					});
				}
				return _open.apply(req, arguments);
			};
		};
		window.XMLHttpRequest = function(flags) {
			var req;
			req = new _XMLHttpRequest(flags);
			monitorXHR(req);
			return req;
		};
		try {
			extendNative(window.XMLHttpRequest, _XMLHttpRequest);
		} catch (_error) {}
		if (_XDomainRequest != null) {
			window.XDomainRequest = function() {
				var req;
				req = new _XDomainRequest;
				monitorXHR(req);
				return req;
			};
			try {
				extendNative(window.XDomainRequest, _XDomainRequest);
			} catch (_error) {}
		}
		if ((_WebSocket != null) && options.ajax.trackWebSockets) {
			window.WebSocket = function(url, protocols) {
				var req;
				if (protocols != null) {
					req = new _WebSocket(url, protocols);
				} else {
					req = new _WebSocket(url);
				}
				if (shouldTrack('socket')) {
					_this.trigger('request', {
						type: 'socket',
						url: url,
						protocols: protocols,
						request: req
					});
				}
				return req;
			};
			try {
				extendNative(window.WebSocket, _WebSocket);
			} catch (_error) {}
		}
	}

	return RequestIntercept;

})(Events);

_intercept = null;

getIntercept = function() {
	if (_intercept == null) {
		_intercept = new RequestIntercept;
	}
	return _intercept;
};

shouldIgnoreURL = function(url) {
	var pattern, _j, _len1, _ref2;
	_ref2 = options.ajax.ignoreURLs;
	for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
		pattern = _ref2[_j];
		if (typeof pattern === 'string') {
			if (url.indexOf(pattern) !== -1) {
				return true;
			}
		} else {
			if (pattern.test(url)) {
				return true;
			}
		}
	}
	return false;
};

getIntercept().on('request', function(_arg) {
	var after, args, request, type, url;
	type = _arg.type, request = _arg.request, url = _arg.url;
	if (shouldIgnoreURL(url)) {
		return;
	}
	if (!Pace.running && (options.restartOnRequestAfter !== false || shouldTrack(type) === 'force')) {
		args = arguments;
		after = options.restartOnRequestAfter || 0;
		if (typeof after === 'boolean') {
			after = 0;
		}
		return setTimeout(function() {
			var stillActive, _j, _len1, _ref2, _ref3, _results;
			if (type === 'socket') {
				stillActive = request.readyState < 2;
			} else {
				stillActive = (0 < (_ref2 = request.readyState) && _ref2 < 4);
			}
			if (stillActive) {
				Pace.restart();
				_ref3 = Pace.sources;
				_results = [];
				for (_j = 0, _len1 = _ref3.length; _j < _len1; _j++) {
					source = _ref3[_j];
					if (source instanceof AjaxMonitor) {
						source.watch.apply(source, args);
						break;
					} else {
						_results.push(void 0);
					}
				}
				return _results;
			}
		}, after);
	}
});

AjaxMonitor = (function() {
	function AjaxMonitor() {
		var _this = this;
		this.elements = [];
		getIntercept().on('request', function() {
			return _this.watch.apply(_this, arguments);
		});
	}

	AjaxMonitor.prototype.watch = function(_arg) {
		var request, tracker, type, url;
		type = _arg.type, request = _arg.request, url = _arg.url;
		if (shouldIgnoreURL(url)) {
			return;
		}
		if (type === 'socket') {
			tracker = new SocketRequestTracker(request);
		} else {
			tracker = new XHRRequestTracker(request);
		}
		return this.elements.push(tracker);
	};

	return AjaxMonitor;

})();

XHRRequestTracker = (function() {
	function XHRRequestTracker(request) {
		var event, size, _j, _len1, _onreadystatechange, _ref2,
			_this = this;
		this.progress = 0;
		if (window.ProgressEvent != null) {
			size = null;
			request.addEventListener('progress', function(evt) {
				if (evt.lengthComputable) {
					return _this.progress = 100 * evt.loaded / evt.total;
				} else {
					return _this.progress = _this.progress + (100 - _this.progress) / 2;
				}
			}, false);
			_ref2 = ['load', 'abort', 'timeout', 'error'];
			for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
				event = _ref2[_j];
				request.addEventListener(event, function() {
					return _this.progress = 100;
				}, false);
			}
		} else {
			_onreadystatechange = request.onreadystatechange;
			request.onreadystatechange = function() {
				var _ref3;
				if ((_ref3 = request.readyState) === 0 || _ref3 === 4) {
					_this.progress = 100;
				} else if (request.readyState === 3) {
					_this.progress = 50;
				}
				return typeof _onreadystatechange === "function" ? _onreadystatechange.apply(null, arguments) : void 0;
			};
		}
	}

	return XHRRequestTracker;

})();

SocketRequestTracker = (function() {
	function SocketRequestTracker(request) {
		var event, _j, _len1, _ref2,
			_this = this;
		this.progress = 0;
		_ref2 = ['error', 'open'];
		for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
			event = _ref2[_j];
			request.addEventListener(event, function() {
				return _this.progress = 100;
			}, false);
		}
	}

	return SocketRequestTracker;

})();

ElementMonitor = (function() {
	function ElementMonitor(options) {
		var selector, _j, _len1, _ref2;
		if (options == null) {
			options = {};
		}
		this.elements = [];
		if (options.selectors == null) {
			options.selectors = [];
		}
		_ref2 = options.selectors;
		for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
			selector = _ref2[_j];
			this.elements.push(new ElementTracker(selector));
		}
	}

	return ElementMonitor;

})();

ElementTracker = (function() {
	function ElementTracker(selector) {
		this.selector = selector;
		this.progress = 0;
		this.check();
	}

	ElementTracker.prototype.check = function() {
		var _this = this;
		if (document.querySelector(this.selector)) {
			return this.done();
		} else {
			return setTimeout((function() {
				return _this.check();
			}), options.elements.checkInterval);
		}
	};

	ElementTracker.prototype.done = function() {
		return this.progress = 100;
	};

	return ElementTracker;

})();

DocumentMonitor = (function() {
	DocumentMonitor.prototype.states = {
		loading: 0,
		interactive: 50,
		complete: 100
	};

	function DocumentMonitor() {
		var _onreadystatechange, _ref2,
			_this = this;
		this.progress = (_ref2 = this.states[document.readyState]) != null ? _ref2 : 100;
		_onreadystatechange = document.onreadystatechange;
		document.onreadystatechange = function() {
			if (_this.states[document.readyState] != null) {
				_this.progress = _this.states[document.readyState];
			}
			return typeof _onreadystatechange === "function" ? _onreadystatechange.apply(null, arguments) : void 0;
		};
	}

	return DocumentMonitor;

})();

EventLagMonitor = (function() {
	function EventLagMonitor() {
		var avg, interval, last, points, samples,
			_this = this;
		this.progress = 0;
		avg = 0;
		samples = [];
		points = 0;
		last = now();
		interval = setInterval(function() {
			var diff;
			diff = now() - last - 50;
			last = now();
			samples.push(diff);
			if (samples.length > options.eventLag.sampleCount) {
				samples.shift();
			}
			avg = avgAmplitude(samples);
			if (++points >= options.eventLag.minSamples && avg < options.eventLag.lagThreshold) {
				_this.progress = 100;
				return clearInterval(interval);
			} else {
				return _this.progress = 100 * (3 / (avg + 3));
			}
		}, 50);
	}

	return EventLagMonitor;

})();

Scaler = (function() {
	function Scaler(source) {
		this.source = source;
		this.last = this.sinceLastUpdate = 0;
		this.rate = options.initialRate;
		this.catchup = 0;
		this.progress = this.lastProgress = 0;
		if (this.source != null) {
			this.progress = result(this.source, 'progress');
		}
	}

	Scaler.prototype.tick = function(frameTime, val) {
		var scaling;
		if (val == null) {
			val = result(this.source, 'progress');
		}
		if (val >= 100) {
			this.done = true;
		}
		if (val === this.last) {
			this.sinceLastUpdate += frameTime;
		} else {
			if (this.sinceLastUpdate) {
				this.rate = (val - this.last) / this.sinceLastUpdate;
			}
			this.catchup = (val - this.progress) / options.catchupTime;
			this.sinceLastUpdate = 0;
			this.last = val;
		}
		if (val > this.progress) {
			this.progress += this.catchup * frameTime;
		}
		scaling = 1 - Math.pow(this.progress / 100, options.easeFactor);
		this.progress += scaling * this.rate * frameTime;
		this.progress = Math.min(this.lastProgress + options.maxProgressPerFrame, this.progress);
		this.progress = Math.max(0, this.progress);
		this.progress = Math.min(100, this.progress);
		this.lastProgress = this.progress;
		return this.progress;
	};

	return Scaler;

})();

sources = null;

scalers = null;

bar = null;

uniScaler = null;

animation = null;

cancelAnimation = null;

Pace.running = false;

handlePushState = function() {
	if (options.restartOnPushState) {
		return Pace.restart();
	}
};

if (window.history.pushState != null) {
	_pushState = window.history.pushState;
	window.history.pushState = function() {
		handlePushState();
		return _pushState.apply(window.history, arguments);
	};
}

if (window.history.replaceState != null) {
	_replaceState = window.history.replaceState;
	window.history.replaceState = function() {
		handlePushState();
		return _replaceState.apply(window.history, arguments);
	};
}

SOURCE_KEYS = {
	ajax: AjaxMonitor,
	elements: ElementMonitor,
	document: DocumentMonitor,
	eventLag: EventLagMonitor
};

(init = function() {
	var type, _j, _k, _len1, _len2, _ref2, _ref3, _ref4;
	Pace.sources = sources = [];
	_ref2 = ['ajax', 'elements', 'document', 'eventLag'];
	for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
		type = _ref2[_j];
		if (options[type] !== false) {
			sources.push(new SOURCE_KEYS[type](options[type]));
		}
	}
	_ref4 = (_ref3 = options.extraSources) != null ? _ref3 : [];
	for (_k = 0, _len2 = _ref4.length; _k < _len2; _k++) {
		source = _ref4[_k];
		sources.push(new source(options));
	}
	Pace.bar = bar = new Bar;
	scalers = [];
	return uniScaler = new Scaler;
})();

Pace.stop = function() {
	Pace.trigger('stop');
	Pace.running = false;
	bar.destroy();
	cancelAnimation = true;
	if (animation != null) {
		if (typeof cancelAnimationFrame === "function") {
			cancelAnimationFrame(animation);
		}
		animation = null;
	}
	return init();
};

Pace.restart = function() {
	Pace.trigger('restart');
	Pace.stop();
	return Pace.start();
};

Pace.go = function() {
	var start;
	Pace.running = true;
	bar.render();
	start = now();
	cancelAnimation = false;
	return animation = runAnimation(function(frameTime, enqueueNextFrame) {
		var avg, count, done, element, elements, i, j, remaining, scaler, scalerList, sum, _j, _k, _len1, _len2, _ref2;
		remaining = 100 - bar.progress;
		count = sum = 0;
		done = true;
		for (i = _j = 0, _len1 = sources.length; _j < _len1; i = ++_j) {
			source = sources[i];
			scalerList = scalers[i] != null ? scalers[i] : scalers[i] = [];
			elements = (_ref2 = source.elements) != null ? _ref2 : [source];
			for (j = _k = 0, _len2 = elements.length; _k < _len2; j = ++_k) {
				element = elements[j];
				scaler = scalerList[j] != null ? scalerList[j] : scalerList[j] = new Scaler(element);
				done &= scaler.done;
				if (scaler.done) {
					continue;
				}
				count++;
				sum += scaler.tick(frameTime);
			}
		}
		avg = sum / count;
		bar.update(uniScaler.tick(frameTime, avg));
		if (bar.done() || done || cancelAnimation) {
			bar.update(100);
			Pace.trigger('done');
			return setTimeout(function() {
				bar.finish();
				Pace.running = false;
				return Pace.trigger('hide');
			}, Math.max(options.ghostTime, Math.max(options.minTime - (now() - start), 0)));
		} else {
			return enqueueNextFrame();
		}
	});
};

Pace.start = function(_options) {
	extend(options, _options);
	Pace.running = true;
	try {
		bar.render();
	} catch (_error) {
		NoTargetError = _error;
	}
	if (!document.querySelector('.pace')) {
		return setTimeout(Pace.start, 50);
	} else {
		Pace.trigger('start');
		return Pace.go();
	}
};

if (typeof define === 'function' && define.amd) {
	define(['pace'], function() {
		return Pace;
	});
} else if (typeof exports === 'object') {
	module.exports = Pace;
} else {
	if (options.startOnPageLoad) {
		Pace.start();
	}
}

// window.paceOptions = {restartOnPushState: false,restartOnRequestAfter: true};
// End of /Users/john/rmsource/rmcode-help/_build/js/pace.modified.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/js/utils.js

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
// End of /Users/john/rmsource/rmcode-help/_build/js/utils.js
})(window);
(function(w){
"use strict";
// File /Users/john/rmsource/rmcode-help/_build/components/hint.js

w.components['hint'] = {
	template: '<div class=def-hint-box v-bind:class=\"[ show ? \'show\' : \'\', landed ? \'def-hint-box_transitions\' : \'\' ]\" v-bind:style={height:this.elHeight}><div class=def-hint-box__toggle v-on:click.prevent=toggle() ref=toggleButton>{{header}} <i class=toggle-icon><svg width=10px height=10px viewBox=\"0 0 10 10\" version=1.1 xmlns=http://www.w3.org/2000/svg xmlns:xlink=http://www.w3.org/1999/xlink><g id=close stroke=#BEBEBE stroke-width=1 stroke-linecap=round><path d=\"M1,1 L5,9\" id=Line-3></path><path d=\"M5,1 L9,9\" id=Line-3 transform=\"translate(7.000000, 5.000000) scale(-1, 1) translate(-7.000000, -5.000000) \"></path></g></svg></i></div><div class=def-hint-box__content ref=boxContent><slot></slot></div></div>',
	props: ['header'],
	data: function() {
		return { show: false, height: 0, collapsedHeight: 0, fullHeight: 0, elHeight: 0, landed: false }
	},
	mounted: function() {
		this.collapsedHeight = w.utils.outerHeight(this.$refs.toggleButton); // 2px border
		this.fullHeight = this.collapsedHeight + w.utils.outerHeight(this.$refs.boxContent);
		this.elHeight = this.show ? this.fullHeight : this.collapsedHeight;

		this.$el.addEventListener(w.utils.transitionName, _.bind(function(ev) {
			if(this.$el === ev.target) {
				this.$parent.$emit('recalcAnchorNav');
			}
		}, this));

		// prevent ontransitionend from firing at mount
		w.utils.updateDOM(function() {this.landed = true;}, this);
	},
	methods: {
		toggle: function() {
			this.show = !this.show;
			this.elHeight = this.show ? this.fullHeight : this.collapsedHeight;
		}
	}
}

// End of /Users/john/rmsource/rmcode-help/_build/components/hint.js
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
		isActive: function() {
			if(this.value.length != 0 && this.query != this.value)
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
							if(typeof ind !== 'undefined') {
								result_posts[i].parent_link = link_index[ind]['permalink'];
								result_posts[i].display_link = link_index[ind]['permalink'] + '#' + result_posts[i].post_name;
								result_posts[i].parent_title = link_index[ind]['title'];
							} else {

							}
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
			if(this.isActive == false) {
				return;
			}

			if(returnFocus == true) this.$refs.queryInput.focus();
			this.query = this.value;
			this.waitingForResults = true;
			this._requestResults();
		},
		_calcMaxHeight: function() {
			return this.presentation.height - this.$el.offsetTop - 59 - 50;
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