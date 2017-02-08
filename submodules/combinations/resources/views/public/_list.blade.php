<ul class="list-combinations">
    @foreach ($items as $combination)
    @include('combinations::public._list-item')
    @endforeach
</ul>
