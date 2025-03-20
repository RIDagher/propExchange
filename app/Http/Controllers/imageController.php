<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    /**
     * Get all images for a specific property.
     */
    public function index($propertyId)
    {
        $images = PropertyImage::where('propertyId', $propertyId)->get();
        return response()->json($images);
    }

    /**
     * Get a specific image by ID.
     */
    public function show($imageId)
    {
        $image = PropertyImage::find($imageId);

        if ($image) {
            return response()->json($image);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }

    /**
     * Upload a new image for a property.
     */
    public function store(Request $request, $propertyId)
    {
        $validatedData = $request->validate([
            'imagePath' => 'required|string',
            'mainImage' => 'sometimes|boolean',
        ]);

        $validatedData['propertyId'] = $propertyId;

        $image = PropertyImage::create($validatedData);

        return response()->json($image, 201);
    }

    /**
     * Delete an image.
     */
    public function destroy($imageId)
    {
        $image = PropertyImage::find($imageId);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }
}
