<div onload="alert('asd')" ng-app="promocode" ng-controller="PromocodeController">
	<div ng-show="!promocode">
		Have a promocode?

		<form name="promoForm">
		    <input type="text" name="coupon" id="coupon" class="form-control" ng-model="form.coupon" required>

			<div class="btn-toolbar">
			    <div class="btn-primary btn" id="apply-promo" ng-click="checkCoupon()" name="applypromo">@lang('validation.attributes.apply promo')</div>
			</div>
		</form>
	</div>
	<div ng-show="promocode">
		<p>Promocode @{{promocode.code}} applied.</p>
		<p ng-show="promocode.discount > 0">Discount: @{{promocode.discount}}%</p>
		<p ng-show="promocode.value > 0">Discount: @{{promocode.value}} currency</p>
	</div>
</div>