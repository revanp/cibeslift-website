let mix = require('laravel-mix');

mix.js('resources/js/apps.js', 'public/frontend/js')
   .sass('resources/css/apps.css', 'public/frontend/css');