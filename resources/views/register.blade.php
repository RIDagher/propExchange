@extends('layouts.app')

@section('title', 'Register - PropExchange')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div>
            <form id="register-form" class="p-5 shadow">
                <h2 class="py-3">Register</h2>
                <p class="fs-7">Please register to continue OR please click <q>Login</q> below to login to your account.</p>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="re-password">
                </div>
                <div class="mb-3">
                    <label for="form-label">Role</label>
                    <select class="form-select" name="role">
                        <option value="client">Client</option>
                        <option value="agent">Agent</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Submit</button>
                <p class="pt-4">Have an account? <a href="{{ url('/login') }}">Login</a></p>
            </form>
        </div>
    </div>

    <div class="modal" id="modal">
        <div id="modal-content" class="modal-content p-4 shadow">
            <span id="close" class="close">&times;</span>
            <p id="success">Your account has been created successfully!</p>
        </div>
    </div>
    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/createUser.js') }}"></script>
    
    @endsection
    
@endsection