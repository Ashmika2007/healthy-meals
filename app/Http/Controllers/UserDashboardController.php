<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;

class UserDashboardController extends Controller
{
    // Show dashboard with meals, categories, and orders
    public function index(Request $request)
    {
        $categories = Category::where('is_active', 1)->get();

        $category_id = $request->query('category');
        $meals = $category_id ? Meal::where('category_id', $category_id)->get() : Meal::all();

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('meals', 'categories', 'orders'));
    }

    // Add meal to cart (session)
    public function addToCart(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|integer|exists:meals,id'
        ]);

        $meal = Meal::findOrFail($request->meal_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$meal->id])) {
            $cart[$meal->id]['quantity']++;
        } else {
            $cart[$meal->id] = [
                'name' => $meal->name,
                'price' => $meal->price,
                'quantity' => 1,
                'image' => $meal->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Meal added to cart!');
    }

    // Remove meal from cart
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->meal_id])) {
            unset($cart[$request->meal_id]);
            session()->put('cart', $cart);
            return redirect()->route('user.cart')->with('success', 'Item removed from cart.');
        }

        return redirect()->route('user.cart')->with('error', 'Item not found in cart.');
    }

    // Show cart page
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    // Show checkout page
    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        return view('user.checkout', compact('cart'));
    }

    // Checkout: create order and order items
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []); // ✅ Define cart

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        // 1. Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status'  => 'pending', // or approved
        ]);

        // 2. Add order items
        foreach ($cart as $mealId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'meal_id'  => $mealId,
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
            ]);
        }

        // 3. Clear cart
        session()->forget('cart');

        // 4. Redirect
        // after saving the order
return redirect()->route('user.orders')->with('success', 'Your order has been placed successfully!');

    }

    // Buy now for a single meal
    public function buyNow(Request $request, $meal_id)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $meal = Meal::findOrFail($meal_id);
        $quantity = $request->quantity ?? 1;

        // 1. Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status'  => 'confirmed'
        ]);

        // 2. Add order item
        OrderItem::create([
            'order_id' => $order->id,
            'meal_id'  => $meal->id,
            'quantity' => $quantity,
            'price'    => $meal->price,
        ]);

        return redirect()->route('user.orders')->with('success', 'Order placed successfully!');
    }

    // Show user orders
      public function orders()
    {
        $user = Auth::user(); // get logged-in user

        $orders = Order::with('orderItems.meal')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('users.order.index', compact('orders'));

    }

}
