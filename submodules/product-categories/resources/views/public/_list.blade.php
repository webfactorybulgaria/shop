<ul class="list-products">
    @foreach ($items as $product_category)
    @include('product-categories::public._list-item')
    @endforeach
</ul>
