var elixir = require('laravel-elixir');
var gulp = require('gulp');
var less = require ('gulp-less');
var path = require('path');
var minifycss = require('gulp-minify-css');
var autoprefix = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var minifyhtml = require('gulp-minify-html');
gulp.task('callbackCSS', function () {
    return gulp.src('./resources/assets/less/callback/**/*.less')
        .pipe(less({
            paths: [ path.join(__dirname, 'less', 'includes') ]
        }))
        .pipe(autoprefix())
        .pipe(minifycss())
        .pipe(gulp.dest('./public/css/callback'))
});

gulp.task('callbackJS',function(){
    gulp.src('./resources/assets/js/callback/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./public/js/callback'));
});

gulp.task('callbackHTML',function(){
    gulp.src('./resources/assets/html/callback/**/*.html')
        .pipe(minifyhtml())
        .pipe(gulp.dest('./public/html/callback'));
});

gulp.task('default',function(){
    gulp.run('callbackCSS');
    gulp.run('callbackHTML');
    gulp.run('callbackJS');
});