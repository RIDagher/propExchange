<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $primaryKey = 'imageId';

    protected $fillable = [
        'propertyId', 'imagePath', 'mainImage'
    ];

    // Query to get main Images
    public function mainImage($query) {
        return $query->where('mainImage', true);
    }
}