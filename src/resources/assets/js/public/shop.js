// (function (angular) {

//     'use strict';

//     angular.module('promocode', ['ngResource']);

//     angular.module('promocode').controller('PromocodeController', ['$http', '$scope', '$location', '$resource', function ($http, $scope, $location, $resource) {

//         if(typeof TypiCMS !== 'undefined' && TypiCMS.promocode) {
//             $scope.promocode = TypiCMS.promocode;
//         }

//         $scope.checkCoupon = function(){
//             if($scope.promoForm.$valid){
//                 $resource('/api/coupons/process').get($scope.form).$promise.then(function (result) {
//                     $scope.promocode = result.promocode;
//                 }, function (err) {
//                     console.log(err);
//                 });
//             }
//         }
//     }]);

// }(angular));


$(function(){
    var loginForm = $("#shop-login-form");
    if (loginForm.length) {
        loginForm.submit(function(e){
            e.preventDefault();
            var formData = loginForm.serialize();

            $.ajax({
                url: loginForm.attr('action'),
                type:'POST',
                data:formData,
                success:function(data) {
                    if (data.authenticated) {
                        location.reload(true);
                    } else {
                        $('#login-error').html(data.message).show();
                    }
                },
                error: function (data) {
                    console.log(data);
                    $('#login-error').html('Internal server error').show();
                }
            });
        });
    }


    var registerForm = $("#shop-register-form");
    if (registerForm.length) {
        registerForm.submit(function(e){
            e.preventDefault();
            var formData = registerForm.serialize();

            $.ajax({
                url: registerForm.attr('action'),
                type:'POST',
                data:formData,
                success:function(data) {
                    if (data.registered) {
                        location.reload(true);
                    }
                },
                error: function (data) {
                    var msg = '';
                    for (k in data.responseJSON) {
                        msg += data.responseJSON[k][0] + '\n';
                    }

                    $('#register-error').html(msg).show();
                }
            });
        });
    }

    var attributeControls = $(".js-attribute");
    if (attributeControls.length && !Array.isArray(TypiCMS.combinations) ) {
        attributeControls.change(function(){
            var values = attributeControls.serializeArray();

            if (values.length == $('.js-attribute-group').length) {
                var selectedAttributes = [];
                for (attr in values) {
                    selectedAttributes.push(values[attr].value);
                }

                selectedAttributes.sort(function(a, b) { return a-b; });

                var currentCombination = null;
                if (currentCombination = TypiCMS.combinations[selectedAttributes.join(',')]) {
                    console.log('available - check price and quantity');
                    if (currentCombination.price > 0) {
                        $('.js-product-price').html(currentCombination.price);
                    } else {
                        $('.js-product-price').html(TypiCMS.currentProduct.price);
                    }
                } else {
                    $('.js-product-price').html(TypiCMS.currentProduct.price);
                    console.log('not available');
                }
                // console.log(selectedAttributes.join(','));
            } else {
                $('.js-product-price').html(TypiCMS.currentProduct.price);
                console.log('Select all attributes');
            }

        });
    }
});

