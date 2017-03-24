    <div>
        <div class="ask-for-promo @if(session()->has('coupon')) hidden @endif">
            <span>@lang('db.Have a promocode?')</span>
            <form name="promoForm" id="promo-form">
                <input type="text" name="coupon" id="coupon" class="form-control" required>
                <div class="btn-toolbar">
                    <div class="btn-primary btn" id="apply-promo" name="applypromo">@lang('validation.attributes.apply promo')</div>
                </div>
            </form>
        </div>

        <div class="applied-promocode @if(!session()->has('coupon')) hidden @endif">
            <p>Promocode '<span class="code">@if(session()->has('coupon')){{ session()->get('coupon')->code }}@endif</span>' applied.</p>
            <p class="promocode-value {{ session()->has('coupon') && session()->get('coupon')->value == 0 ? 'hidden' : '' }}">
                Discount: <span class="promo-value">@if(session()->has('coupon')) {{ session()->get('coupon')->value }} @endif</span> currency
            </p>
            <p class="promocode-discount {{ session()->has('coupon') && session()->get('coupon')->value > 0 ? 'hidden' : '' }}">
                Discount: <span class="promo-discount-value">@if(session()->has('coupon')) {{ session()->get('coupon')->discount }} @endif</span>%
            </p>
            <div class="btn-toolbar">
                <div class="btn-primary btn" id="remove-promo" name="removepromo">Remove promo code</div>
            </div>
        </div>
        <div class="promo-invalid alert alert-danger hidden">
            @lang('db.Your promo code is expired or invalid')
        </div>
         <div class="promo-overlimit alert alert-danger hidden">
            @lang('db.Your promo code value is greater than the base price of the order!')
        </div>
        <div class="promo-error alert alert-danger hidden"></div>
    </div>