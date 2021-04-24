/* ------------------------------------------------------------------------------
 *
 *  # Gulp file
 *
 *  Basic Gulp tasks for Limitless template
 *
 *  Version: 1.0
 *  Latest update: Dec 2, 2015
 *
 * ---------------------------------------------------------------------------- */

var gulp = require('gulp');

/* set project paths */

var baseProject = '.';

var project = {
    sass: baseProject + '/src/sass',
    css: baseProject + '/css',
    js: baseProject + '/src/js',
    cssDist: baseProject + '/dist/css',
    jsDist: baseProject + '/dist/js'
};

// Include our plugins
var autoprefixer = require('autoprefixer');
var concat = require('gulp-concat');
var cssnano = require('gulp-cssnano');
var minify = require('gulp-minify');
var postcss = require('gulp-postcss');
var rename = require('gulp-rename');
var sass = require('gulp-sass');

// Compile scss files
gulp.task('scss', function() {
    return gulp
        .src(project.sass + '/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(project.css)); // create normal CSS
});

// add vendor prefixes - https://github.com/postcss/postcssk
gulp.task('postcss', ['scss'], function() {
    // scss has to be finished before postcss
    return gulp
        .src(project.css + '/*.css')
        .pipe(postcss([autoprefixer({ browsers: ['last 4 versions'] })]))
        .pipe(gulp.dest(project.css));
});

// optimise css - http://cssnano.co/
gulp.task('cssnano', ['postcss'], function() {
    // postcss has to be finished before cssnano
    return gulp
        .src([project.css + '/*.css', '!' + project.css + '/*.min.css']) // exclude .min.css
        .pipe(cssnano({ zindex: false, minifyFontValues: false, discardUnused: false }))
        .pipe(
            rename({
                suffix: '.min' // add *.min suffix
            })
        )
        .pipe(gulp.dest(project.css));
});

gulp.task('combinecss', ['cssnano'], function() {
    // cssnano has to be finished before combinecss
    return gulp
        .src([project.css + '/*.min.css'])
        .pipe(concat('material-forms.min.css'))
        .pipe(gulp.dest(project.cssDist));
});

// Create minified js
gulp.task('minifyjs', function() {
    return gulp
        .src([project.js + '/**/**/*.js', '!' + project.js + '/**/**/*.min.js'])
        .pipe(
            minify({
                ext: {
                    src: '.js',
                    min: [/(.*)\.js$/, '$1.min.js']
                },
                noSource: true
            })
        )
        .pipe(gulp.dest(project.js));
});
// Combine js files
gulp.task('combinejs', ['minifyjs'], function() {
    // minifyjs has to be finished before combinejs

    /* =================================================================
        Important: each disabled src has to be disabled the same way in
        phpformbuilder/plugins/materialize/src/js/global.js M.AutoInit()
    ================================================================= */

    return gulp
        .src([
            project.js + '/cash.js',
            project.js + '/component.js',
            project.js + '/global.js',
            project.js + '/anime.js',
            project.js + '/collapsible.js',
            project.js + '/dropdown.js',
            project.js + '/modal.js',
            // project.js + '/materialbox.js',
            // project.js + '/parallax.js',
            // project.js + '/tabs.js',
            // project.js + '/tooltip.js',
            project.js + '/waves.js',
            // project.js + '/toasts.js',
            // project.js + '/sidenav.js',
            // project.js + '/scrollspy.js',
            // project.js + '/autocomplete.js',
            project.js + '/forms.js',
            // project.js + '/slider.js',
            // project.js + '/cards.js',
            // project.js + '/chips.js',
            // project.js + '/pushpin.js',
            project.js + '/buttons.js',
            // project.js + '/datepicker.js',
            // project.js + '/timepicker.js',
            // project.js + '/characterCounter.js',
            // project.js + '/carousel.js',
            project.js + '/tapTarget.js',
            project.js + '/select.js',
            project.js + '/range.js'
        ])
        .pipe(concat('material-forms.min.js'))
        .pipe(gulp.dest(project.jsDist));
});

/* =============================================
    WATCH & DIST
============================================= */

gulp.task('watch', function() {
    // Watch files for changes
    gulp.watch(project.sass + '/**/*.scss', ['sass']);

    gulp.watch(project.js + '/**/*.js', ['scripts']);
});

// main SASS task
gulp.task('sass', ['scss', 'postcss', 'cssnano', 'combinecss']);

// main SCRIPTS task
gulp.task('scripts', ['minifyjs', 'combinejs']);

gulp.task('dist', [
    // dist all concat & minified files
    'scss',
    'postcss',
    'cssnano',
    'combinecss',
    'minifyjs',
    'combinejs'
]);

// Default task
gulp.task('default', [
    // list of default tasks
    'watch' // watch for changes
]);
