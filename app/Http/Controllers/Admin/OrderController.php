<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with(['user', 'items.meal'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show single order
    public function show($id)
    {
        $order = Order::with(['user', 'items.meal'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order status updated successfully.');
    }

    // Delete order and items
    public function destroy($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully.');
    }
}
