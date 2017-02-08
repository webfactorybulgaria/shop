@extends('core::admin.master')

@section('title', trans('products::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'products'])
    <h1>
        @lang('products::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-productprices', $product->id))->role('form') !!}
        @include('products::admin._form-prices')
    {!! BootForm::close() !!}

@endsection
