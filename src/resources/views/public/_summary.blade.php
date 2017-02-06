@foreach($cart->items as $item)
<div class="row">
    <div class="col-md-6">Product: </div>
    <div class="col-md-6">
        {{ $item->product }}
        @if(!empty($item->readableAttributes))
        (
            @foreach($item->readableAttributes as $group => $attribute)
                {{$group}}: {{$attribute}},
            @endforeach
        )
        @endif
    </div>
    <div class="col-md-6">SKU: </div>
    <div class="col-md-6">{{ $item->sku }}</div>

    <div class="col-md-6">Price: </div>
    <div class="col-md-6">{{ $item->currency }} {{ $item->price }}</div>

    <div class="col-md-6">Tax: </div>
    <div class="col-md-6">{{ $item->price }}</div>

    <div class="col-md-6">Quantity: </div>
    @if(!empty($canEdit))
        <div class="col-md-1">{{ $item->quantity }}</div>
        <div class="col-md-5">
            <a href="{{route(config('app.locale') . '.shop.add', [$item->id, 1])}}" class="btn btn-success">Add 1</a>
            <a href="{{route(config('app.locale') . '.shop.remove', [$item->id, 1])}}" class="btn btn-danger">Remove 1</a>
            <a href="{{route(config('app.locale') . '.shop.remove', $item->id)}}" class="btn btn-danger">Remove ALL</a>
        </div>
    @else
        <div class="col-md-6">{{ $item->quantity }}</div>
    @endif
</div>
@endforeach

<hr>
<p>@lang('db.Discount:') {{ $cart->displayTotalDiscount }}</p>
<p>@lang('db.Price:') {{ $cart->displayTotalPrice }}</p>
<p>@lang('db.Tax:') {{ $cart->displayTotalTax }}</p>
<p>@lang('db.Shipping:') {{ $cart->displayTotalShipping }}</p>
<hr>
<p>@lang('db.Total Price:') {{ $cart->displayTotal }}</p>