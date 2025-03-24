<?php

use Illuminate\Support\Facades\Route
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;

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

// Get CSRF token to pass for other postman request
Route::get('/csrf-token', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

// User routes

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes
Route::post('/logout', [UserController::class, 'logout']);
Route::put('/users/{userId}', [UserController::class, 'update']);
Route::delete('/users/{userId}', [UserController::class, 'delete']);
Route::get('/users/{userId}', [UserController::class, 'show']);
Route::get('/users/username/{username}', [UserController::class, 'getByUsername']);


// Property routes
Route::post('/properties', [PropertyController::class, 'store']);
Route::put('/properties/{propertyId}', [PropertyController::class, 'update']);
Route::delete('/properties/{propertyId}', [PropertyController::class, 'destroy']);
Route::get('/properties/{propertyId}', [PropertyController::class, 'show']);
Route::get('/properties ', [PropertyController::class, 'index']);