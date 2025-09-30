<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.meal')   // eager load items + meal
            ->where('user_id', Auth::id())    // only current user's orders
            ->latest()
            ->get();                          // ✅ returns a collection (never null)

        return view('user.orders.index', compact('orders'));
    }
}
