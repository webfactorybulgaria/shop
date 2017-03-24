@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection
<div ng-app="typicms">
@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::form._title-and-slug')

{!! TranslatableBootForm::text(trans('validation.attributes.meta_keywords'), 'meta_keywords') !!}
{!! TranslatableBootForm::text(trans('validation.attributes.meta_description'), 'meta_description') !!}

{!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->addClass('ckeditor') !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.description'), 'description')->addClass('ckeditor') !!}

{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
</div>