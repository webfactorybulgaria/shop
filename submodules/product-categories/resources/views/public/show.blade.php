@extends('core::public.master')

@section('title', $model->title.' – '.trans('products::global.name').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->meta_description)
@section('keywords', $model->meta_keywords)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-products body-product-'.$model->id.' body-page body-page-'.$page->id)

@section('main')

    {{-- @include('core::public._btn-prev-next', ['module' => 'ProductCategories', 'model' => $model]) --}}
    <article class="row">
        <div class="col-sm-6">
            <h1>{{ $model->title }}</h1>
            {!! $model->present()->thumb(null, 200) !!}
            <p class="summary">{!! $model->present()->summary !!}</p>
            <div class="body">{!! $model->present()->description !!}</div>
        </div>
    </article>

    @include('products::public._list', ['items' => $model->products])

@endsection
