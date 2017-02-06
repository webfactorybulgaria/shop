@extends('pages::public.master')

@section('bodyClass', 'body-shop body-shop-checkout body-page body-page-'.$page->id)

@section('main')

    @if ($cart->items->count())

    	<h1>@lang('db.Your summary:')</h1>
        @include('shop::public._summary', ['cart' => $cart])
        
        @if(1) {{-- TODO: check for standart / digital product --}}
            @if(!empty($user))
                @if(!empty($user->addresses) && $user->addresses->count())
                    @lang('db.Choose shipping address')
                    @include('users::public._address-list', ['addresses' => $user->addresses])
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
                <a href="javascript:;" onclick="$('#register-form').hide();$('#login-form').toggle()">Login</a> OR
                <a href="javascript:;" onclick="$('#login-form').hide();$('#register-form').toggle()"">Register</a>
                <div class="row">
                    <div id="login-form" class="col-md-6" style="display:none;">
                        {!! BootForm::open()->action(route('login')) !!}
                            @include('users::_form-login')
                        {!! BootForm::close() !!}
                    </div>
                    <div id="register-form" class="col-md-6" style="display:none;">
                        {!! BootForm::open()->action(route('register')) !!}
                            @include('users::_form-register')
                        {!! BootForm::close() !!}
                    </div>
                </div>
            @endif
        @endif

        @if(1) {{-- TODO: check if promo functionality is enabled in settings --}}
            @include('coupons::public._coupon')
        @endif
        <a href="{{ route($lang.'.shop.purchase') }}">Buy Now!</a>
    @else
    	@lang('db.Empty summary')
    @endif

@endsection
