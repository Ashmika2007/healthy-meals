@extends('admin.layout')

@section('content')
<div class="p-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <h3 class="mb-3 fw-bold text-success">Order Details - #{{ $order->id }}</h3>

    <div class="mb-3">
        <p><strong class="text-success">User:</strong> <span class="fw-semibold">{{ $order->user->name ?? 'No User' }}</span></p>
        <p><strong class="text-success">Status:</strong> 
            <span class="badge 
                {{ $order->status == 'pending' ? 'bg-warning text-dark' : ($order->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    <h4 class="mb-2 text-primary">Items</h4>
    <div class="table-responsive shadow rounded bg-light p-3 border border-success">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-success text-dark">
                <tr>
                    <th>Meal</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if($order->items && $order->items->isNotEmpty())
                    @foreach($order->items as $item)
                        <tr style="transition: background 0.3s;" onmouseover="this.style.background='#eafbea'" onmouseout="this.style.background='white'">
                            <td class="fw-semibold text-success">{{ $item->meal->name ?? 'No Meal' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs {{ $item->price }}</td>
                            <td>Rs {{ $item->quantity * $item->price }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center text-muted">No items in this order.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <p class="mt-3"><strong class="text-success">Total:</strong> <span class="fw-bold text-success">Rs {{ $order->items->sum(fn($i) => $i->quantity * $i->price) }}</span></p>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary shadow-sm mt-2">Back</a>
</div>
@endsection
