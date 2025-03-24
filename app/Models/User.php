<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable {
    use HasFactory;

    protected $primaryKey = 'userId';
    protected $fillable = [
        'username', 'email', 'password', 'role'
    ];
    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    // Automatically hash the user password
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}