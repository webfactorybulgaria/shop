@extends('core::admin.master')

@section('title', trans('shop::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Orders</h2>
                </div>
                <div class="table-responsive">
                    <table st-persist="ordersTable" st-table="displayedModels" st-order st-sort-default="created_at" st-sort-default-reverse="true" st-pipe="callServer" st-filter class="table table-condensed table-main">
                        <thead>
                            <tr>
                                <td colspan="5" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                            </tr>
                            <tr>
                                <th st-sort="id" class="status st-sort">Order #</th>
                                <th st-sort="created_at" class="created_at st-sort">Created</th>
                                <th st-sort="statusCode" class="statusCode st-sort">Status</th>
                                <th st-sort="price" class="price st-sort">Price</th>
                                <th class="url st-sort">URL</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <datepicker date-format="yyyy-MM-dd" class="filter-date">
                                        <input type="text" st-search="created_at.date.filter_from" class="form-control input-sm" placeholder="From date…">
                                    </datepicker>
                                    <datepicker date-format="yyyy-MM-dd" class="filter-date">
                                        <input type="text" st-search="created_at.date.filter_to" class="form-control input-sm" placeholder="To date…">
                                    </datepicker>
                                </td>
                                <td>
                                    <select class="form-control" st-input-event="change keydown" st-search="statusCode">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="model in displayedModels">
                                <td>@{{ model.id }}</td>
                                <td>@{{ model.created_at }}</td>
                                <td>@{{ model.statusCode }}</td>
                                <td>@{{ model.displayTotal }}</td>
                                <td><a href="orders/@{{ model.id }}">View order</a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                                <td>
                                    <div ng-include="'/views/partials/pagination.itemsPerPage.html'"></div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
