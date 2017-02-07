<div class="row">
    <div class="form-group col-sm-12">
        <button class="btn-primary btn" type="submit">@lang('validation.attributes.save')</button>
    </div>
</div>

<label>@lang('shop::global.attributes.shop_title')</label>
@foreach ($locales as $lang)
    <div class="row">
        <div class="col-sm-9 form-group">
            <div class="input-group">
                <span class="input-group-addon">{{ strtoupper($lang) }}</span>
                <input class="form-control" type="text" name="{{ $lang }}[shop_title]" value="@if(isset($preferences->$lang->shop_title)){{ $preferences->$lang->shop_title }}@endif">
            </div>
        </div>
        <div class="col-sm-3 checkbox">
            <label>
                <input type="hidden" name="{{ $lang }}[shop_status]" value="0">
                <input type="checkbox" name="{{ $lang }}[shop_status]" value="1" @if(isset($preferences->$lang->shop_status) and $preferences->$lang->shop_status)checked @endif> @lang('validation.attributes.online')
            </label>
        </div>
    </div>
@endforeach

<div class="row">
	<div class="col-sm-6 form-group">
	{!! BootForm::select(trans('shop::global.attributes.currency'), 'shop[shop_currency]', Currencies::all()->pluck('title', 'id')) !!}
	</div>
</div>