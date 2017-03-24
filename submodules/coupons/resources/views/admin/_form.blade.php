@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

{!! BootForm::text(trans('coupons::global.attributes.code'), 'code') !!}
<button class="btn-default btn" id="generateCoupon" type="button">@lang('validation.attributes.generate')</button>
<button class="btn-default btn" id="clearCoupon" type="button">@lang('validation.attributes.clear')</button>
<br />
<br />
{!! BootForm::text(trans('coupons::global.attributes.sku'), 'sku') !!}
{!! BootForm::text(trans('coupons::global.attributes.value'), 'value') !!}
{!! BootForm::text(trans('coupons::global.attributes.discount'), 'discount') !!}
{!! BootForm::text(trans('coupons::global.attributes.name'), 'name') !!}
{!! BootForm::text(trans('coupons::global.attributes.description'), 'description') !!}
{!! BootForm::text(trans('coupons::global.attributes.total_available'), 'total_available') !!}
{!! BootForm::text(trans('coupons::global.attributes.total_available_user'), 'total_available_user') !!}
<div class="row">
    <div class="col-sm-3">
		{!! BootForm::date(trans('coupons::global.attributes.starts_at'), 'starts_at')->value(old('starts_at') ? : $model->present()->dateOrNow('starts_at'))->addClass('datepicker') !!}
	</div>
</div>
<div class="row">
    <div class="col-sm-3">
		{!! BootForm::date(trans('coupons::global.attributes.expires_at'), 'expires_at')->value(old('expires_at') ? : $model->present()->dateOrNow('expires_at'))->addClass('datepicker') !!}
	</div>
</div>