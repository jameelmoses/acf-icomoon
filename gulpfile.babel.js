import gulp from 'gulp';
const plugins = require('gulp-load-plugins')();

gulp.task('javascript', () => {
	return gulp.src(['assets/js/input.js'])
		.pipe(plugins.jshint())
		.pipe(plugins.jshint.reporter('default'))
		.pipe(plugins.uglify())
		.pipe(plugins.concat('input.min.js'))
		.pipe(gulp.dest('assets/js/'))
	;
});

gulp.task('css', () => {
	return gulp.src(['assets/css/style.css'])
		.pipe(plugins.uglifycss())
		.pipe(plugins.concat('style.min.css'))
		.pipe(gulp.dest('assets/css/'));
});

gulp.task('watch', ['javascript', 'css'], () => {
	gulp.watch('assets/js/*.js', [ 'javascript']);
	gulp.watch('assets/css/*.css', [ 'css']);
});

gulp.task('default', ['watch']);
