@extends('pages::public.master')

@section('bodyClass', 'body-shop body-shop-basket body-page body-page-'.$page->id)

@section('main')
<div class="container">

    @if (!empty($cart->items) && $cart->items->count())

    	<h1>@lang('db.Your basket:')</h1>
    	@include('shop::public._summary', ['cart' => $cart, 'canEdit' => true])

        @include('coupons::public._coupon')
        <a href="{{ route($lang.'.shop.checkout') }}">Proceed to checkout</a>

    @else
    	@lang('db.Empty basket')
    @endif

</div>
@endsection
