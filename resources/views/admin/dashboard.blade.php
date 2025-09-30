@extends('admin.layout')

@section('content')
<h3>Dashboard</h3>

<div class="row">
  <div class="col-md-3">
    <div class="card p-3">Meals: {{ $stats['meals'] }}</div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">Orders: {{ $stats['orders'] }}</div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">Users: {{ $stats['users'] }}</div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">Revenue: Rs {{ $stats['revenue'] }}</div>
  </div>
</div>

<h5 class="mt-4">Recent Orders</h5>

@if($recentOrders->count())
<ul>
  @foreach($recentOrders as $order)
    <li>
      <!-- User name -->
      {{ $order->user?->name ?? 'No User' }} - 

      <!-- Total items -->
      {{ $order->items?->sum('quantity') ?? 0 }} items - 

      <!-- Total price -->
      Rs {{ $order->items?->sum(fn($i) => ($i->meal->price ?? 0) * $i->quantity) ?? 0 }} - 

      <!-- Status -->
      {{ ucfirst($order->status) }}
    </li>
  @endforeach
</ul>
@else
<p>No recent orders found.</p>
@endif
@endsection
