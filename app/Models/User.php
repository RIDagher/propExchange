<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function agent() {
        return $this->belongsTo(User::class, 'agentId', 'userId');
    }
}