<div>
    @if(count($cartItems))
        <div class="table-responsive shadow-sm rounded-4 mb-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Meal</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rs {{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input type="number" 
                                       min="1" 
                                       value="{{ $item['quantity'] }}" 
                                       wire:change="updateQuantity('{{ $id }}', $event.target.value)" 
                                       class="form-control form-control-sm" 
                                       style="width: 70px;">
                            </td>
                            <td>Rs {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <button wire:click="removeItem('{{ $id }}')" 
                                        class="btn btn-danger btn-sm rounded-3">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total</td>
                        <td colspan="2" class="fw-bold" style="color:#2D6A4F;">
                            Rs {{ number_format($total, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('user.showCheckout') }}" class="btn btn-success">
            Proceed to Checkout
        </a>
    @else
        <p class="text-muted">Your cart is empty.</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-3 rounded-3">Back to Meals</a>
    @endif
</div>
