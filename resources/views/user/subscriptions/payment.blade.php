@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Payment — {{ $plan['name'] }}</h3>
    <p>Amount: Rs {{ number_format($plan['price'], 2) }}</p>

    <form method="POST" action="{{ route('subscriptions.process', $planKey) }}">

        @csrf
        <div class="mb-3">
            <label>Card Number</label>
            <input name="card_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Expiry (MM/YY)</label>
            <input name="expiry_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>CVV</label>
            <input name="cvv" class="form-control" required>
        </div>
        <button class="btn btn-success">Pay & Subscribe</button>
    </form>
</div>
@endsection
