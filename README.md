# Shop

Setup:
composer require webfactorybulgaria/shop

Add this to the config/app.php

 TypiCMS\Modules\Shop\Shells\Providers\ModuleProvider::class,


 php artisan vendor:publish --tag=shopconfig
 php artisan vendor:publish
 php artisan migrate

## Attributes ##
Add this to resources/assets/typicms/app.js:

    if (moduleName === 'attribute-groups' && action === 'edit') {
        moduleName = 'attributes';
    }

## Combinations ##
add "js-combinatorics": "0.5.2" to package.json
Run npm install
add 'node_modules/js-combinatorics/combinatorics.js', to js-admin in gulpfile.js
Run 
 gulp js-admin

## Users ##

In auth.php change the user model to 
 TypiCMS\Modules\Shop\Shells\Models\User::class


# Frontend
Create and link a page to the products module
Create and link a page to the shop module

## Basket ##
Add the following code to your template to include the basket:
@section('shop-basket')
<a href="{{ route($lang.'.shop.basket') }}">Basket</a>
@show