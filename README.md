# Shop
Setup:
composer require webfactorybulgaria/shop

Add this to the config/app.php

 TypiCMS\Modules\Shop\Shells\Providers\ModuleProvider::class,

php artisan vendor:publish
php artisan migrate

## Attributes ##
Add this to resources/assets/typicms/app.js:

    if (moduleName === 'attribute-groups' && action === 'edit') {
        moduleName = 'attributes';
    }


## Users ##
Add ShopUserTrait to model User

## Basket ##
Add the following code to your template to include the basket:
@section('shop-basket')
<a href="{{ route($lang.'.shop.basket') }}">Basket</a>
@show