@extends('layouts.app')
<livewire:cart-component />


@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Cart</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
        <p>Your cart is empty.</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-3">Back to Meals</a>
    @else
        @php $grandTotal = 0; @endphp
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Meal</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $mealId => $item)
                    @php
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rs. {{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('user.cart.update') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="meal_id" value="{{ $mealId }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm me-2" style="width:80px;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>Rs. {{ number_format($total, 2) }}</td>
                        <td>
                            <form action="{{ route('user.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="meal_id" value="{{ $mealId }}">
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Grand Total</th>
                    <th>Rs. {{ number_format($grandTotal, 2) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex gap-2">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Meals</a>

            {{-- Checkout Button --}}
            <form action="{{ route('user.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        </div>
    @endif
</div>
@endsection
