<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function() {
    return view('login');
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/search-suggestions', [PropertyController::class, 'getSuggestions']);


