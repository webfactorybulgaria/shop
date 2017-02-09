@extends('core::admin.master')

@section('title', trans('shop::global.name'))

@section('main')
	@include('core::admin._button-back', ['module' => 'orders'])

	<div class="container">
		<div class="row" style="border:2px solid #ccc">
			<h1>Order # {{$order->id}}</h1>
			status: {{$order->statusCode}}<br>
			created: {{$order->created_at}}<br>
		</div>

		@if(!empty($order->items) && $order->items->count())
		<br>
		<div class="row" style="border:2px solid #ccc">
			<h2>@lang('db.Purchased products')</h2>

			@foreach($order->items as $item)
				<p><a href="{{ route('admin::edit-product', $item->reference_id) }}">Product info page</a></p>
				<p>sku: {{$item->sku}}</p>
				<p>quantity: {{$item->quantity}}</p>
				<p>price: {{$item->price}}</p>
				<p>tax: {{$item->tax}}</p>
				<p>shipping: {{$item->shipping}}</p>
				<hr>
			@endforeach
		</div>
		@endif

		@if(!empty($order->user))
		<br>
		<div class="row" style="border:2px solid #ccc">
			<h2>@lang('db.User info')</h2>
			<p>email: {{$order->user->email}}</p>
			<p>first_name: {{$order->user->first_name}}</p>
			<p>last_name: {{$order->user->last_name}}</p>
			<hr>
		</div>
		@endif

	</div>
@endsection