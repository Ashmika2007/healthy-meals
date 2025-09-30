@foreach($orders as $order)
<tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
    <td>
        Rs 
        {{
            number_format(
                $order->items->sum(function($item) {
                    return $item->price * $item->quantity;
                }),
            2)
        }}
    </td>
    <td>
        <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : 'bg-success' }}">
            {{ ucfirst($order->status) }}
        </span>
    </td>
</tr>
@endforeach
