// Defining requirements
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var merge2 = require('merge2');
var imagemin = require('gulp-imagemin');
var ignore = require('gulp-ignore');
var rimraf = require('gulp-rimraf');
var clone = require('gulp-clone');
var merge = require('gulp-merge');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var del = require('del');
var cleanCSS = require('gulp-clean-css');
var gulpSequence = require('gulp-sequence');
var replace = require('gulp-replace');

// Configuration file to keep your code clean
var cfg = require('./gulpconfig.json');
var paths = cfg.paths;

// Run:
// gulp watch-bs
// Starts watcher with browser-sync. Browser-sync reloads page automatically on your browser
gulp.task('watch-bs', ['browser-sync', 'watch', 'scripts'], function () { });

// Run:
// gulp browser-sync
// Starts browser-sync task for starting the server.
gulp.task('browser-sync', function() {
    browserSync.init(cfg.browserSyncWatchFiles, cfg.browserSyncOptions);
});

// Run:
// gulp watch
// Starts watcher. Watcher runs gulp sass task on changes
gulp.task('watch', function () {
    gulp.watch(paths.sass + '/**/*.scss', ['styles']);
    gulp.watch('./style.scss', ['styles']);
    gulp.watch(paths.js + '/assets/*.js', ['scripts']);
    gulp.watch(paths.js + '/theme/*.js', ['scripts']);
});

// Run: 
// gulp scripts. 
// Uglifies and concat all JS files into one
gulp.task('scripts', function() {
  //ASSET Scripts
  var assetscripts = [
    paths.js + '/assets/bootstrap.bundle.js',
    paths.js + '/assets/fontawesome-all.min.js',
    paths.js + '/assets/feather.min.js',
    paths.js + '/assets/skip-link-focus-fix.js'
  ];
  gulp.src(assetscripts)
    .pipe(concat('assets.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.js));

  //THEME Scripts
  var scripts = [
    paths.js + '/theme/theme.js',
    //Add more
  ];
  gulp.src(scripts)
    .pipe(concat('theme.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.js));
});

// Run: 
// gulp styles. 
// Styles functions sequence 
gulp.task('styles', function(callback){ gulpSequence('sass', 'editor-style')(callback) });

// Run:
// gulp sass
// Compiles SCSS files in CSS
gulp.task('sass', function () {
    gulp.src(paths.sass + '/assets.scss')
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass())
        .pipe(gulp.dest(paths.css))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano({discardComments: {removeAll: true}}))
        .pipe(sourcemaps.write('./', {includeContent:false}))
        .pipe(gulp.dest(paths.css));

    gulp.src('./style.scss')
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass())
        .pipe(sourcemaps.write('./', {includeContent:false}))
        .pipe(gulp.dest('./'));
});

// Run:
// gulp editor-style
// Compiles custom-editor-style.min.css file
gulp.task('editor-style', function () {
  var styles = [
    paths.css + '/assets.css',
    './style.css',
  ];
  gulp.src(styles)
    .pipe(concat('custom-editor-style.min.css'))
    .pipe(cssnano({discardComments: {removeAll: true}}))
    .pipe(gulp.dest(paths.css));
});

// Run
// gulp dist
// Copies the files to the /dist folder for distribution as simple theme
gulp.task('dist', ['clean-dist'], function() {
  return gulp.src(['**/*', '!'+paths.node, '!'+paths.node+'**', '!'+paths.js+'/assets/', '!'+paths.js+'/assets/**', '!'+paths.js+'/theme/', '!'+paths.js+'/theme/**', '!'+paths.css+'/assets.css', '!'+paths.css+'/assets.min.css.map', '!'+paths.dist, '!'+paths.dist+'/**', '!'+paths.distprod, '!'+paths.distprod+'/**', '!'+paths.sass, '!'+paths.sass+'/**', '!README.md', '!package.json', '!gulpfile.js', '!gulpconfig.json', '!CHANGELOG.md', '!style.scss', '!style.css.map', '*'])
    .pipe(replace('/js/jquery.slim.min.js', '/js'+paths.vendor+'/jquery.slim.min.js'))
    .pipe(replace('/js/popper.min.js', '/js'+paths.vendor+'/popper.min.js'))
    .pipe(replace('/js/skip-link-focus-fix.js', '/js'+paths.vendor+'/skip-link-focus-fix.js'))
    .pipe(gulp.dest(paths.dist));
});

// Deleting any file inside the /dist folder
gulp.task('clean-dist', function () {
  return del([paths.dist + '/**',]);
});
