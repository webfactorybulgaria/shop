<li>
    <a href="{{ route($lang.'.product-categories.slug', $product_category->slug) }}" title="{{ $product_category->title }}">
        {!! $product_category->title !!}
        {!! $product_category->present()->thumb(null, 200) !!}
    </a>
</li>