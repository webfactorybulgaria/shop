@extends('core::admin.master')

@section('title', trans('coupons::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'coupons'])
    <h1>
        @lang('coupons::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-coupons'))->multipart()->role('form') !!}
        @include('coupons::admin._form')
    {!! BootForm::close() !!}

@endsection
