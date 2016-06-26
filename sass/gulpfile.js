(function () {
    'use strict';

    var gulp = require('gulp'),
     sass = require('gulp-sass'), 
     clean = require('gulp-clean'),
     minifycss = require('gulp-minify-css'),
     autoprefixer = require('gulp-autoprefixer');
      
    var autoprefixerOptions = {
        browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
    };
    
    var sassOptions = {
        errLogToConsole: true,
        style: 'compressed' 
    };
    
    var input = 'source/main.scss';
    var output = '../public/assets/css/';

    gulp.task('sass', function () {
    return gulp
        .src(input)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(minifycss())
        .pipe(gulp.dest(output));
    });
 
 
    gulp.task('clean', function () {
        return gulp.src(output, { read: false })
            .pipe(clean());
    });
 
    gulp.task('default',['sass']);

})()
