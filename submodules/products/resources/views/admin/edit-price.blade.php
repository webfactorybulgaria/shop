@extends('core::admin.master')

@section('title', 'Price rule #' . $model->id)

@section('main')

    <a class="btn-back" href="{{ route('admin::edit-product', $product->id) }}" title="{{ trans('products::global.Back') }}"><span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ trans('products::global.Back') }}</span></a>

    <h1>Price rule #{{ $model->id }}</h1>

    {!! BootForm::open()->put()->action(route('admin::update-productprice', [$product->id, $model->id]))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('products::admin._form-prices')
    {!! BootForm::close() !!}

@endsection
