<div id="insertCombinationsApp" ng-controller="combinationController">
    <form id="comboForm" name="comboForm">
        <div class="form-group" data-ng-class="{'has-error' : comboForm[value.value].$invalid && (submitted || comboForm[value.value].$touched)}" ng-repeat="(key, value) in product.attributes">
            <label class="control-label" for="@{{value.value}}">@{{value.value}}</label>
            <select class="form-control"
                    name="@{{value.value}}"
                    id="@{{value.value}}"
                    ng-model="newCombination.attributes[value.id]"
                    ng-options="attr.id as attr.value for attr in value.items"
                    required>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label" for="newStock">Stock</label>
            <input class="form-control" type="text" name="newStock" id="newStock" ng-model="newCombination.stock">
        </div>
        <div class="form-group">
            <label class="control-label" for="newPrice">Price</label>
            <input class="form-control" type="text" name="newPrice" id="newPrice" ng-model="newCombination.price">
        </div>
        <div>
            <span class="multiSelect">
                <button type="button" ng-click="insert(comboForm.$valid)">@lang('products::global.attributes.insert')</button>
            </span>
            <span class="multiSelect">
                <button type="button" ng-click="cancel()">@lang('products::global.attributes.cancel')</button>
            </span>
        </div>
    </form>

</div>

<script>
    angular.bootstrap($('#insertCombinationsApp'), ['combinations']);
</script>
