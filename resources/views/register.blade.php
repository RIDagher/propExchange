@extends('layouts.app')

@section('title', 'Register - PropExchange')



@section('content')

    <div class="container d-flex justify-content-center align-items-center">
        <div>
            <form id="register-form" class="p-5 shadow" method="POST" action="{{ route('register.submit') }}">
                @csrf
                <h2 class="py-3">Register</h2>
                <p class="fs-7">Please register to continue OR please click <q>Login</q> below to login to your account.</p>
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" 
                        class="form-control @error('username') is-invalid @enderror" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}" 
                        required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password Confirmation -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required>
                </div>
                
                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" class="form-select" name="role" required>
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                    </select>
                </div>
                <button type="submit" id="register-btn" class="btn btn-primary w-100 py-2">Submit</button>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="mx-2">OR</span>
                    <hr class="flex-grow-1">
                </div>

                <a href="{{ route('login.google') }}" class="btn btn-danger w-100 py-2 mb-2">Register as <q>client</q> with Google</a>

                <p class="pt-4">Have an account? <a href="{{ url('/login') }}">Login</a></p>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var flashModalEl = document.getElementById('flashModal');
    if (flashModalEl) {
        var flashMessage = flashModalEl.getAttribute('data-flash-message');
        if (flashMessage && flashMessage.trim() !== "") {
            var flashModal = new bootstrap.Modal(flashModalEl);
            flashModal.show();
        }
    }
});
</script>
@vite(['resources/js/createUser.js'])
@endsection


