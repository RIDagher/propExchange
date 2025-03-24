<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyImageController;

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

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/search-map', [PropertyController::class, 'mapSearch'])->name('properties.map-search');


// Guest actions
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Protected routes
Route::middleware('auth')->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    // User profile routes
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [UserController::class, 'delete'])->name('profile.delete');
    
    // Property management routes
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::post('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update');
    Route::post('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');

    // Client or agent properties
    Route::get('/properties/user/{user}', [PropertyController::class, 'userProperties'])->name('properties.user');

    // Image management
    Route::get('/properties/{property}/images', [PropertyImageController::class, 'index'])->name('properties.images');
    Route::post('/properties/{property}/images', [PropertyImageController::class, 'store'])->name('properties.images.store');
    Route::post('/images/{image}/delete', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
});