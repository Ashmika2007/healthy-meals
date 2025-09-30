<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\User;
use App\Models\Meal;
use App\Models\Order;

class AdminDashboardController extends Controller
{
   public function index()
{
    // Statistics
    $stats = [
        'orders' => Order::count(),
        'revenue' => Order::with('items.meal')->get()->sum(function ($order) {
            $items = $order->items ?? collect();
            return $items->sum(function ($item) {
                return ($item->meal->price ?? 0) * $item->quantity;
            });
        }),
        'users' => User::count(),
        'meals' => Meal::count(),
    ];

    // Recent orders
    $recentOrders = Order::with(['user', 'items.meal'])
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact('stats', 'recentOrders'));
}

    // List all orders
    public function orders()
    {
        $orders = Order::with(['user', 'items.meal'])->latest()->get();
        return view('admin.orders.index', compact('orders')); 
    }

    // Update order status
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
