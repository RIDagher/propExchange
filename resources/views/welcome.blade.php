<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')

    <!-- Hero -->
    <section id="hero" class="hero text-white text-center p-5" style="background: url('images/hero.jpg') no-repeat center center; background-size: cover;">
    <div class="container">
        <h1 class="text-shadow">Find Your Dream Home</h1>
        <p class="text-shadow">Browse for properties for sale or rent</p>
        <form method="GET" action="{{ route('search-properties') }}" class="position-relative w-50 mx-auto">
            <input type="text" name="city" id="search-input" class="form-control shadow" placeholder="Enter city..." autocomplete="off">
            <button type="submit" class="btn btn-light btn-block mt-3 shadow">Search</button>
        </form>
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
        
    <!-- Properties -->
     <section class="property-cards py-5">
        <div class="container">
            <h2 class="mb-4 text-white">Properties Listed</h2>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                        <img src="{{ asset('images/laval-house.jpg') }}" class="card-img-top" alt="House Card" style="height: 180px;">
                            <h5 class="card-title mt-3">Houses</h5>
                            <p class="card-text">Browse houses available for sale or for rent.</p>
                            <a href="{{ route('search-properties', ['type' => 'house']) }}" class="btn">Search Houses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                        <img src="{{ asset('images/montreal.jpg') }}" class="card-img-top w" alt="Condo Card" style="height: 180px;">
                            <h5 class="card-title mt-3">Condo</h5>
                            <p class="card-text">Browse condos available for sale or for rent.</p>
                            <a href="{{ route('search-properties', ['type' => 'condo']) }}" class="btn">Search Condos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                        <img src="{{ asset('images/mont-tremblant.jpg') }}" class="card-img-top" alt="Cottage Card" style="height: 180px;">
                            <h5 class="card-title mt-3">Cottage</h5>
                            <p class="card-text">Browse cottages available for sale or for rent.</p>
                            <a href="{{ route('search-properties', ['type' => 'cottage']) }}" class="btn">Search Cottages</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                        <img src="{{ asset('images/multiplex-long.jpg') }}" class="card-img-top" alt="Multiplex Card" style="height: 180px;"> 
                            <h5 class="card-title mt-3">Multiplex</h5>
                            <p class="card-text">Browse multiplexes available for sale or for rent.</p>
                            <a href="{{ route('search-properties', ['type' => 'multiplex']) }}" class="btn">Search Multiplexes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </section>
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
@endsection
