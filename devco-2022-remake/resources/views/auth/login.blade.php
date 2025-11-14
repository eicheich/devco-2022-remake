@extends('layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .password-toggle:hover {
            color: #495057;
        }

        /* Disable browser password toggle */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0" style="border-radius: 10px;">
                    <div class="card-header bg-white border-0 text-center py-3">
                        <h3 class="mb-0">Login</h3>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email or username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div style="position: relative;">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required style="padding-right: 40px;">
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="{{ route('password.forgot') }}" class="text-decoration-none">Forgot
                                    Password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">Login</button>
                        </form>
                        <p class="mt-3 text-center">Don't have an account? <a href="{{ route('register.email') }}">Register
                                here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
