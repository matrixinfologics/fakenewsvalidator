var gulp = require('gulp');


gulp.task('default', function() {
    console.log('GULP THIS!');
});


/* RUN Tasks
 * ************************************************** */
gulp.task('basic-setup', function(){
    execute : 'composer install'
});

gulp.task('run:key:generate', function() {
    execute : 'php artisan key:generate'
});
