@extends('layouts.app')

@section('content')
    <section>
        <h1>Login Page</h1>
        <form method="POST" action="/login">
            @crsf
            <label>Email:</label>
            <input type="email" name="email" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </section>
    
@endsection