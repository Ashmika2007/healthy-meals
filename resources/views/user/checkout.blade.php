@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <!-- Checkout Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-3 rounded-top-4">
                    <h2 class="mb-0">Checkout</h2>
                </div>
                <div class="card-body p-4">
                    <!-- Order Summary -->
                    <h4 class="fw-bold mb-3">Order Summary</h4>
                    <ul class="list-group mb-4">
                        @php $total = 0; @endphp
                        @foreach($cart as $mealId => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item['name'] }}</strong> x {{ $item['quantity'] }}
                                <small class="text-muted d-block">{{ $item['description'] ?? '' }}</small>
                            </div>
                            <span>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </li>
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>₹{{ number_format($total,2) }}</span>
                        </li>
                    </ul>

                    <!-- Payment Info -->
                    <h4 class="fw-bold mb-3">Payment Information</h4>
                    <form action="{{ route('user.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" name="card_number" id="card_number" class="form-control form-control-lg" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry" class="form-label">Expiry</label>
                                <input type="text" name="expiry" id="expiry" class="form-control form-control-lg" placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" name="cvv" id="cvv" class="form-control form-control-lg" placeholder="123" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card hover effect */
.card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
}

/* List group item styling */
.list-group-item {
    border: none;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 10px;
    background: #f8f9fa;
}
.list-group-item:last-child {
    margin-bottom: 0;
}
</style>
@endsection
