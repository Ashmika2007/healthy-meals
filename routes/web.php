<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\MealController as AdminMealController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\AdminSubscriptionController;

// ================== Public Routes ==================
Route::get('/', [HomeController::class, 'index'])->name('home');

// User Authentication
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================== User Routes (authenticated) ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Cart
    Route::get('/user/cart', [UserDashboardController::class, 'cart'])->name('user.cart');
    Route::post('/user/cart/add', [UserDashboardController::class, 'addToCart'])->name('user.cart.add');
    Route::post('/user/cart/update', [UserDashboardController::class, 'updateCart'])->name('user.cart.update');
    Route::post('/user/cart/remove', [UserDashboardController::class, 'removeFromCart'])->name('user.cart.remove');

    // Checkout
    Route::get('/checkout', [UserDashboardController::class, 'showCheckout'])->name('user.showCheckout');
    Route::post('/checkout', [UserDashboardController::class, 'checkout'])->name('user.checkout');

    // Buy now
    Route::post('/user/buy-now/{meal}', [UserDashboardController::class, 'buyNow'])->name('user.buyNow');

    // Orders
    Route::get('/user/orders', [UserDashboardController::class, 'orders'])->name('user.orders');
    Route::get('/my-orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders.index');

    
    // Subscriptions
    Route::get('subscriptions', [SubscriptionController::class, 'subscriptions'])->name('subscriptions.index');
    Route::get('subscriptions/{plan}/payment', [SubscriptionController::class, 'showPaymentPage'])->name('subscriptions.payment');
    Route::post('subscriptions/{plan}/process', [SubscriptionController::class, 'processPayment'])->name('subscriptions.process');
});

// ================== Admin Authentication ==================
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ================== Admin Routes ==================
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Meals page (Livewire powered)
    Route::get('/meals', fn() => view('admin.meals.index'))->name('meals.index');

    // Categories
    Route::get('/categories', fn() => view('admin.categories.index'))->name('categories.index');

    // Subscriptions
    Route::get('/subscriptions', fn() => view('admin.subscriptions.index'))->name('subscriptions.index');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-block', [AdminUserController::class,'toggleBlock'])->name('users.toggleBlock');

    // Orders
    Route::get('orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.status');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

   Route::get('/reviews', function(){
    return view('admin.reviews'); // loads resources/views/admin/reviews.blade.php
})->name('reviews.index');

});
