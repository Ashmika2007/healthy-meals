<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Healthy Meals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Styles -->
        @livewireStyles

</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-sm">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">Healthys</a>

            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Side (Links) -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/#available-meals') }}">Meals</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
        

    </li>
                </ul>

                <!-- Right Side (Cart + Auth) -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Cart -->
                    <li class="nav-item mx-2">
                        <a href="{{ route('user.cart') }}" class="nav-link">
                            🛒 Cart ({{ session('cart') ? count(session('cart')) : 0 }})
                        </a>
                    </li>

                    @guest
                        <!-- Show when not logged in -->
                        <li class="nav-item mx-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-success">Log In</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a href="{{ route('register') }}" class="btn btn-success">Sign Up</a>
                        </li>
                    @endguest

                    @auth
                        <!-- Show when logged in -->
                        <li class="nav-item mx-2">
                            <span class="fw-bold text-dark">Hi, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item mx-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-light text-center p-3 mt-5">
        <p>© 2025 Healthys | Privacy Policy | Terms & Conditions</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     @livewireScripts
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</html>

