const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');
const browserSync = require('browser-sync').create();
const path = require('path');
const config = require('./assets.config.json');
const watching = process.argv.includes('watch');
function onError(error) {
  if (!watching) throw error;
  console.error(error.messageFormatted || error.message);
  this.emit('end');
}
function styles() {
  return gulp.src(config.styles, {sourcemaps: true})
    .pipe(sass({style: 'compressed'}).on('error', onError))
    .pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/css', {sourcemaps: '.'}));
}
function scripts() {
  return gulp.src('process/scripts/**/*.js', {allowEmpty: true})
    .pipe(uglify().on('error', onError)).pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/scripts'));
}
function blocks() {
  return gulp.src(['src/Blocks/**/*.scss', '!src/Blocks/**/_*.scss'], {allowEmpty: true, sourcemaps: true})
    .pipe(sass({style: 'compressed'}).on('error', onError))
    .pipe(rename({suffix: '.min'})).pipe(gulp.dest(file => file.base, {sourcemaps: '.'}));
}
const build = gulp.parallel(styles, scripts, blocks);
function watch(done) {
  const certs = path.resolve(__dirname, '../..', 'certs');
  browserSync.init({proxy: config.url, host: config.domain, port: config.port,
    open: false, notify: false,
    https: {cert: path.join(certs, 'site.pem'), key: path.join(certs, 'site-key.pem')}});
  const reload = done => { browserSync.reload(); done(); };
  gulp.watch('process/sass/**/*.scss', gulp.series(styles, reload));
  gulp.watch('process/scripts/**/*.js', gulp.series(scripts, reload));
  gulp.watch('src/Blocks/**/*.scss', gulp.series(blocks, reload));
  gulp.watch(['infrastructure.php', 'src/**/*.php']).on('change', browserSync.reload);
  done();
}
exports.build = build;
exports.watch = gulp.series(build, watch);
exports.default = exports.watch;
