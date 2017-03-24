@extends('pages::public.master')

@section('bodyClass', 'body-products body-products-index body-page body-page-'.$page->id)

@section('main')

    {!! $page->present()->body !!}
    
    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('product-categories::public._list', ['items' => $models])
    @endif

@endsection
