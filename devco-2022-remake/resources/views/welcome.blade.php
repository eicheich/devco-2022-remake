<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevCo - Social Media Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-color: #ffffff;">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">DevCo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary me-2">Timeline</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Welcome to DevCo</h1>
                <p class="lead text-muted mb-4">
                    Connect with friends, share your thoughts, and engage with a vibrant community.
                </p>
                <div class="d-flex gap-2 justify-content-center justify-content-lg-start flex-wrap">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Go to Timeline</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Sign Up</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h5 class="card-title fw-bold mb-4">Features</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Share Posts</strong> - Express yourself with text and media
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Interact</strong> - Like, comment, and engage with content
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Follow Friends</strong> - Stay updated with their activities
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <strong>Get Notifications</strong> - Never miss important updates
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-4 mt-5">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} DevCo. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
