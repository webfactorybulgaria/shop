@extends('core::admin.master')

@section('title', trans('product-categories::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'product-categories'])
    <h1>
        @lang('product-categories::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-product-categories'))->multipart()->role('form') !!}
        @include('product-categories::admin._form')
    {!! BootForm::close() !!}

@endsection

