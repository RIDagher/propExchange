<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // Specify the primary key
    protected $primaryKey = 'propertyId';

    // Fields that can be mass-assigned
    protected $fillable = [
        'title', 'description', 'price', 'address', 'city', 'province', 
        'postalCode', 'latitude', 'longitude', 'agentId', 'isSold', 
        'propertyType', 'floors', 'bedrooms', 'bathrooms', 'squareFootage', 
        'yearBuilt', 'isGarage'
    ];

    // Timestamps (createdAt and updatedAt)
    public $timestamps = true;

    // Custom timestamp column names (optional)
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * Get the agent (user) who listed the property.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agentId');
    }

    /**
     * Get all images for the property.
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'propertyId');
    }

    /**
     * Scope a query to only include sold properties.
     */
    public function scopeSold($query)
    {
        return $query->where('isSold', true);
    }

    /**
     * Scope a query to only include unsold properties.
     */
    public function scopeUnsold($query)
    {
        return $query->where('isSold', false);
    }

    /**
     * Scope a query to filter properties by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('propertyType', $type);
    }
}