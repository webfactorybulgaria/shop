# Shop
Setup:

Add ShopUserTrait to model User

Add the following code to your template to include the basket:
@section('shop-basket')
<a href="{{ route($lang.'.shop.basket') }}">Basket</a>
@show