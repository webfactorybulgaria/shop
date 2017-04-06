@extends('pages::public.master')

@section('bodyClass', 'body-shop body-shop-checkout body-page body-page-'.$page->id)

@section('main')
<div class="container">

    @if ($cart->items->count())

    	<h1>@lang('db.Your summary:')</h1>
        @include('shop::public._summary', ['cart' => $cart])

        @if(1) {{-- TODO: check if promo functionality is enabled in settings --}}
            @include('coupons::public._coupon')
        @endif

        @if(1) {{-- TODO: check for standart / digital product --}}

            @if(!empty($user))
                @if(!empty($user->addresses) && $user->addresses->count())


{!! BootForm::open()->action(route($lang.'.shop.purchase')) !!}

@lang('db.Choose shipping address')
@foreach($user->addresses as $address)
<div class="row">
    {!! BootForm::radio($address->first_name . ' ' . $address->last_name, 'shipping_address', $address->id) !!}
    {{$address->address}}<br>
    {{$address->address2}}<br>
    {{$address->city}} {{$address->state}} {{$address->postcode}}<br>
    {{$address->country}}<br>
    {{$address->phone}}<br>
    last updated: {{$address->updated_at}}<br>
    <a href="{{ route('editAddress-profile', $address->id) }}">Edit</a>
</div>
<hr>
@endforeach

{!! BootForm::checkbox('Billing address is different', 'billing_address_different', false)->attribute('onclick', "$('#billing-address-container').toggle(this.checked)") !!}

<div id="billing-address-container" style="display:none">

@lang('db.Choose shipping address')
@foreach($user->addresses as $address)
<div class="row">
    {!! BootForm::radio($address->first_name . ' ' . $address->last_name, 'billing_address', $address->id) !!}
    {{$address->address}}<br>
    {{$address->address2}}<br>
    {{$address->city}} {{$address->state}} {{$address->postcode}}<br>
    {{$address->country}}<br>
    {{$address->phone}}<br>
    last updated: {{$address->updated_at}}<br>
    <a href="{{ route('editAddress-profile', $address->id) }}">Edit</a>
</div>
<hr>
@endforeach

</div>

{!! BootForm::submit('Buy Now!')->class('btn btn-primary') !!}


{!! BootForm::close() !!}

                @else
                    @lang('db.No shipping address found')
                @endif
                <a href="javascript:;" onclick="$('#address-form').toggle();">@lang('db.Add new address')</a>
                <div class="row" id="address-form" style="display:none;">
                    <div id="address" class="col-md-6">
                        {!! BootForm::open()->action(route('storeAddress-profile')) !!}
                            @include('users::public._form-address')
                        {!! BootForm::close() !!}
                    </div>
                </div>
            @else
                <a href="javascript:;" onclick="$('#register-form-container').hide();$('#login-form-container').toggle()">Login</a> OR
                <a href="javascript:;" onclick="$('#login-form-container').hide();$('#register-form-container').toggle()">Register</a>
                <div class="row">
                    <div id="login-form-container" class="col-md-6" style="display:none;">
                        <h1>@lang('users::global.Log in')</h1>
                        <div class="alert alert-danger" id="login-error" style="display:none;"></div>
                        {!! BootForm::open()->id('shop-login-form')->action(route('login')) !!}

                            @include('users::_form-login')
                        {!! BootForm::close() !!}
                    </div>
                    <div id="register-form-container" class="col-md-6">
                        <h1>@lang('users::global.Register')</h1>
                        <div class="alert alert-danger" id="register-error" style="display:none;"></div>
                        {!! BootForm::open()->id('shop-register-form')->action(route('register')) !!}
                            @include('users::_form-register')
                        {!! BootForm::close() !!}
                    </div>
                </div>
            @endif
        @endif

        <a href="{{ route($lang.'.shop.purchase') }}">Buy Now!</a>
    @else
    	@lang('db.Empty summary')
    @endif
</div>
@endsection
