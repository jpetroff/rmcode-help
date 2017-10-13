var gulp = require('gulp')
var source = require('vinyl-source-stream')
var uglify = require('gulp-uglify')
var rename = require('gulp-rename')
var concat = require('gulp-concat')
var LessAutoprefix = require('less-plugin-autoprefix')
var sourcemaps = require('gulp-sourcemaps')
var less = require('gulp-less')
var cache = require('gulp-cached')
var vueSplit = require('gulp-vuesplit').default
var order = require('gulp-order')
var remember = require('gulp-remember')
// var vueExtract = require('./gulp-vue-extract')
var wrapjs = require('./gulp-jswrapper')
var print = require('gulp-print')

var src = global.__src;
var dst = global.__dst;

var autoprefix = new LessAutoprefix({ browsers: ['last 2 versions']})

global.__production = false
global.__injection = false

gulp.task('js-libs', function(){
	var base = src + 'libs/js/';

	gulp.src([
		base + 'underscore-min.js',
		base + 'vue.min.js'
	])
		.pipe(concat('libs.js'))
		.pipe(gulp.dest(dst + 'js'));

});

gulp.task('js-build', function(){
	gulp.src([src + 'js/*.js'])
		// .pipe(vueExtract({
		// 	type:'script',
		// 	storeTemplate: 'inline'
		// }))
		.pipe(cache('js-build'))
		.pipe(print())
		.pipe(wrapjs())
		.pipe(remember('js-build'))
		.pipe(order([
			'js/preamble.js',
			'components/*.js',
			'js/main.js'
		], {base: src}))
		.pipe(concat('app.js'))
		.pipe(gulp.dest(dst + 'js'))

});

gulp.task('less', function(){
	gulp.src([src + 'less/**/*.less', src + 'libs/css/normalize.css'])
		.pipe(cache('less'))
		.pipe(print())
		// .pipe(vueExtract({
		// 	type:'style'
		// }))
		.pipe(sourcemaps.init())
		.pipe(less({
			paths: ['.'],
			plugins: [autoprefix]
		}))
		.pipe(remember('less'))
		.pipe(order([
			'libs/css/normalize.css',
			// 'components/*.less',
			'less/**/*.less'
		],{base: src}))
		.pipe(concat('main.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(dst + 'css'));
});

gulp.task('assets', function() {
	gulp.src( src + 'assets/*.*' )
		.pipe(gulp.dest(dst + 'assets'));
});



