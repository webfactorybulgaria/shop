(function (angular) {

    'use strict';

    angular.module('promocode', ['ngResource']);

    angular.module('promocode').controller('PromocodeController', ['$http', '$scope', '$location', '$resource', function ($http, $scope, $location, $resource) {

        if(typeof TypiCMS !== 'undefined' && TypiCMS.promocode) {
            $scope.promocode = TypiCMS.promocode;
        }

        $scope.checkCoupon = function(){
            if($scope.promoForm.$valid){
                $resource('/api/coupons/process').get($scope.form).$promise.then(function (result) {
                    $scope.promocode = result.promocode;
                }, function (err) {
                    console.log(err);
                });
            }
        }
    }]);

}(angular));


$(function(){
    var loginForm = $("#shop-login-form");
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


    var registerForm = $("#shop-register-form");
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

    $('#apply-promo').click(function(e){
        e.preventDefault();
        var formData = { coupon : $('#coupon').val() };
        $.ajax({
            url: '/api/coupons/process',
            type:'GET',
            data:formData,
            success:function(data) {
                if (data.promocode) {
                    $('.code').text(data.promocode.code);
                    $('.applied-promocode').removeClass('hidden');
                    $('.ask-for-promo, .promo-invalid').addClass('hidden');
                    $('.promo-discount-value').text(data.promocode.discount);
                    $('.promo-value').text(data.promocode.value);
                }
                else {
                    $('.ask-for-promo, .promo-invalid').removeClass('hidden');
                    $('.applied-promocode').addClass('hidden');
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $('#remove-promo').click(function(e){
        e.preventDefault();
        var formData = {};
        $.ajax({
            url: '/api/coupons/remove',
            type:'GET',
            data:formData,
            success:function(data) {
                console.log(data);
            },
            error: function (data) {
                console.log(error);
            }
        });
    });
});
