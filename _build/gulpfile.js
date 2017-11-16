global.__src = __dirname + '/';
global.__dst = '../wp-content/themes/rm-help-theme/';

global.__prod = (process.env.PROD == '1');

var gulp = require('gulp');

require('./gulp/gulp-build');
require('./gulp/gulp-watch');

gulp.task('build', ['js-libs', 'js-build', 'less', 'assets']);
gulp.task('start', ['build', 'server']);

