<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevCo - Social Media Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html[data-theme="dark"] {
            background-color: #1a1a1a;
            color: #e0e0e0;
        }

        html[data-theme="dark"] body {
            background-color: #1a1a1a !important;
            color: #e0e0e0;
        }

        html[data-theme="dark"] .navbar {
            background-color: #242424 !important;
            border-bottom: 1px solid #333;
        }

        html[data-theme="dark"] .navbar-brand,
        html[data-theme="dark"] .navbar-text,
        html[data-theme="dark"] .btn-link {
            color: #e0e0e0 !important;
        }

        html[data-theme="dark"] .card {
            background-color: #242424;
            border-color: #333;
            color: #e0e0e0;
        }

        html[data-theme="dark"] p,
        html[data-theme="dark"] h1,
        html[data-theme="dark"] h2,
        html[data-theme="dark"] h3,
        html[data-theme="dark"] h4,
        html[data-theme="dark"] h5,
        html[data-theme="dark"] h6,
        html[data-theme="dark"] span,
        html[data-theme="dark"] div {
            color: #e0e0e0;
        }

        html[data-theme="dark"] a {
            color: #64b5f6 !important;
        }

        html[data-theme="dark"] a:hover {
            color: #90caf9 !important;
        }

        html[data-theme="dark"] .text-muted {
            color: #999 !important;
        }

        html[data-theme="dark"] .btn-primary {
            background-color: #2196f3;
            border-color: #2196f3;
        }

        html[data-theme="dark"] .btn-outline-primary {
            color: #64b5f6;
            border-color: #64b5f6;
        }

        html[data-theme="dark"] .btn-outline-primary:hover {
            background-color: #64b5f6;
            border-color: #64b5f6;
            color: #1a1a1a;
        }

        html[data-theme="dark"] .form-control::placeholder {
            color: #666 !important;
            opacity: 1;
        }

        html[data-theme="dark"] .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.5) !important;
        }

        html[data-theme="dark"] footer {
            background-color: #242424 !important;
            border-top: 1px solid #333;
        }

        html[data-theme="dark"] li {
            color: #e0e0e0;
        }
    </style>
</head>

<body style="background-color: #ffffff;">
    @auth
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">DevCo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <div>
                            @auth
                                <a href="{{ route('home') }}" class="btn btn-primary me-2">Timeline</a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                                <a href="{{ route('register.email') }}" class="btn btn-primary">Sign Up</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    @guest
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">DevCo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                            <a href="{{ route('register.email') }}" class="btn btn-primary">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endguest

    <div class="container py-5">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold mb-2">Welcome to DevCo</h1>
                <p class="lead text-muted mb-4">
                    <em>Damn, Everyone's Vibing Community</em>
                </p>
                <p class="lead text-muted mb-4">
                    Connect with friends, share your thoughts, and engage with a vibrant community.
                </p>
                <div class="d-flex gap-2 justify-content-center justify-content-lg-start flex-wrap">
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Go to Timeline</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                        <a href="{{ route('register.email') }}" class="btn btn-outline-primary btn-lg">Sign Up</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-6">
                <!-- What's New -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="fas fa-rocket text-primary me-2"></i>What's New
                        </h5>
                        @forelse($updates as $update)
                            <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex align-items-start">
                                    <span
                                        class="badge {{ $loop->first ? 'bg-primary' : 'bg-success' }} me-2">{{ $loop->first ? 'New' : 'Update' }}</span>
                                    <div>
                                        <strong>{{ $update->title }}</strong>
                                        @if ($update->version)
                                            <span class="badge bg-secondary ms-1">v{{ $update->version }}</span>
                                        @endif
                                        <p class="text-muted small mb-0">{{ Str::limit($update->description, 50) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted small mb-0">No updates available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Features -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Features</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Share Posts</strong> - Express yourself
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Interact</strong> - Like & comment
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Follow Friends</strong> - Stay connected
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Get Notifications</strong> - Real-time updates
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-4 mt-5 text-center border-top">
        <div class="container">
            <p class="mb-0 text-muted">&copy; 2022 <a href="https://houselab.my.id" target="_blank"
                    class="text-decoration-none text-muted">Houselab</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark Mode Toggle
        const welcomeDarkModeToggle = document.getElementById('welcomeDarkModeToggle');
        const html = document.documentElement;
        const body = document.body;

        function applyDarkMode(isDark) {
            if (isDark) {
                html.setAttribute('data-theme', 'dark');
                body.style.backgroundColor = '#1a1a1a';
                welcomeDarkModeToggle.innerHTML = '<i class="fas fa-sun fa-lg"></i>';
            } else {
                html.removeAttribute('data-theme');
                body.style.backgroundColor = '#ffffff';
                welcomeDarkModeToggle.innerHTML = '<i class="fas fa-moon fa-lg"></i>';
            }
        }

        // Check saved preference
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        if (savedDarkMode) {
            applyDarkMode(true);
        }

        // Toggle dark mode
        welcomeDarkModeToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const isDark = html.getAttribute('data-theme') !== 'dark';
            applyDarkMode(isDark);
            localStorage.setItem('darkMode', isDark);
        });
    </script>
</body>

</html>
