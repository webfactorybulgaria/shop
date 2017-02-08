<ul class="list-products">
    @foreach ($items as $product)
    @include('products::public._list-item')
    @endforeach
</ul>
