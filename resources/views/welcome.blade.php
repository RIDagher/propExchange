<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <section class="hero bg-dark text-white text-center p-5">
        <div class="container">
            <h1>Find Your Dream Home</h1>
            <p>Browse for properties for sale or rent</p>
            <a href="#" class="btn btn-light btn-lg">Explore listings</a>
        </div>
    </section>

    <!-- Info -->
    <section class="info-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Why Choose Us?</h2>
            <ul class="row list-unstyled text centered">
                <li class="col-md-3 mb-4">
                    <h2>20</h2>
                    <p>Years of Service</p>
                </li>
                <li class="col-md-3 mb-4">
                    <h2>97%</h2>
                    <p>Of our clients would recommend PropExchange</p>
                </li>
                <li class="col-md-3 mb-4">
                    <h2>9.5 / 10</h2>
                    <p>Rating according to reviews</p>
                </li>
                <li class="col-md-3 mb-4">
                    <h2>15k+</h2>
                    <p>Customers who trust us</p>
                </li>
            </ul>
        </div>
    </section>
@endsection
