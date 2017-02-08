@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::select(trans('products::global.attributes.currency'), 'currency', Currencies::all()->pluck('title')) !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::text(trans('products::global.attributes.starting at'), 'starting_at')->value('1') !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(trans('products::global.attributes.specific price'), 'specific_price')->value($product->price) !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::hidden('specific_price_status')->value(0) !!}
        {!! BootForm::checkbox(trans('products::global.attributes.specific price'), 'specific_price_status') !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(trans('products::global.attributes.discount'), 'discount') !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::select(trans('products::global.attributes.discount type'), 'discount_type', ['percent', 'currency unit']) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(trans('products::global.attributes.date from'), 'date_from') !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::text(trans('products::global.attributes.date to'), 'date_to') !!}
    </div>
</div>
