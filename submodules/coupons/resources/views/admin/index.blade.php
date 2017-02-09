@extends('core::admin.master')

@section('title', trans('coupons::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'coupons'])

    <h1>
        <span>@{{ totalModels }} @choice('coupons::global.coupons', 2)</span>
    </h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="couponsTable" st-table="displayedModels" st-order st-pipe="callServer" st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <td colspan="4" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                </tr>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="name" class="name st-sort">Name</th>
                    <th st-sort="code" class="code st-sort">Code</th>
                    <th st-sort="discount" class="discount st-sort">Discount (%)</th>
                    <th st-sort="starts_at" class="starts_at st-sort">Start Date:</th>
                    <th st-sort="expires_at" class="expires_at st-sort">Expiration Date:</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="name" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="code" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="discount" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td colspan="2"></td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'coupons'])
                    </td>
                    <td>@{{ model.name }}</td>
                    <td>@{{ model.code }}</td>
                    <td>@{{ model.discount }}</td>
                    <td>@{{ model.starts_at }}</td>
                    <td>@{{ model.expires_at }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                    <td>
                        <div ng-include="'/views/partials/pagination.itemsPerPage.html'"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
