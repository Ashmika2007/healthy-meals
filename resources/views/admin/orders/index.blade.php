@extends('admin.layout')

@section('content')
<div class="p-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <h3 class="mb-4 fw-bold text-success">All Orders</h3>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())
    <div class="table-responsive shadow rounded bg-light p-3 border border-success">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-success text-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Meals</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr style="transition: background 0.3s;" onmouseover="this.style.background='#eafbea'" onmouseout="this.style.background='white'">
                    <td class="fw-semibold text-success">{{ $loop->iteration }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>
                        @if($order->items && $order->items->isNotEmpty())
                            @foreach($order->items as $item)
                                <span class="badge bg-info text-dark">{{ $item->meal->name ?? 'N/A' }} (x{{ $item->quantity }})</span><br>
                            @endforeach
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="fw-bold text-success">Rs {{ $order->total_price }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm me-1 mb-1">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash-alt me-1"></i>Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-center text-muted mt-4">No orders found.</p>
    @endif
</div>
@endsection
