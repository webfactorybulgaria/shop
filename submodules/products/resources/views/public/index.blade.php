@extends('pages::public.master')

@section('bodyClass', 'body-products body-products-index body-page body-page-'.$page->id)

@section('main')

<div class="container">
    {!! $page->present()->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('products::public._list', ['items' => $models])
    @endif
</div>

@endsection
