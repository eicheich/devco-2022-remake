@extends('layouts.app')

@section('title', 'Forgot Password - Verify OTP')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="card-title mb-4">Forgot Password</h3>
                        <p class="text-muted mb-4">Verify OTP sent to your email</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

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

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            OTP has been sent to: <strong>{{ $email }}</strong>
                        </div>

                        <form method="POST" action="{{ route('password.reset.verify') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP Code</label>
                                <input type="text" class="form-control text-center @error('otp') is-invalid @enderror"
                                    id="otp" name="otp" placeholder="000000" maxlength="6" pattern="[0-9]{6}"
                                    required autofocus>
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Enter the 6-digit code sent to your email</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Verify OTP</button>
                        </form>

                        <hr>
                        <p class="text-center text-muted mb-0">
                            <a href="{{ route('password.forgot') }}">Back</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
