@extends('core::admin.master')

@section('title', trans('shop::global.name'))

@section('main')

<h1>@lang('shop::global.preferences')</h1>

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::open() !!}
        {!! BootForm::bind($preferences) !!}

            @include('shop::admin._form-preferences')

        {!! BootForm::close() !!}
    </div>
    <div class="col-sm-6">

    </div>
</div>

@endsection
