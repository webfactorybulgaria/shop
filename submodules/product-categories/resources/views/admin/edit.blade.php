@extends('core::admin.master')

@section('title', $model->present()->title)

@section('main')

    @include('core::admin._button-back', ['module' => 'product-categories'])
    <h1 class="@if(!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: trans('core::global.Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-product-category', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('product-categories::admin._form')
    {!! BootForm::close() !!}

@endsection
