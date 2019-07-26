<tr>
    <td scope="row">
        <a href="{{ route('order-print', ['order' => $order->id]) }}" target="_blank"><i class="fa fa-print"></i></a>
    </td>
    <td>{{ $order->created_at->format('F j, Y') }}</td>
    <td>{{ $order->subtotal }}</td>
    <td>{{ $order->vat }}</td>
    <td>{{ $order->amount }}</td>
    <td><i class="fa {{ $order->status ? 'fa-check-square-o' : 'fa-square-o' }}"></i></td>
</tr>