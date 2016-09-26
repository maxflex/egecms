const elixir = require('laravel-elixir');

// require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

 elixir(function(mix) {
     mix
        .browserSync({
            port: 8088,
            open: 'external',
            host: 'egecms.app',
            proxy: 'https://egecms.app:8087',
            https: true
        })
         .sass('app.scss')
         .coffee(['resources/assets/coffee/*.coffee', 'resources/assets/coffee/*/*.coffee'])
         .scripts([
             '../bower/jquery/dist/jquery.js',
             '../bower/bootstrap/dist/js/bootstrap.min.js',
             '../bower/jquery-ui/ui/minified/core.min.js',
             '../bower/jquery-ui/ui/minified/widget.min.js',
             '../bower/angular/angular.min.js',
             '../bower/angular-animate/angular-animate.min.js',
             '../bower/angular-sanitize/angular-sanitize.min.js',
             '../bower/angular-resource/angular-resource.min.js',
             '../bower/angular-aria/angular-aria.min.js',
             '../bower/angular-messages/angular-messages.min.js',
             '../bower/angular-material/angular-material.min.js',
             '../bower/angular-i18n/angular-locale_ru-ru.js',
             '../bower/nprogress/nprogress.js',
             '../bower/underscore/underscore-min.js',
             '../bower/bootstrap-select/dist/js/bootstrap-select.js',
             '../bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
             '../bower/bootstrap-datepicker/dist/locales/bootstrap-datepicker.ru.min.js',
             '../bower/jquery-ui/ui/core.js',
             '../bower/jquery-ui/ui/widget.js',
             '../bower/jquery-ui/ui/mouse.js',
             '../bower/jquery-ui/ui/sortable.js',
             '../bower/jquery-ui/ui/draggable.js',
             '../bower/jquery-ui/ui/droppable.js',
             '../bower/angular-ui-sortable/sortable.min.js',
             '../bower/angular-bootstrap/ui-bootstrap.min.js',
             '../bower/cropper/dist/cropper.js',
             '../bower/ladda/dist/spin.min.js',
             '../bower/ladda/dist/ladda.min.js',
             '../bower/angular-ladda/dist/angular-ladda.min.js',
             '../bower/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js',
             '../bower/StickyTableHeaders/js/jquery.stickytableheaders.js',
             '../bower/jquery.floatThead/dist/jquery.floatThead.min.js',
             '../bower/jsSHA/src/sha256.js',
             '../bower/jquery.cookie/jquery.cookie.js',
             '../bower/ace-builds/src/ace.js',
             '../bower/ace-builds/src/mode-html.js',
             '../bower/ace-builds/src/mode-json.js',
             '../bower/ace/lib/ace/commands/default_commands.js',
             '../bower/angular-file-upload/dist/angular-file-upload.min.js',
             '../bower/jquery.maskedinput/dist/jquery.maskedinput.min.js',
             'resources/assets/js/*.js',
         ], 'public/js/vendor.js');
 });
