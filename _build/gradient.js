var HUSL = require('hsluv');
var tinycolor = require('tinycolor2');

function linearTween(start, stop) {
	return function tween(i) { return (stop-start) * i + start; };
};

var circularTween = (function() {
	// degrees => radians
	var dtor = function(d) { return d * Math.PI / 180; };
	// radians => degrees
	var rtod = function(r) { return r * 180 / Math.PI; };

	return function(start, stop, dir) {
		start = dtor(start);
		stop = dtor(stop);
		var d_t = dir ? (stop - start) : (start - stop);
		var delta = Math.atan2(Math.sin(d_t), Math.cos(d_t));
		return function tween(i) {
			console.log( (rtod(start + delta * i) + 360) % 360);
			return (rtod(start + delta * i) + 360) % 360;
		};
	};
})();

// var end = HUSL.hexToHsluv("#FF0000");
// var mid = HUSL.hexToHsluv("#FFD803");
// var start = HUSL.hexToHsluv("#0A00FF");

// var start = HUSL.fromHex("#FFFF00");
// var mid = HUSL.fromHex("#0000FF");

// hsl(360, 100, 100) 0%, hsl(51, 99, 100) 50%, hsl(242, 100, 100)
var start = [360,100,50];
var mid = [51,99,51];
var end = [242,100,50];


var h = circularTween(start[0], mid[0], true);
var s = linearTween(start[1], mid[1]);
var l = linearTween(start[2], mid[2]);

var h2 = circularTween(mid[0], end[0], false);
var s2 = linearTween(mid[1], end[1]);
var l2 = linearTween(mid[2], end[2]);

var output = [];

var breaks = 4;
for(var i = 0; i < breaks + 1; i++) {
	// console.log(HUSL.toHex(h(i/6), s(i/6), l(i/6)));
	// output.push(HUSL.hsluvToHex([h(i/breaks)%360, s(i/breaks), l(i/breaks)]));
	output.push(tinycolor({h:h(i/breaks), s:s(i/breaks), l:l(i/breaks)}).toHexString());
}

for(var i = 0; i < breaks + 1; i++) {
	// console.log(HUSL.toHex(h(i/6), s(i/6), l(i/6)));
	// if(i == 0) continue;
	// output.push(HUSL.hsluvToHex([h2(i/breaks)%360, s2(i/breaks), l2(i/breaks)]));
	output.push(tinycolor({h:h2(i/breaks), s:s2(i/breaks), l:l2(i/breaks)}).toHexString());
}

console.log(output.join(','));