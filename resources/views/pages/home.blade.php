@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section style="height: 65vh; 
                background: url('{{ asset('storage/meals/banner2.jpeg') }}') center/cover no-repeat; 
                position: relative; 
                border-bottom-left-radius: 50px; 
                border-bottom-right-radius: 50px; 
                overflow: hidden;">
    <!-- Dark overlay -->
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; 
                background: rgba(0,0,0,0.25);"></div>

    <!-- Content -->
    <div class="d-flex flex-column align-items-start justify-content-center text-white h-100 position-relative px-4 px-md-5">
        <h1 class="fw-bold display-4 mb-3">
            Fresh <span class="text-success">Healthy Meals</span>
        </h1>
        <p class="lead mb-4" style="max-width:450px;">
            Tasty, Nutritious & Delivered Right to Your Door
        </p>
        <a href="{{ route('register') }}" 
           class="btn btn-success btn-lg px-4 py-2 fw-bold shadow rounded-pill"
           style="transition:0.3s;">
            Sign Up Now
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="py-4 py-md-5" style="background-color:#f8f9fa;">
    <div class="container">
        <h2 class="text-center fw-bold mb-4 mb-md-5">Why Choose Us?</h2>
        <div class="row justify-content-center text-center g-3 g-md-4">
            @php
                $features = [
                    ['icon'=>'fa-leaf', 'color'=>'text-success', 'title'=>'Fresh & Healthy', 'desc'=>'Nutritious meals prepared with good care.'],
                    ['icon'=>'fa-sliders', 'color'=>'text-primary', 'title'=>'Customizable', 'desc'=>'Plans that fit your lifestyle.'],
                    ['icon'=>'fa-dollar-sign', 'color'=>'text-danger', 'title'=>'Affordable', 'desc'=>'Healthy meals at great prices.'],
                ];
            @endphp
            @foreach($features as $feature)
            <div class="col-12 col-md-4">
                <div class="p-4 bg-white shadow-sm rounded-4 h-100 hover-effect">
                    <i class="fa-solid {{ $feature['icon'] }} fa-2x {{ $feature['color'] }} mb-2"></i>
                    <h6 class="fw-bold">{{ $feature['title'] }}</h6>
                    <p class="text-muted small">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Available Meals Section -->
<section id="available-meals" class="container my-5">

    <h2 class="text-center mb-4 fw-bold">Available Meals</h2>

    @if($meals->count())
    <div class="meal-marquee">
        <div class="meal-track">
        
            @for($i = 0; $i < 2; $i++)
                @foreach($meals as $meal)
                <div class="card shadow-sm mx-2" style="width:220px; flex-shrink:0;">
                    <img src="{{ asset('storage/meals/' . $meal->image) }}" 
                         class="card-img-top" 
                         alt="{{ $meal->name }}" 
                         style="height:160px; object-fit:cover;">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-1">{{ $meal->name }}</h6>
                        <p class="text-muted small mb-1" style="font-size:12px;">{{ $meal->description }}</p>
                        <p class="fw-bold mb-2">Rs {{ number_format($meal->price, 2) }}</p>

                        @auth
                        <form action="{{ route('user.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="meal_id" value="{{ $meal->id }}">
                            <button type="submit" class="btn btn-primary btn-sm">Add</button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm"
                           onclick="alert('Please log in to add items to cart');">Add</a>
                        @endauth
                    </div>
                </div>
                @endforeach
            @endfor

            {{-- Duplicate for seamless loop --}}
            @for($i = 0; $i < 2; $i++)
                @foreach($meals as $meal)
                <div class="card shadow-sm mx-2" style="width:220px; flex-shrink:0;">
                    <img src="{{ asset('storage/' . $meal->image) }}" 
                         class="card-img-top" 
                         alt="{{ $meal->name }}" 
                         style="height:160px; object-fit:cover;">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-1">{{ $meal->name }}</h6>
                        <p class="text-muted small mb-1" style="font-size:12px;">{{ $meal->description }}</p>
                        <p class="fw-bold mb-2">Rs {{ number_format($meal->price, 2) }}</p>

                        @auth
                        <form action="{{ route('user.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="meal_id" value="{{ $meal->id }}">
                            <button type="submit" class="btn btn-primary btn-sm">Add</button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm"
                           onclick="alert('Please log in to add items to cart');">Add</a>
                        @endauth
                    </div>
                </div>
                @endforeach
            @endfor
        </div>
    </div>
    @else
        <p class="text-center text-muted">No meals available currently.</p>
    @endif
</section>

<style>
/* Marquee style for meals */
.meal-marquee {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.meal-track {
    display: flex;
    width: max-content;
    animation: scrollMeals 50s linear infinite; /* Faster scroll */
}

@keyframes scrollMeals {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>


<!-- Testimonials Section -->
<section class="container my-4 my-md-5">
    <h2 class="text-center fw-bold mb-3 mb-md-4 text-success">What Our Customers Say</h2>
    <div class="d-flex justify-content-center">
        <div class="card shadow-sm border-0 text-center p-4" 
             style="max-width: 800px; border-radius: 20px; background: linear-gradient(135deg, #d9e9dcff, #e9f7ef);">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                 style="width:60px; height:60px;">
                <i class="bi bi-person-fill fs-3"></i>
            </div>
            <p class="fst-italic mb-2 text-dark">
                "The meals are delicious and perfect for my diet! Highly recommended."
            </p>
            <h6 class="fw-bold text-success">— Jamis M.</h6>
        </div>
    </div>
</section>

<!-- Subscribe Section -->
<div class="text-center my-3 my-md-4">
    <a href="{{ route('login') }}" 
       class="btn btn-warning btn-lg px-4 py-2 fw-bold shadow-sm rounded-pill">
       Subscribe Now
    </a>
</div>


<!-- Footer Section -->
<footer class="bg-light py-3 py-md-4 mt-5">
    <div class="container d-flex justify-content-between flex-wrap">
        <div class="mb-3 mb-md-0">
            <h5 class="fw-bold">Healthys</h5>
            <p class="mb-0">081-2072837<br>info@mysite.com</p>
        </div>
        <div class="mb-3 mb-md-0">
            <ul class="list-unstyled mb-0">
                <li><a href="#" class="text-decoration-none text-dark">Privacy policy</a></li>
                <li><a href="#" class="text-decoration-none text-dark">Accessibility</a></li>
                <li><a href="#" class="text-decoration-none text-dark">Terms & conditions</a></li>
                <li><a href="#" class="text-decoration-none text-dark">Refund policy</a></li>
            </ul>
        </div>
        <div>
            <form>
                <input type="email" placeholder="Enter Email*" class="form-control mb-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="agree">
                    <label class="form-check-label" for="agree">
                        I agree to terms & conditions
                    </label>
                </div>
                <button type="submit" class="btn btn-warning w-100">Submit</button>
            </form>
        </div>
    </div>
    <div class="text-center mt-3">
        <small>© 2025 Healthys</small>
    </div>
</footer>

<style>
/* Marquee style for meals */
.meal-marquee {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.meal-track {
    display: flex;
    width: max-content;
    animation: scrollMeals 40s linear infinite;
}

@keyframes scrollMeals {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>

@endsection
