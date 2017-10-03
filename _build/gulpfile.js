global.__src = __dirname
var gulp = require('gulp')

require('./gulp/gulp-build-admin')
require('./gulp/gulp-build-frontend')

gulp.task('admin', ['js-libs-admin', 'js-build-admin', 'less-admin', 'assets'])
gulp.task('front', ['js-libs-front', 'js-build-front', 'less-front', 'assets'])

