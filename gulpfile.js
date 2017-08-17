/*eslint no-console: 0*/
'use strict'

var gulp = require('gulp')
  , uglify = require('gulp-uglify')
  , concat = require('gulp-concat')
  , rename = require('gulp-rename')
  , cleanCSS = require('gulp-clean-css')
  , less = require('gulp-less')
  , watch = require('gulp-watch')
  , prefixer = require('gulp-autoprefixer')
  //, sass = require('gulp-sass')
  ;

var path = {
    build: {
        site: {
            css: 'css/build/',
            js: 'js/build/'
        },
        admin: {
            css: 'admin/assets/css/build/',
            js: 'admin/assets/js/build/'
        }
    },
    dev: {
        site: {
            js: 'js/main.js',
            jsPages: 'js/pages/*/*.js',
            widgets: 'js/widgets/*.js',
            less: 'css/*.less',
            blocks: 'css/blocks/*/*.less',
            pages: 'css/pages/*/*.less',
            vendorCss: 'css/vendor/*.css'
        },
        admin: {
            js: 'admin/assets/js/main.js',
            jsPages: 'admin/assets/js/pages/*/*.js',
            less: 'admin/assets/css/*.less',
            blocks: 'admin/assets/css/blocks/*/*.less',
        }
    }
}

gulp.task('styles', function () {
    return gulp.src([
        //path.dev.site.vendorCss,
        path.dev.site.less,
        path.dev.site.blocks,
        path.dev.site.pages
    ])
    .pipe(concat('__main.less'))
    .pipe(less())
    .pipe(prefixer())
    .on('error', console.log)
    .pipe(gulp.dest(path.build.site.css))
    .pipe(cleanCSS())
    .pipe(rename('_main.css'))
    .pipe(gulp.dest(path.build.site.css));
});

gulp.task('styles-admin', function () {
    return gulp.src([
        path.dev.admin.less
    ])
    .pipe(concat('__main.less'))
    .pipe(less())
    .pipe(prefixer())
    .on('error', console.log)
    .pipe(gulp.dest(path.build.admin.css))
    .pipe(cleanCSS())
    .pipe(rename('_main.css'))
    .pipe(gulp.dest(path.build.admin.css));
});

gulp.task('scripts', function () {
    return gulp.src([
        path.dev.site.js,
        path.dev.site.jsPages,
        path.dev.site.widgets
    ])
    //.pipe(concat('__main.js'))
    .pipe(gulp.dest(path.build.site.js))
    .pipe(uglify().on('error', function(e){
        console.log(e);
    }))
    //.pipe(rename('_main.js'))
    .pipe(gulp.dest(path.build.site.js))
});

gulp.task('scripts-admin', function () {
    return gulp.src([
        path.dev.admin.js,
        path.dev.admin.jsPages
    ])
    //.pipe(concat('__main.js'))
    .pipe(gulp.dest(path.build.admin.js))
    .pipe(uglify().on('error', function(e){
        console.log(e);
    }))
    //.pipe(rename('_main.js'))
    .pipe(gulp.dest(path.build.admin.js))
});

gulp.task('build', ['scripts', 'styles'], function () {});

gulp.task('watch', function(){
    watch([path.dev.site.less, path.dev.site.blocks], function(event, cb) {
        gulp.start('styles');
    });
});

gulp.task('watch-admin', function(){
    watch([path.dev.admin.less, path.dev.admin.pages, path.dev.admin.blocks], function(event, cb) {
        gulp.start('styles');
    });
});
