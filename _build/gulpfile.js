global.__src = __dirname + '/';
global.__dst = '../wp-content/themes/rm-help-theme/';

var gulp = require('gulp');

require('./gulp/gulp-build');
require('./gulp/gulp-watch');

gulp.task('build', ['js-libs', 'js-build', 'less', 'assets']);
gulp.task('start', ['build', 'server']);

