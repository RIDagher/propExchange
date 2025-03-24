<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model {
    use HasFactory;

    protected $primaryKey = 'propertyId';
    protected $fillable = [
        'title', 'description', 'price', 'address', 'city', 'province', 
        'postalCode', 'latitude', 'longitude', 'ownerId', 'agentId', 'isSold', 
        'propertyType', 'floors', 'bedrooms', 'bathrooms', 'squareFootage', 
        'yearBuilt', 'isGarage'
    ];
    
    public $timestamps = false;

    public function images() {
        return $this->hasMany(PropertyImage::class, 'propertyId');
    }
}