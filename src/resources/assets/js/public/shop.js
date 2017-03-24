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

    $('#apply-promo').click(function(e){
        e.preventDefault();
        var formData,price,discount; 
        formData = { coupon : $('#coupon').val() };
        $.ajax({
            url: '/api/coupons/process',
            type:'GET',
            data:formData,
            success:function(data) {
                $('.promo-error').addClass('hidden');
                if (data.promocode && !data.promocode.expired && !data.promocode.overlimit) {
                    $('.code').text(data.promocode.code);
                    $('.applied-promocode').removeClass('hidden');
                    $('.ask-for-promo, .promo-invalid, .promo-overlimit').addClass('hidden');
                    if(data.promocode.value > 0){
                        $('.promocode-discount').addClass('hidden');
                        $('.promo-value').removeClass('hidden').text(data.promocode.value);                    
                    } else {
                        $('.promocode-value').addClass('hidden');
                        $('.promo-discount-value').removeClass('hidden').text(data.promocode.discount);                    
                    }
                    $('.total-price').text(data.price);
                    $('.total-discount').text(data.discount);
                    $('.total').text(data.total);
                }
                else {
                    if (data.promocode && data.promocode.overlimit) {
                        $('.ask-for-promo, .promo-overlimit').removeClass('hidden');
                    }
                    else {
                        $('.ask-for-promo, .promo-invalid').removeClass('hidden');
                    }
                    $('.applied-promocode').addClass('hidden');
                }
            },
            error: function (data) {
               $('.promo-error').removeClass('hidden').html(data.responseText);
            }
        });
    });

    $('#remove-promo').click(function(e){
        e.preventDefault();
        var formData = { coupon : $('#coupon').val()  };
        $.ajax({
            url: '/api/coupons/remove',
            type:'GET',
            data:formData,
            success:function(data) {
                if(data.removed) {
                    $('.applied-promocode').addClass('hidden');
                    $('.ask-for-promo').removeClass('hidden');
                    $('#coupon').val('');
                    $('.total-price').text(data.price);
                    $('.total-discount').text(data.discount);
                    $('.total').text(data.total);
                }
            },
            error: function (data) {
                console.log('Error! Could not remove promo code');
            }
        });
    });
});

