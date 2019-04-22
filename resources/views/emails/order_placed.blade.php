@component('mail::message')
# ORDER CONFIRMATION

<img src="http://eos-ksa.com/images/rsos-2019-site-logo.png" alt="RSOS 2019">
<h3>you have been successfully subscribed to the following events using your credit card (VISA) ending with (***0).</h3>
@component('mail::table')
| #      | Item          | Description                      | Price    |
|:------:|:--------------|:---------------------------------| --------:|
@foreach ($order->items as $item)
    @php
        $i = $loop->index;
        $t = title_case($item->item_type);
        $n = $item->item_name;
        $p = 'SAR '.$item->item_price;
    @endphp
|{{ $i }}| {{ $t }}      | {{ $n }}                         | {{ $p }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => route('order-print', ['order' => $order])])
PRINT YOUR RECEIPT
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent