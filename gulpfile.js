'use strict';

var gulp = require('gulp'),
    less = require('gulp-less'),
    watch = require('gulp-watch'),
    prefix = require('gulp-autoprefixer'),
    minifyCss = require('gulp-minify-css'),
    sourcemaps = require('gulp-sourcemaps'),
    livereload = require('gulp-livereload'),
    path = require('path');


/////////////////////////////////////////
// TASK

gulp.task('less', function () {
  gulp.src('style.less')
    .pipe(sourcemaps.init())
    .pipe(less())
    .pipe(prefix(
      "last 8 version",
      "> 1%",
      "ie 8",
      "ie 7"),
      {cascade:false}
    )

    // .pipe(minifyCss())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./'))
    .pipe(livereload());
});


/////////////////////////////////////////
// WATCH

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch('./less/**/*.less', ['less']);
    gulp.watch('style.less', ['less']);

    // gulp.watch(['style.less']).on('change', livereload.changed);
});


/////////////////////////////////////////
// DEFAULT
gulp.task('default', ['watch']);
