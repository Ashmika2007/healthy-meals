<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Cart extends Component
{
    public $cartItems = [];
    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Session::get('cart', []);
        $this->calculateTotal();
    }

    public function updateQuantity($cartId, $quantity)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] = max(1, (int) $quantity); // no 0 or negative
            Session::put('cart', $cart);
        }

        $this->loadCart();
    }

    public function removeItem($cartId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$cartId])) {
            unset($cart[$cartId]);
            Session::put('cart', $cart);
        }

        $this->loadCart();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
