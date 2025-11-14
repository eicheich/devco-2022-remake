@extends('layouts.app')

@section('title', 'Register - Step 2: Verify OTP')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="card-title mb-4">Verify Email</h3>
                        <p class="text-muted mb-4">Step 2: Enter the OTP code sent to {{ session('email') }}</p>

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

                        <form method="POST" action="{{ route('register.verify') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">

                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP Code (6 digits)</label>
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp"
                                    name="otp" placeholder="000000" maxlength="6" pattern="[0-9]{6}"
                                    value="{{ old('otp') }}" required>
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Verify OTP</button>
                        </form>

                        <hr>
                        <p class="text-center text-muted text-sm">
                            Didn't receive OTP? <a href="{{ route('register.email') }}">Back to step 1</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
