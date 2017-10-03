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

var autoprefix = new LessAutoprefix({ browsers: ['last 2 versions']})

global.__production = false
global.__injection = false

gulp.task('js-libs-front', function(){
	var base = './admin_src/libs/js/'

	gulp.src([
		base + 'underscore-min.js',
		base + 'vue.min.js',
		base + 'showdown.min.js'
	])
		.pipe(concat('libs.js'))
		.pipe(gulp.dest('./admin_public/js'))

});

gulp.task('js-build-front', function(){
	gulp.src(['admin_src/js/*.js'])
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
		], {base: './admin_src'}))
		.pipe(concat('app.js'))
		.pipe(gulp.dest('admin_public/js'))

});

gulp.task('less-front', function(){
	gulp.src(['admin_src/less/**/*.less', 'admin_src/libs/css/normalize.css'])
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
		],{base: './admin_src'}))
		.pipe(concat('main.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./admin_public/css'));
})



