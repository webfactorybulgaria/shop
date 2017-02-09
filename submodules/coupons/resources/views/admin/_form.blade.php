@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

{!! BootForm::text(trans('validation.attributes.code'), 'code') !!}
{!! BootForm::text(trans('validation.attributes.sku'), 'sku') !!}
{!! BootForm::text(trans('validation.attributes.value'), 'value') !!}
{!! BootForm::text(trans('validation.attributes.discount'), 'discount') !!}
{!! BootForm::text(trans('validation.attributes.name'), 'name') !!}
{!! BootForm::text(trans('validation.attributes.description'), 'description') !!}
{!! BootForm::text(trans('validation.attributes.starts_at'), 'starts_at') !!}
{!! BootForm::text(trans('validation.attributes.expires_at'), 'expires_at') !!}
