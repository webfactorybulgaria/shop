{!! BootForm::hidden('product_categories')->value('') !!}
{!! BootForm::select(
        trans('validation.attributes.product_categories'),
        'product_categories[]',
        $model->product_categories->pluck('title', 'id')->all() + ProductCategories::getModel()->pluck('title', 'id')->all()
    )
    ->select($model->product_categories->pluck('id')->all())
    ->multiple(true)
    ->id('product_categories')
!!}