<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'My Website'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Font & Custom Styling -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            color: #0d6efd !important;
        }
        footer {
            background: #212529;
            color: #adb5bd;
        }
        footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        footer a:hover {
            color: #fff;
        }
        .hero-section {
            background: linear-gradient(to right, #0d6efd, #6610f2);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- 🌐 Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">HafeezUllah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="{{ route('blog.index') }}" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
                    @auth
                        <li class="nav-item"><a href="{{ url('/dashboard') }}" class="btn btn-primary ms-2">Dashboard</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🏞️ Optional Hero -->
    @hasSection('header')
        <section class="hero-section">
            <div class="container">
                <h1 class="display-5 fw-bold">@yield('header')</h1>
                @hasSection('subheader')
                    <p class="mt-3 fs-5 text-light">@yield('subheader')</p>
                @endif
            </div>
        </section>
    @endif

    <!-- 📄 Main Content -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- ⚙️ Footer -->
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-white">About Us</h5>
                    <p class="small">We share valuable insights, tutorials, and creative ideas through our blog to inspire modern developers.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white">Follow Us</h5>
                    <div class="d-flex gap-3 fs-5">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <p class="text-center small mb-0">© {{ date('Y') }} MyWebsite. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>
