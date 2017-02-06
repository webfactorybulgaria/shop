@extends('pages::public.master')

@section('bodyClass', 'body-shop body-shop-confirmation body-page body-page-'.$page->id)

@section('main')
	@if($order->statusCode == 'completed')
    	<h1>@lang('db.Purchase has been successfully created')</h1>
    @else
    	<h1>@lang('db.Purchase has been canceled')</h1>
    @endif

    Order No: # {{ $order->id }}
    @if(!empty($order->items) && $order->items->count())
        @include('shop::public._summary', ['cart' => $order])
    @endif
@endsection
