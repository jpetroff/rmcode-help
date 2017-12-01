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
var vueExtract = require('./gulp-vue-extract')
var wrapjs = require('./gulp-jswrapper')
var print = require('gulp-print')
var cleancss = require('gulp-clean-css')

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
	var g = gulp.src([src + 'js/*.js', src + 'components/*.vue'])
		.pipe(vueExtract({
			type:'script',
			storeTemplate: 'inline'
		}))
		.pipe(cache('js-build'))
		.pipe(print())
		.pipe(wrapjs());

	if(__prod) {
		g = g.pipe(uglify());
	}

	g = g.pipe(remember('js-build'))
		.pipe(order([
			'js/pace.modified.js',
			'js/utils.js',
			'components/*.js',
			'js/main.js',
			'js/search.js',
			'js/router.js'
		], {base: src}))
		.pipe(concat('app.js'))
		.pipe(gulp.dest(dst + 'js'))

	g = gulp.src([src + 'tinymce_js/*.js'])
		.pipe(cache('tinymce-js-build'))
		.pipe(print())
		.pipe(wrapjs());

	if(__prod) {
		g = g.pipe(uglify());
	}

	g = g.pipe(remember('tinymce-js-build'))
		.pipe(concat('editor.js'))
		.pipe(gulp.dest(dst + 'js'));

});

gulp.task('less', function(){
	var g = gulp.src([src + 'less/**/*.less', src + 'libs/css/normalize.css'])
		.pipe(cache('less'))
		.pipe(print());

	if(!__prod)
		g = g.pipe(sourcemaps.init());

	g = g.pipe(less({
			paths: ['.'],
			plugins: [autoprefix]
		}));

	if(__prod) {
		g = g.pipe(cleancss());
	}

	g = g.pipe(remember('less'))
		.pipe(order([
			'less/prefix.less',
			'libs/css/normalize.css',
			'less/main.less',
			'less/**'
		],{base: src}))
		.pipe(concat('style.css'));
	if(!__prod)
		g = g.pipe(sourcemaps.write());

	g = g.pipe(gulp.dest(dst));

	gulp.src([src + 'editor_less/**/*.less'])
		.pipe(cache('editor_less'))
		.pipe(print())
		.pipe(sourcemaps.init())
		.pipe(less({
			paths: ['.'],
			plugins: [autoprefix]
		}))
		.pipe(remember('editor_less'))
		.pipe(concat('editor-style.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(dst));
});

gulp.task('assets', function() {
	gulp.src( src + 'assets/**/*' )
		.pipe(gulp.dest(dst));
});