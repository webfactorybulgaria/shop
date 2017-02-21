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
            <p>Price: $<span class="js-product-price">{{$model->price}}</span></p>
        </div>
        <div class="col-sm-6">
            {!! BootForm::open()->action(route($lang.'.products.add', $model->slug))->role('form') !!}

                @if( $model->availableAttributes->count() )
                    @foreach($model->availableAttributes as $group)
                        @if(count($group->items))

                            @if($group->type == 'dropdown' || $group->type == 'radio')
                            <div class="js-attribute-group">
                                {!! BootForm::select($group->value, 'attribute[]', $group->items)->class('form-control js-attribute') !!}
                            </div>
                            @elseif($group->type == 'colorbox')
                                Available colors:
                            <div class="js-attribute-group">
                                @foreach($group->items as $key => $color)
                                <label for="{{$group->value . $key}}">
                                    <div class="col-sm-1">
                                        {!! BootForm::radio('', 'attribute[]', $key)->id($group->value . $key)->class('js-attribute') !!}
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
                        {!! BootForm::text('Custom 1', 'custom[dimension1]') !!}
                        </div>
                        <div class="col-sm-6">
                        {!! BootForm::text('Custom 2', 'custom[dimension2]') !!}
                        </div>
                    </div>
                @endif
                <button class="btn-primary btn" type="submit">@lang('db.Add to Basket')</button>
                <a class="btn-primary btn" href="{{ route(config('app.locale') . '.shop.basket') }}">Basket</a>
            {!! BootForm::close() !!}
        </div>
    </article>
    <!-- <div onload="alert('asd')" ng-app="promocode" ng-controller="PromocodeController">
        <div ng-show="!promocode">
            Have a promocode?

            <form name="promoForm">
                <input type="text" name="coupon" id="coupon" class="form-control" ng-model="form.coupon" required>

                <div class="btn-toolbar">
                    <div class="btn-primary btn" id="apply-promo" ng-click="checkCoupon()" name="applypromo">@lang('validation.attributes.apply promo')</div>
                </div>
            </form>
        </div>
        <div ng-show="promocode">
            <p>Promocode @{{promocode.code}} applied.</p>
            <p ng-show="promocode.discount > 0">Discount: @{{promocode.discount}}%</p>
            <p ng-show="promocode.value > 0">Discount: @{{promocode.value}} currency</p>
        </div>
    </div> -->

    <div>
        <div class="ask-for-promo">
            <span>Have a promocode?</span>
            <form name="promoForm" id="promo-form">
                <input type="text" name="coupon" id="coupon" class="form-control" required>
                <div class="btn-toolbar">
                    <div class="btn-primary btn" id="apply-promo" name="applypromo">@lang('validation.attributes.apply promo')</div>
                </div>
            </form>
        </div>
        <div class="applied-promocode hidden">
            <p>Promocode '<span class="code"></span>' applied.</p>
            <p class="promocode-discount">Discount: <span class="promo-discount-value"></span>%</p>
            <p class="promocode-value">Discount: <span class="promo-value"></span> currency</p>
            <div class="btn-toolbar">
                <div class="btn-primary btn" id="remove-promo" name="removepromo">Remove promo code</div>
            </div>
        </div>
        <div class="promo-invalid alert alert-danger hidden">
            Your promo code is expired or invalid.
        </div>
    </div>

@endsection
