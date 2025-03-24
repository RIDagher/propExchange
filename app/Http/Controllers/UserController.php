<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Register a new user
    public function register(Request $request) {
        try {
            $validatedData = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'regex:/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/',
                    'unique:users,username'],
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/'],
                'role' => 'required|in:agent,client', 
            ], 
            [
                'username.regex' => 'The username may only contain letters, numbers, and underscores.',
                'email.regex' => 'The email is in an invalid format.',
                'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $error) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $error->errors(),
            ], 422);
        }

        try {
            $user = User::create($validatedData);

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
            ], 201);

        } catch (\Exception $error) {
            return response()->json([
                'message' => 'An unexpected error occurred during registration.',
                'error' => $error->getMessage(),
            ], 500);
        }
    }


    // Login a user
    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();
    
            $sessionCookie = config('session.cookie');
            $sessionId = $request->session()->getId();

            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
                'session' => [
                    'cookie_name' => $sessionCookie,
                    'session_id' => $sessionId,
                ],
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    // Logout a user
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful']);
    }


    // Update a user
    public function update(Request $request, $userId) {
        try {
            $user = User::find($userId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'username' => [
                'sometimes',
                'string',
                'regex:/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/',
                'unique:users,username,' . $userId . ',userId'],
            'email' => 'sometimes|email|unique:users,email,' . $userId . ',userId',
            'password' => [
                'sometimes',
                'string',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
            ],
            'role' => 'sometimes|in:agent,client',
        ],
        [
            'username.regex' => 'The username may only contain letters, numbers, and underscores.',
            'email.regex' => 'The email is in an invalid format.',
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number.',
        ]);

        try {
            $user->update($validatedData);
            return response()->json($user);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }


    // Delete a user
    public function delete($userId) {
        try {
            $user = User::find($userId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'User deleted']);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }


    // Get a user by id
    public function show($userId) {
        try {
            $user = User::find($userId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    
    // Get a user by username
    public function getByUsername($username) {
        try {
            $user = User::where('username', $username)->first();
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}