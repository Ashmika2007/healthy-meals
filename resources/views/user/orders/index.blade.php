@extends('layouts.app')

@section('content')
<!-- Google Font: Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="container py-5" style="font-family: 'Poppins', sans-serif;">

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success text-center rounded-3 mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="mb-5 fw-bold text-center text-success">My Orders</h2>

    @forelse($orders as $order)
        <div class="card shadow-sm mb-5 rounded-4 border-0">
            <!-- Order Header -->
            <div class="card-header d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4" style="background-color:#e6f4ea;">
                <div>
                    <strong class="text-primary">Order #{{ $order->id }}</strong><br>
                    <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div>
                    <span class="badge 
                        {{ $order->status === 'pending' ? 'bg-warning text-dark' : ($order->status === 'approved' ? 'bg-success text-white' : 'bg-danger text-white') }}
                        py-2 px-3 fs-6 rounded-pill">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Order Meals -->
            <div class="card-body px-4 py-3">
                @if($order->items && $order->items->isNotEmpty())
                    @foreach($order->items as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 meal-item rounded-3 shadow-sm" style="background:#f1f9f3;">
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">{{ $item->meal->name ?? 'N/A' }}</h6>
                                <p class="mb-1 text-muted small">{{ $item->meal->description ?? '' }}</p>
                                <small class="text-secondary">Quantity: {{ $item->quantity }}</small>
                            </div>
                            <div class="fw-bold fs-6 text-primary">Rs {{ number_format($item->quantity * $item->price, 2) }}</div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end mt-3">
                        <h5 class="fw-bold text-success">Total: Rs {{ number_format($order->items->sum(fn($i) => $i->quantity * $i->price), 2) }}</h5>
                    </div>
                @else
                    <p class="text-muted mb-0">No items in this order.</p>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center rounded-4 shadow-sm">
            You don’t have any orders yet.
        </div>
    @endforelse
</div>

<style>
/* Card hover effect */
.card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
}

/* Meal item box */
.meal-item {
    border-radius: 12px;
    padding: 15px 20px;
    transition: 0.3s;
}
.meal-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Responsive spacing */
@media (max-width: 576px) {
    .meal-item {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection
