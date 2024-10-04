const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .css('resources/css/custom.css', 'public/css')
    .js('resources/js/custom.js', 'public/js')
    // .js('resources/js/product/index.js', 'public/js/product')
    .js('resources/js/product/image-navigation.js', 'public/js/product')
    .js('resources/js/product/filter-update.js', 'public/js/product')
    .js('resources/js/product/reset-filter.js', 'public/js/product')
    .js('resources/js/product/infinite-scroll.js', 'public/js/product')
    .js('resources/js/product/size-update.js', 'public/js/product')
    .js('resources/js/product/add-to-wishlist.js', 'public/js/product');