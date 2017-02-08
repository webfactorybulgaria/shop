@extends('core::public.master')

@section('title', $model->title.' – '.trans('products::global.name').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-products body-product-'.$model->id.' body-page body-page-'.$page->id)

@section('main')

    @include('core::public._btn-prev-next', ['module' => 'Products', 'model' => $model])
    <article class="row">
        <div class="col-sm-6">
            <h1>{{ $model->title }}</h1>
            {!! $model->present()->thumb(null, 200) !!}
            <p class="summary">{{ nl2br($model->summary) }}</p>
            <div class="body">{!! $model->present()->body !!}</div>
            <p>Price: ${{$model->price}}</p>
        </div>
        <div class="col-sm-6">
            {!! BootForm::open()->action(route($lang.'.products.add', $model->slug))->role('form') !!}
                @if( $model->attributes->count() )
                    @foreach($model->attributes as $group)
                        @if($group->items->count())
                            @if($group->type == 'dropdown')
                                {!! BootForm::select($group->value, $group->value, $group->items->pluck('value', 'id')->all()) !!}
                            @elseif($group->type == 'radio')                             
                                {{--TODO--}}
                            @elseif($group->type == 'colorbox')
                                Available colors:
                                @foreach($group->items->pluck('value', 'id') as $key => $color)
                                <label for="{{$group->value . $key}}"">
                                    <div class="col-sm-1">
                                        {!! BootForm::radio('', $group->value, $key)->id($group->value . $key) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="border:1px solid gray;width:50px;height:30px;background-color:{{$color}}"></div>
                                    </div>
                                </label>
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                    <div class="row">
                        <div class="col-sm-6">
                        {!! BootForm::text('Custom 1', 'custom[dimension1]') !!}
                        </div>
                        <div class="col-sm-6">
                        {!! BootForm::text('Custom 2', 'custom[dimension2]') !!}
                        </div>
                    </div>
                @endif
                <button class="btn-primary btn" type="submit">@lang('db.Add to Basket')</button>
            {!! BootForm::close() !!}
        </div>
    </article>

@endsection
