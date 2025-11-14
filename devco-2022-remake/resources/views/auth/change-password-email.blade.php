@extends('layouts.app')

@section('title', 'Change Password - Step 1')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="card-title mb-4">Change Password</h3>
                        <p class="text-muted mb-4">Step 1: Confirm your email</p>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.change.send-otp') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="your@email.com"
                                    value="{{ Auth::user()->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Enter your account email to verify your identity</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Send OTP</button>
                        </form>

                        <hr>
                        <p class="text-center text-muted mb-0">
                            <a href="{{ route('home') }}">Back to Timeline</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
