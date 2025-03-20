<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'userId';

    protected $fillable = [
        'username', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * Get a user by their ID.
     */
    public static function getUserById($userId)
    {
        return self::find($userId);
    }

    /**
     * Get a user by their username.
     */
    public static function getUserByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    /**
     * Get all users with a specific role.
     */
    public static function getUsersByRole($role)
    {
        return self::where('role', $role)->get();
    }
}