<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    // Specify the primary key
    protected $primaryKey = 'imageId';

    // Fields that can be mass-assigned
    protected $fillable = [
        'propertyId', 'imagePath', 'mainImage'
    ];

    /**
     * Scope a query to only include main images.
     */
    public function scopeMainImage($query)
    {
        return $query->where('mainImage', true);
    }
}