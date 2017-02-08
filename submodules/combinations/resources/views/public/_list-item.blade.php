<li>
    <a href="{{ route($lang.'.combinations.slug', $combination->slug) }}" title="{{ $combination->title }}">
        {!! $combination->title !!}
        {!! $combination->present()->thumb(null, 200) !!}
    </a>
</li>
