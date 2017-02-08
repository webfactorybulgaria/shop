@extends('core::admin.master')

@section('title', trans('combinations::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'combinations'])
    <h1>
        @lang('combinations::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-combinations'))->multipart()->role('form') !!}
        @include('combinations::admin._form')
    {!! BootForm::close() !!}

@endsection
