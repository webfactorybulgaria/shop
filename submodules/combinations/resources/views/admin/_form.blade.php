@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

{!! BootForm::text(trans('validation.attributes.product'), 'product_id') !!}
{!! BootForm::text(trans('validation.attributes.attributes'), 'attribute_combo') !!}
{!! BootForm::text(trans('validation.attributes.stock'), 'stock') !!}
{!! BootForm::text(trans('validation.attributes.price'), 'price') !!}
