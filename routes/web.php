<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\SocialAuthController;

// Get CSRF token to pass for other postman request
Route::get('/csrf-token', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

// Views
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register.submit');

Route::get('/properties/create', function () {
    return view('create');
})->name('create');

Route::get('/search-properties', function () {
    return view('search-properties');
})->name('search-properties');

// Added Route to show all properties on map
Route::get('/map-properties', [PropertyController::class, 'mapView'])->name('map-properties');
Route::get('/properties-query', [PropertyController::class, 'search'])->name('properties-query');
Route::get('/user-agents-query', [PropertyController::class, 'searchAgents'])->name('user-agents-query');

// Property views
Route::prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'showOrCreate'])->name('properties');
    Route::get('/index', [PropertyController::class, 'index'])->name('index');
    Route::get('/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/{property}/add-image', [PropertyImageController::class, 'create'])->name('properties.images.create');
});

// Guest actions
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Google 
Route::get('/login/google', [SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // User profile routes
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [UserController::class, 'delete'])->name('profile.delete');

    // Property management routes
    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::post('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update');
    Route::post('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');

    // Image
    Route::post('/properties/{property}/images', [PropertyImageController::class, 'store'])->name('properties.images.store');
    Route::post('/images/{image}/delete', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
});
