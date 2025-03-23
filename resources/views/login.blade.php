@extends('layouts.app')

@section('title', 'Login - PropExchange')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div>
            <form id="login-form" class="p-5 shadow">
                <h2 class="py-3">Login</h2>
                <p class="fs-7">Please login in to continue OR please click <q>Register</q> below to create your account.</p>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Submit</button>
                <p class="pt-4">Don't have an account? <a href="{{ url('/register') }}">Register</a></p>
            </form>
        </div>
    </div>
    
@endsection