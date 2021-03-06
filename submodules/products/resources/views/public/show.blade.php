@extends('core::public.master')

@section('title', $model->title.' – '.trans('products::global.name').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-products body-product-'.$model->id.' body-page body-page-'.$page->id)

@section('main')
<div class="container">

    @include('core::public._btn-prev-next', ['module' => 'Products', 'model' => $model])
    <article class="row">
        <div class="col-sm-6">
            <h1>{{ $model->title }}</h1>
            {!! $model->present()->thumb(null, 200) !!}
            <p class="summary">{{ nl2br($model->summary) }}</p>
            <div class="body">{!! $model->present()->body !!}</div>
            @include('galleries::public._galleries', ['model' => $model])
            <p>Price: $<span class="js-product-price">{{$model->price}}</span></p>
        </div>

        <div class="col-sm-6">
            {!! BootForm::open()->action(route($lang.'.products.add', $model->slug))->role('form') !!}
                @if( count($model->availableAttributes) )
                    @foreach($model->availableAttributes as $group)
                        @if(count($group->items))

                            @if($group->type == 'dropdown' || $group->type == 'radio')
                            <div class="js-attribute-group">
                                {!! BootForm::select($group->value, 'product_attribute['.$group->value.']', $group->items)->class('form-control js-attribute') !!}
                            </div>
                            @elseif($group->type == 'colorbox')
                                Available colors:
                            <div class="js-attribute-group">
                                @foreach($group->items as $key => $color)
                                <label for="{{$group->value . $key}}">
                                    <div class="col-sm-1">
                                        {!! BootForm::radio('', 'product_attribute['.$group->value.']', $key)->id($group->value . $key)->class('js-attribute') !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="border:1px solid gray;width:50px;height:30px;background-color:{{$color}}"></div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @endif
                        @endif
                    @endforeach
                    <div class="row">
                        <div class="col-sm-6">
                        {!! BootForm::text('Custom 1', 'product_custom_attribute[dimension1]') !!}
                        </div>
                        <div class="col-sm-6">
                        {!! BootForm::text('Custom 2', 'product_custom_attribute[dimension2]') !!}
                        </div>
                    </div>
                @endif
                <button class="btn-primary btn" type="submit">@lang('db.Add to Basket')</button>
                <a class="btn-primary btn" href="{{ route(config('app.locale') . '.shop.basket') }}">Basket</a>
            {!! BootForm::close() !!}
        </div>
    </article>
</div>
@endsection
