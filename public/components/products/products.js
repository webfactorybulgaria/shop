//---------------------default app-----------------------------------------------
var products = angular.module( 'products', [ 'isteven-multi-select', 'ngResource' ]);

angular.module('products')

.factory('$api', ['$resource', function ($resource) {
    return $resource('/api/combinations/:id', null, {
        update: {
            method: 'PUT'
        }
    });
}])

.factory('$prod', ['$resource', function ($resource) {
    return $resource('/api/products/:id', null, {
        update: {
            method: 'PUT'
        }
    });
}])

.directive('changeOnBlur', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function(scope, elm, attrs, ngModelCtrl) {
            if (attrs.type === 'radio' || attrs.type === 'checkbox')
                return;

            var expressionToCall = attrs.changeOnBlur;

            var oldValue = null;
            elm.bind('focus',function() {
                scope.$apply(function() {
                    oldValue = elm.val();
                });
            })
            elm.bind('blur', function() {
                scope.$apply(function() {
                    var newValue = elm.val();
                    if (newValue !== oldValue){
                        scope.$eval(expressionToCall);
                    }
                });
            });
        }
    };
})

.controller('productController', ['$scope', '$api', '$prod', '$resource', '$filter', function ($scope, $api, $prod, $resource, $filter) {
    var combinationResource = $resource('/api/products/combinations/:byProduct', null, {});
    var attributeResource = $resource('api/attribute-groups/:id', null, {});

    $scope.outputValues = [];
    $scope.errors = {};
    $scope.loading = false;
    $scope.defaultStock = 0;

    $scope.TypiCMS = TypiCMS;
    $scope.product = loadProduct(TypiCMS.product);
    $scope.attributes = loadAttributes(TypiCMS.attributes);
    $scope.combinations = loadCombinations(TypiCMS.combinations);

    var selectizeHandler = function(value) {
        var selectizeControl = $('#attributes')[0].selectize;
        var request = {};
        request.id = $scope.product.id;
        request.attributes = selectizeControl.items.join();

        $prod.update({id:request.id}, request).$promise.then(
            function (updateResponse) {
                if(updateResponse.error == false) {
                    $prod.get({id:$scope.product.id}).$promise.then(
                        // alertify.success('Atrributes have been updated');
                        function (getResponse) {
                            if(getResponse.error == false) {
                                $scope.outputValues = [];
                                $scope.product = loadProduct(getResponse.product);
                                var delRequest = {};
                                delRequest.delete = true;
                                delRequest.product = $scope.product.id;
                                combinationResource.save(delRequest).$promise.then(
                                    function (deleteResponse) {
                                        if(deleteResponse.error == false) {
                                            getNewCombinations({byProduct:$scope.product.id});
                                        }
                                    },
                                    function (deleteReason) {
                                        $scope.loading = false;
                                        alertify.error('Error ' + deleteReason.error.statusText);
                                    }
                                );
                                alertify.success('Atrributes have been updated');
                            } else {
                                alertify.error('Error with updating attributes');
                            }
                        },
                        function (getReason) {
                            alertify.error('Error with updating attributes');
                        }
                    );
                } else {
                    alertify.error('Error with updating attributes');
                }
            },
            function (updateReason) {
                alertify.error('Error with updating attributes');
            }
        );
    };
    $('#attributes').on('change', selectizeHandler);

    angular.element('#fancybox-insert').fancybox({
        type: 'ajax',
        afterClose: function(resp){
            getNewCombinations({byProduct:$scope.product.id});
        }
    });

    $scope.formatPrice = function(key) {
        var num = parseInt($scope.combinations[key].price);
        $scope.combinations[key].price = num.toFixed(2);
    }

    $scope.delete = function(key, combination) {
        $scope.combinations[key].deleting = true;
        $api.delete(combination).$promise.then(
            function (deleteResponse) {
                if(deleteResponse.error == false) {
                    getNewCombinations({byProduct:$scope.product.id});
                    alertify.success('Combination has been deleted');
                }
            },
            function (deleteReason) {
                delete $scope.combinations.deleting;
                alertify.error('Error ' + deleteReason.error.statusText);
            }
        );
    }

    $scope.save = function(id) {
        $api.update($scope.combinations[id]).$promise.then(
            function (response) {
                if(!response.error) {
                    alertify.success('Item is updated.');
                } else {
                    alertify.error('Error ' + response.errorText);
                }
            },
            function (reason) {
                alertify.error('Error ' + reason.error.statusText);
            }
        );
    }

    $scope.generate = function() {
        var combinationsRaw = [];
        $scope.errors.attr_required = false;

        $scope.outputValues.forEach(function(value, key){
            if(!value.length){
                $scope.errors.attr_required = true;
            }
        });

        if(!$scope.errors.attr_required) {
            $scope.loading = true;
            combinationsRaw = generateCombinations($scope.outputValues);

            if(combinationsRaw.length) {
                var request = {};
                request.defaultStock = $scope.defaultStock;
                request.combos = combinationsRaw;
                request.product = $scope.product.id;

                combinationResource.save(request).$promise.then(
                    function (storeResponse) {
                        if(storeResponse.error == false) {
                            getNewCombinations({byProduct:$scope.product.id});
                        }
                    },
                    function (storeReason) {
                        $scope.loading = false;
                        alertify.error('Error ' + storeReason.error.statusText);
                    }
                );
            } else {
                $scope.loading = false;
            }
        }
    }

    function getNewCombinations(request) {
        combinationResource.get(request).$promise.then(
            function (getResponse) {
                $scope.loading = false;
                if(!getResponse.error) {
                    $scope.combinations = loadCombinations(getResponse.models);
                    // alertify.success('Combinations have been generated');
                } else {
                    alertify.error('Error ' + getResponse.errorText);
                }
            },
            function (getReason) {
                $scope.loading = false;
                alertify.error('Error ' + getReason.error.statusText);
            }
        );
    }

    function generateCombinations(outputValues) {
        var inputAttrs = [];
        var level = 0;

        (function gen(level) {
            if(level < outputValues.length) {
                angular.forEach( outputValues[level], function(attr) {
                    if(typeof inputAttrs[level] == 'undefined') inputAttrs[level] = [];
                    inputAttrs[level].push(attr.id);
                });
                level++;
                gen(level);
            } else {
                return;
            }
        })(level);

        if (!inputAttrs.length) {
            $scope.errors.attr_required = true;
        } else {
            for (var i = 0; i < inputAttrs.length; i++) {
                if(typeof inputAttrs[i] == 'undefined'){
                    $scope.errors.attr_required = true;
                }
            }
        }

        if(!$scope.errors.attr_required){
            return Combinatorics.cartesianProduct(...inputAttrs).toArray();
        } else {
            return [];
        }
    }

    function loadProduct(product){
        if(product && product.attributes) {
            product.attributes.forEach(function(val){
                val.items.forEach(function(v){
                    if(val.type == 'colorbox') {
                        v.label = v.value+'<span style="position: absolute;border:1px solid gray;width: 90px;height: 25px;background-color:'+v.value+';top: 1px;left: 185px;"></span>';
                        v.btn_label = '<span style="border:1px solid gray;background-color:'+v.value+';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                    } else {
                        v.label = v.value;
                        v.btn_label = v.value;;
                    }
                });
            });
            return product;
        } else {
            return {};
        }
    }

    function loadCombinations(combinations) {
        if(combinations) {
            var list = {};
            combinations.forEach(function(value, key){
                list[value.id] = value;
                list[value.id].attrs = value.attribute_combo.split(',');
            });
            return list;
        } else {
            return {};
        }
    }

    function loadAttributes(attributes) {
        if(attributes) {
            var list = {};
            attributes.forEach(function(value, key){
                list[value.id] = value;
            });
            return list;
        } else {
            return {};
        }
    }
}]);

//---------------------insert popup app-----------------------------------------------

var combinations = angular.module( 'combinations', [ 'isteven-multi-select', 'ngResource' ]);

angular.module('combinations')

.controller('combinationController', ['$scope', '$resource', '$filter', function ($scope, $resource, $filter) {
    var api = $resource('/api/combinations/:id', null, {});

    $scope.submitted = false;
    $scope.errors = {};
    $scope.newCombination = {};
    $scope.newCombination.attributes = {};
    $scope.newCombination.stock = 0;
    $scope.newCombination.price = 0;
    $scope.showInsertButton = true;
    $scope.showInsertFields = false;
    $scope.product = TypiCMS.product ? TypiCMS.product : {} ;

    $scope.attributes = loadAttributes(TypiCMS.attributes);
    $scope.combinations = loadCombinations(TypiCMS.combinations);

    $scope.insert = function(valid) {
        $scope.submitted = true;
        if(valid){
            var request = {};
            var attrArr = [];
            angular.forEach($scope.newCombination.attributes, function(value, key){
                attrArr.push(value);
            });
            request.attribute_combo = attrArr.reverse().join();
            request.product_id = $scope.product.id;
            request.stock = $scope.newCombination.stock;
            request.price = $scope.newCombination.price;
            api.save(request).$promise.then(
                function (response) {
                    if(!response.error) {
                        resetInsert();
                        $scope.combinations = loadCombinations(response.models);
                        alertify.success('Combination added.');
                    } else {
                        alertify.error('Error ' + response.errorText);
                    }
                },
                function (reason) {
                    alertify.error('Error ' + reason.errorText);
                }
            );
        }
    }

    $scope.cancel = function() {
        resetInsert();
    }

    $scope.formatPrice = function(key) {
        var num = parseInt($scope.combinations[key].price);
        $scope.combinations[key].price = num.toFixed(2);
    }

    function resetInsert() {
        $scope.submitted = false;
        $scope.newCombination.attributes = {}
        $scope.newCombination.stock = 0;
        $scope.newCombination.price = 0;
        $scope.showInsertFields = false;
        $scope.showInsertButton = true;
        angular.forEach($scope.product.attributes, function(value, key){
            $scope.comboForm[value.value].$setUntouched();
        });
        $.fancybox.close();
    }

    function loadCombinations(combinations) {
        if(combinations) {
            var list = {};
            combinations.forEach(function(value, key){
                list[value.id] = value;
                list[value.id].attrs = value.attribute_combo.split(',');
            });
            return list;
        } else {
            return {};
        }
    }

    function loadAttributes(attributes) {
        if(attributes) {
            var list = {};
            attributes.forEach(function(value, key){
                list[value.id] = value;
            });
            return list;
        } else {
            return {};
        }
    }
}]);
