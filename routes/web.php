<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/search-properties', function () {
    $properties = [
        ["type" => "House", "price" => 750000, "city" => "Toronto", "image" => "https://via.placeholder.com/300", "lat" => "43.6532", "lng" => "-79.3832"],
        ["type" => "Condo", "price" => 650000, "city" => "Vancouver", "image" => "https://via.placeholder.com/300", "lat" => "49.2827", "lng" => "-123.1207"],
        ["type" => "Cottage", "price" => 450000, "city" => "Quebec City", "image" => "https://via.placeholder.com/300", "lat" => "46.8139", "lng" => "-71.2082"],
    ];

    return view('search-properties', compact('properties'));
})->name('search.properties');

Route::get('/search-map', function () {
    return view('search-map');
})->name('search.map');
