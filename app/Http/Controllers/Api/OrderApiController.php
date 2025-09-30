<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function show($id)
    {
        $order = Order::with('orderItems.meal')->findOrFail($id);

        return response()->json([
            'id'     => $order->id,
            'status' => $order->status,
            'total'  => $order->total_price,
            'items'  => $order->orderItems->map(function($item){
                return [
                    'meal'     => $item->meal->name,
                    'quantity' => $item->quantity,
                    'price'    => $item->price,
                ];
            }),
        ]);
    }

    public function checkout(Request $request)
    {
        // Example protected endpoint
        return response()->json(['message'=>'Checkout not fully implemented, but protected by Sanctum']);
    }
}
