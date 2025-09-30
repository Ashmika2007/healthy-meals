@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Page</h2>

    @if(isset($meal))
        <p>Buying <strong>{{ $meal->name }}</strong> for ${{ $meal->price }}</p>
        <form action="{{ route('user.processPayment') }}" method="POST">
            @csrf
            <input type="hidden" name="single_meal_id" value="{{ $meal->id }}">
            <button type="submit">Proceed to Payment</button>
        </form>
    @else
        <h4>Your Order</h4>
        <ul>
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <li>{{ $item['name'] }} x {{ $item['quantity'] }} = ${{ $item['price'] * $item['quantity'] }}</li>
            @endforeach
        </ul>
        <p><strong>Total: ${{ $total }}</strong></p>

        <form action="{{ route('user.processPayment') }}" method="POST">
            @csrf
            <button type="submit">Proceed to Payment</button>
        </form>
    @endif
</div>
@endsection
