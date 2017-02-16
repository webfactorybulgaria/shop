@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('components/products/isteven-multi-select.js') }}"></script>
    <script src="{{ asset('components/products/products.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('components/products/isteven-multi-select.css') }}">
    <style>
        .color-attribute {
            display: inline-block;
            width: 30px;
            height: 30px;
            padding: 0 3px;
            vertical-align: middle;
            border: 1px solid gray;
        }

        .attribute-with-color {
            display: inline-block;
            width: 55px;
        }
    </style>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

<ul class="nav nav-tabs">
    <li>
        <a href="#tab-content" data-target="#tab-content" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-settings" data-target="#tab-settings" data-toggle="tab">@lang('global.Settings')</a>
    </li>
    <li class="active">
        <a href="#tab-combinations" data-target="#tab-combinations" data-toggle="tab">@lang('products::global.Combinations')</a>
    </li>
</ul>

<div class="tab-content" ng-app="products" ng-controller="productController">

    <div class="tab-pane fade" id="tab-content">
        @include('core::admin._image-fieldset', ['field' => 'image'])

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}
    </div>

    <div class="tab-pane fade" id="tab-settings">
        <div class="row">
            <div class="col-sm-6">
                <h2>Base Product Settings</h2>
                <i>Here you can define the base price rules for this product. It will be used, if no specific price rules are applied</i>
                <div class="row">
                    <div class="col-sm-6">
                    {!! BootForm::text(trans('products::global.attributes.sku'), 'sku') !!}
                    </div>
                    <div class="col-sm-3">
                    {!! BootForm::text(trans('products::global.attributes.stock'), 'stock') !!}
                    </div>
                    <div class="col-sm-3">
                    {!! BootForm::text(trans('products::global.attributes.price'), 'price') !!}
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6">
                    {!! BootForm::text(trans('products::global.attributes.tax'), 'tax') !!}
                    </div>
                     <div class="col-sm-6">
                    {!! BootForm::text(trans('products::global.attributes.shipping'), 'shipping') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h2>Specific Product Prices</h2>
                <i>Here you can set specific price rules for clients using different currencies, etc.</i>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">

                        </div>
                        List with all specific rules goes here
                        <br>
                        @if(!empty($model->prices))
                            @foreach($model->prices as $price)
                            {{$price}}
                            <br>
                            <a href="{{ route('admin::edit-productprice', [$model->id, $price->id]) }}">Edit</a>
                            <hr>
                            @endforeach
                        @endif
                        <br>
                        <br>
                        <a class="btn-primary btn" href="{{ route('admin::create-productprice', $model->id) }}">@lang('products::global.attributes.add_new_price_rule')</a>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade in active" id="tab-combinations">
        <div class="row">
            <div class="col-sm-12">
                {!! BootForm::text(trans('products::global.attributes.attributes'), 'attributes')->value(old('attributes') ? : implode(', ', $model->attributes->pluck('value')->all())) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div ng-repeat="(key, value) in product.attributes" >
                            <div class="form-group">
                                <label class="isteven-label" style="display: block;" ng-bind="value.value"></label>
                                <isteven-multi-select
                                    input-model="value.items"
                                    output-model="outputValues[key]"
                                    button-label="btn_label"
                                    item-label="label"
                                    tick-property="ticked"
                                >
                                </isteven-multi-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="defaultStock">@lang('products::global.attributes.defaultStock')</label>
                            <input class="form-control" type="text" ng-model="defaultStock">
                        </div>
                        <div class="form-group">
                            <span ng-if="product.attributes" class="multiSelect inlineBlock">
                                <button type="button" ng-click="generate()" ng-disabled="loading">@lang('products::global.attributes.generate')</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">{{-- right 2 --}}</div>
                </div>
                <div ng-show="errors.attr_required" class="has-error"><label class="control-label" ng-bind="'Please select at least one of each attribute groups'"></label></div>
            </div>
            <div class="col-sm-6">
                <table class="table table-striped">
                    <tr>
                        <th>Combination</th>
                        <th style="width: 100px;">Stock</th>
                        <th style="width: 100px;">Price</th>
                        <th style="width: 50px;"></th>
                    </tr>

                    <tr ng-repeat="(key, combination) in combinations">
                        <td style="line-height: 34px;">
                            <span ng-repeat="attr in combination.attrs">
                                <span ng-show="attributes[attr].attribute_group.type == 'colorbox'" class="color-attribute" style="background-color: @{{ attributes[attr].value }}"></span>
                                <span ng-bind="attributes[attr].value" ng-class="{'attribute-with-color' : attributes[attr].attribute_group.type == 'colorbox'}"></span>
                                <span ng-hide="$last"><span ng-hide="attributes[attr].attribute_group.type == 'colorbox'">&nbsp;&nbsp;</span>-&nbsp;&nbsp;</span>
                            </span>
                        </td>
                        <td>
                            <input class="form-control" type="text" ng-model="combinations[key].stock" change-on-blur="save(key)">
                        </td>
                        <td>
                            <input class="form-control" type="text" ng-model="combinations[key].price" change-on-blur="save(key)" ng-blur="formatPrice(key)">
                        </td>
                        <td style="line-height: 33px;">
                            <div ng-hide="combination.deleting" ng-click="delete(key, combination)" class="btn btn-xs btn-link" style="font-size: 17px;">
                                <span class="fa fa-remove"></span>
                                <span class="sr-only">Delete</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <div>
                    <span class="multiSelect inlineBlock">
                        <button type="button" id="fancybox-insert" href="{{ route('api::loadPopup-combinations') }}">@lang('products::global.attributes.add_field')</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
