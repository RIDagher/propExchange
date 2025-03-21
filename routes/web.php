<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Get CSRF token to pass for other postman request
Route::get('/csrf-token', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

// Register a new user
Route::post('/register', [UserController::class, 'register']);

// Update an existing user
Route::put('/users/{userId}', [UserController::class, 'update']);

// Delete a user
Route::delete('/users/{userId}', [UserController::class, 'delete']);

// Get a user by id
Route::get('/users/{userId}', [UserController::class, 'show']);

// Get a user by username
Route::get('/users/username/{username}', [UserController::class, 'getByUsername']);