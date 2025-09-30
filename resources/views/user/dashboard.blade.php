@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- View Orders Button --}}
    <div class="mb-3">
        <a href="{{ route('user.orders.index') }}" class="btn btn-primary">
            View My Orders
        </a>
    </div>

    {{-- Banner with dark overlay and welcome text --}}
    <div class="position-relative mb-5" style="height: 320px; border-radius:20px; overflow:hidden;">
        <img src="{{ asset('storage/meals/hero.jpeg') }}" 
             class="w-100 h-100" 
             style="object-fit:cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.35);"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3">
            <h2 class="fw-bold display-5">Welcome, {{ auth()->user()->name }}</h2>
            <p class="fs-5">Explore and choose from our healthy meal plans</p>
        </div>
    </div>

    {{-- Extra spacing after banner --}}
    <div class="mb-5"></div>

    {{-- Categories Section --}}
    <section class="mb-5 py-4 px-3 rounded-4" style="background-color:#e6f4ea;">
        <h3 class="text-center fw-bold mb-4" style="color:#2D6A4F;">Meal Categories</h3>
        <div class="row g-4">
            @php
                $categoryData = [
                    ['id'=>1,'name'=>'Vegan','image'=>'vegan.jpg','color'=>'#66bc94ff'],
                    ['id'=>2,'name'=>'Keto','image'=>'keto.jpg','color'=>'#ffc42eff'],
                    ['id'=>3,'name'=>'High Protein','image'=>'high_protein.jpg','color'=>'#ff9113ff'],
                    ['id'=>4,'name'=>'Gluten Free','image'=>'gluten_free.jpg','color'=>'#65c2d9ff'],
                ];
            @endphp

            @foreach($categoryData as $cat)
            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm h-100 rounded-4 border-0 text-center" style="background-color: {{ $cat['color'] }};">
                    <img src="{{ asset('storage/meals/' . $cat['image']) }}" 
                         class="card-img-top rounded-top-4 p-3" 
                         alt="{{ $cat['name'] }}" 
                         style="height:140px; object-fit:cover; border-radius:15px;">
                    <div class="card-body">
                        <h6 class="fw-bold text-white">{{ $cat['name'] }}</h6>
                        <a href="{{ route('user.dashboard', ['category' => $cat['id']]) }}" 
                           class="btn btn-light btn-sm mt-2 w-75 rounded-pill shadow-sm">
                           View Meals
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Extra spacing between categories and meals --}}
    <div class="mb-5"></div>

    {{-- Selected Category --}}
    @if(request()->query('category'))
        @php
            $selectedCategory = $categories->firstWhere('id', (int) request()->query('category'));
        @endphp
        @if($selectedCategory)
            <h3 class="mt-5 mb-4 fw-semibold" style="color:#40916C;">
                {{ str_replace('_',' ',$selectedCategory->name) }} Meals
            </h3>
        @endif
    @endif

    {{-- Meals Section --}}
    @if($meals->count())
        <div class="row g-4">
            @foreach($meals as $meal)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm rounded-4 border-0">
                        <img src="{{ asset('storage/meals/' . $meal->image) }}" 
                             class="card-img-top rounded-top-4" 
                             alt="{{ str_replace('_',' ',$meal->name) }}" 
                             style="height:160px; object-fit:cover;">
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold">{{ str_replace('_',' ',$meal->name) }}</h6>
                            <p class="text-muted small mb-2">{{ $meal->description }}</p>
                            <p class="mb-2 fw-semibold" style="color:#2D6A4F;">
                                Rs {{ number_format($meal->price, 2) }}
                            </p>
                            <form action="{{ route('user.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="meal_id" value="{{ $meal->id }}">
                                <button type="submit" class="btn btn-success w-100 rounded-3" style="background-color:#52B788; border:none;">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted mt-4">No meals available currently.</p>
    @endif

    {{-- Orders --}}
    <h3 class="mt-5 mb-3 fw-semibold" style="color:#40916C;">Your Recent Orders</h3>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="fw-semibold" style="color:#2D6A4F;">
                            Rs {{ number_format($order->total_price, 2) }}
                        </td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No orders yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @livewire('review-component')



    

</div>
@endsection
