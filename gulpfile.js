var gulp = require('gulp');
var autoprefix = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var sass = require('gulp-sass');

gulp.task('styles', function() {
 return gulp.src([
  'resources/style/css/fonts.css',
  'resources/style/css/pure.min.css',
  'resources/style/css/grids-responsive.min.css',
  'resources/style/scss/style.scss'
 ])
     .pipe(sass({ style: "expanded" }))
     .pipe(concat('all.css'))
     .pipe(autoprefix('last 2 versions'))
     .pipe(minifyCSS())
     .pipe(gulp.dest('./public/css/'))
});
