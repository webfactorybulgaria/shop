@extends('core::admin.master')

@section('title', trans('combinations::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'combinations'])

    <h1>
        <span>@{{ models.length }} @choice('combinations::global.combinations', 2)</span>
    </h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="combinationsTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="attribute_combo" class="attribute_combo st-sort">Attributes</th>
                    <th st-sort="stock" class="stock st-sort">Stock</th>
                    <th st-sort="price" class="price st-sort">Price</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="attribute_combo" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="stock" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="price" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'combinations'])
                    </td>
                    <td>@{{ model.attribute_combo }}</td>
                    <td>@{{ model.stock }}</td>
                    <td>@{{ model.price }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
