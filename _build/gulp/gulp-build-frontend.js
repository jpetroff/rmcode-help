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

gulp.task('js-libs-admin', function(){
	var base = './frontend_src/libs/js/'

	gulp.src([
		base + 'underscore-min.js',
		base + 'vue.min.js'
	])
		.pipe(concat('libs.js'))
		.pipe(gulp.dest('./frontend_public/js'))

});

gulp.task('js-build-admin', function(){
	gulp.src(['frontend_src/js/*.js'])
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
		], {base: './frontend_src'}))
		.pipe(concat('app.js'))
		.pipe(gulp.dest('frontend_public/js'))

});

gulp.task('less-admin', function(){
	gulp.src(['frontend_src/less/**/*.less', 'frontend_src/libs/css/normalize.css'])
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
		],{base: './frontend_src'}))
		.pipe(concat('main.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./frontend_public/css'));
})


gulp.task('assets', function() {
	gulp.src('assets/**/*.*')
		.pipe(cache('assets'))
		.pipe(gulp.dest('./frontend_public'))
		.pipe(gulp.dest('./frontend_public'))
})


