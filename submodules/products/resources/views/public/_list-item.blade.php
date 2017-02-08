<li>
    <a href="{{ route($lang.'.products.slug', $product->slug) }}" title="{{ $product->title }}">
        {!! $product->title !!}
        {!! $product->present()->thumb(null, 200) !!}
    </a>
</li>
