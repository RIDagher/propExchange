<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')

    <!-- Hero -->
    <section class="hero text-white text-center p-5">
        <div class="container">
            <h1>Find Your Dream Home</h1>
            <p>Browse for properties for sale or rent</p>
            <div class="postion-relative w-50 mx-auto">
                <input type="text" id="search-input" class="form-control" placeholder="Search for properties..." autocomplete="off">
                <div id="search-results" class="list-group position-absolute w-100 shadow bg-white"></div>
            </div>
        </div>
    </section>
    @section('scripts')
    <script src="{{ assest('js/app.js') }}"></script>
    @endsection

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
                            <h5 class="card-title">Houses</h5>
                            <p class="card-text">Browse houses available for sale or for rent.</p>
                            <a href="#" class="btn">Search Houses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Condo</h5>
                            <p class="card-text">Browse condos available for sale or for rent.</p>
                            <a href="#" class="btn">Search Condos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Cottage</h5>
                            <p class="card-text">Browse cottages available for sale or for rent.</p>
                            <a href="#" class="btn">Search Cottages</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Multiplex</h5>
                            <p class="card-text">Browse multiplexes available for sale or for rent.</p>
                            <a href="#" class="btn">Search Multiplexes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </section>  
@endsection
