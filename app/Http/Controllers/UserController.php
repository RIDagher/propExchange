<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get a user by their ID.
     */
    public function show($userId)
    {
        $user = User::getUserById($userId);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Get a user by their username.
     */
    public function getByUsername(Request $request)
    {
        $username = $request->input('username');
        $user = User::getUserByUsername($username);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Get all users with a specific role.
     */
    public function getByRole($role)
    {
        $users = User::getUsersByRole($role);

        return response()->json($users);
    }
}