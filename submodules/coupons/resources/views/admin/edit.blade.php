@extends('core::admin.master')

@section('title', $model->present()->name)

@section('main')

    @include('core::admin._button-back', ['module' => 'coupons'])
    <h1 class="@if(!$model->present()->name)text-muted @endif">
        {{ $model->present()->name ?: trans('core::global.Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-coupon', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('coupons::admin._form')
    {!! BootForm::close() !!}

@endsection
