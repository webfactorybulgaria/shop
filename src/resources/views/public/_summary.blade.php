@foreach($cart->items as $item)
<div class="row">
    <br />
    <br />
    <div class="col-md-6">Product: </div>
    @if ($item->reference_id)
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
    @else
    <div class="col-md-6">
        Coupon '{{ $item->sku }}'
    </div>
    @endif

    @if ($item->reference_id)
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
    @else
        <div class="col-md-6">Discount: {{ abs($item->price) }} </div>
    @endif

</div>
@endforeach

<hr>
<p>@lang('db.Discount:') <span class="total-discount">{{ isset($discount) ? $discount : $cart->displayTotalDiscount }}</span></p>
<p>@lang('db.Price:') <span class="total-price">{{ $cart->displayTotalPrice }}</span></p>
<p>@lang('db.Tax:') {{ $cart->displayTotalTax }}</p>
<p>@lang('db.Shipping:') {{ $cart->displayTotalShipping }}</p>
<hr>
<p>@lang('db.Total Price:') <span class="total">{{ $cart->displayTotal }}</span></p>