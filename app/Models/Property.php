<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $primaryKey = 'propertyId';
    protected $fillable = [
        'title', 'description', 'price', 'address', 'city', 'province', 
        'postalCode', 'latitude', 'longitude', 'agentId', 'isSold', 
        'propertyType', 'floors', 'bedrooms', 'bathrooms', 'squareFootage', 
        'yearBuilt', 'isGarage'
    ];

    // Get agent of a property
    public function agent() {
        return $this->belongsTo(User::class, 'agentId');
    }

    // Get all images of a property
    public function images() {
        return $this->hasMany(PropertyImage::class, 'propertyId');
    }

    // Show all sold properties
    public function scopeSold($query) {
        return $query->where('isSold', true);
    }

    // Show all pruchasable properties
    public function scopeUnsold($query) {
        return $query->where('isSold', false);
    }

    // Show properties by type
    public function scopeOfType($query, $type) {
        return $query->where('propertyType', $type);
    }
}