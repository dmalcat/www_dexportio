'use strict';

import gulp from 'gulp';
import sass from 'gulp-sass';
import babel from 'gulp-babel';
import cleanCSS from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify-es';
import rename from 'gulp-rename';
import del from 'del';

sass.compiler = require('node-sass');

const assetsPath = './www/assets';

const paths = {
	styles: {
		vendor: {
			main: assetsPath + '/scss/vendor/main.scss',
			src: assetsPath + '/scss/vendor/**/*.scss',
			dest: assetsPath + '/dist/css/'
		},
		document: {
			main: assetsPath + '/scss/document/main.scss',
			src: assetsPath + '/scss/document/**/*.scss',
			dest: assetsPath + '/dist/css/'
		},
		core: {
			main: assetsPath + '/scss/core/main.scss',
			src: assetsPath + '/scss/core/**/*.scss',
			dest: assetsPath + '/dist/css/'
		},
		components: {
			main: assetsPath + '/scss/components/main.scss',
			src: assetsPath + '/scss/components/**/*.scss',
			dest: assetsPath + '/dist/css/'
		},
		ui: {
			main: assetsPath + '/scss/ui/main.scss',
			src: assetsPath + '/scss/ui/**/*.scss',
			dest: assetsPath + '/dist/css/'
		},
		cookies: {
			main: assetsPath + '/cookie-consent/styles/cookieconsent.scss',
			src: assetsPath + '/cookie-consent/styles/*.scss',
			dest: assetsPath + '/cookie-consent/dist/css/'
		}
	},
	scripts: {
		general: {
			src: [
				assetsPath + '/js/libs/jquery-3.5.1.js',
				assetsPath + '/js/libs/nette.ajax.js',
				assetsPath + '/js/libs/live-form-validation.js',
				assetsPath + '/js/libs/baguetteBox.js',
				assetsPath + '/js/libs/hamburger.js',
				assetsPath + '/js/libs/smooth-scroll.js',
				assetsPath + '/js/libs/tingle.js',
				assetsPath + '/js/libs/svg.js',
				assetsPath + '/js/main.js'
			],
			dest: assetsPath + '/dist/js/'
		},
		cookies: {
			src: [
				assetsPath + '/cookie-consent/js/cookieconsent.js',
				assetsPath + '/cookie-consent/js/cookieconsent-init.js'
			],
			dest: assetsPath + '/cookie-consent/dist/js'
		}
	}
};

export const clean = () => del([ assetsPath + '/dist' ]);

export function vendorStyles() {
	return gulp.src(paths.styles.vendor.main)
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: '1-vendor',
			suffix: '.min'
		}))
		.pipe(gulp.dest(paths.styles.vendor.dest));
}

export function documentStyles() {
	return gulp.src(paths.styles.document.main)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: '2-document',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(paths.styles.document.dest));
}

export function coreStyles() {
	return gulp.src(paths.styles.core.main)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: '3-core',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(paths.styles.core.dest));
}

export function componentStyles() {
	return gulp.src(paths.styles.components.main)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: '4-components',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(paths.styles.components.dest));
}

export function uiStyles() {
	return gulp.src(paths.styles.ui.main)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: '5-ui',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(paths.styles.ui.dest));
}

export function cookieStyles() {
	return gulp.src(paths.styles.cookies.main)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
			basename: 'cookies',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(paths.styles.cookies.dest));
}

export function scripts() {
	return gulp.src(paths.scripts.general.src)
		.pipe(babel({compact: false}))
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		//.pipe(concat('main.min.js'))
		.pipe(gulp.dest(paths.scripts.general.dest));
}

export function cookieScripts() {
	return gulp.src(paths.scripts.cookies.src)
		.pipe(babel({compact: false}))
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		.pipe(concat('cookies.min.js'))
		.pipe(gulp.dest(paths.scripts.cookies.dest));
}

function watchFiles() {
	gulp.watch(paths.styles.vendor.src, vendorStyles);
	gulp.watch(paths.styles.document.src, documentStyles);
	gulp.watch(paths.styles.core.src, coreStyles);
	gulp.watch(paths.styles.components.src, componentStyles);
	gulp.watch(paths.styles.ui.src, uiStyles);
	gulp.watch(paths.styles.cookies.src, cookieStyles);
	gulp.watch(paths.scripts.general.src, scripts);
	gulp.watch(paths.scripts.cookies.src, cookieScripts);
}

export { watchFiles as watch };

const build = gulp.series(clean, gulp.parallel(vendorStyles, documentStyles, coreStyles, componentStyles, uiStyles, cookieStyles, scripts, cookieScripts));

export default build;
