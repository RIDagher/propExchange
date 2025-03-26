@extends('layouts.app')

@section('title', 'Login - PropExchange')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

            <form id="login-form" class="p-5 shadow" method="POST" action="{{ route('login.submit') }}">
                @csrf
                <h2 class="py-3">Login</h2>
                <p class="fs-7">Please login in to continue OR please click <q>Register</q> below to create your account.</p>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" 
                        class="form-control"
                        id="email" 
                        name="email"
                        value="{{ old ('email') }}"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" 
                    class="form-control"
                    id="password"
                    name="password"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>

                <button type="submit" id="login-btn" class="btn btn-primary w-100 py-2">Submit</button>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="mx-2">OR</span>
                    <hr class="flex-grow-1">
                </div>

                <a href="{{ route('login.google') }}" class="btn btn-danger w-100 py-2 mb-2">Login as <q>client</q> with Google</a>
                <p class="pt-4">Don't have an account? <a href="{{ url('/register') }}">Register</a></p>
            </form>
        </div>
    </div>
@endsection
    
@section('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var flashMessageContainer = document.getElementById('flashMessageContainer');
        var flashMessage = flashMessageContainer ? flashMessageContainer.getAttribute('data-flash-message') : "";
        if (flashMessage) {
            var flashToastEl = document.getElementById('flashToast');
            if (flashToastEl) {
                var toast = new bootstrap.Toast(flashToastEl);
                toast.show();
            }
        }
    });
    </script>
@vite(['resources/js/loginUser.js'])
@endsection

    
