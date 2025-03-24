<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller {
    
    // Upload another image
    public function store(Request $request, $propertyId) {
        $validatedData = $request->validate([
            'imagePath' => 'required|string',
            'mainImage' => 'sometimes|boolean',
        ]);

        $validatedData['propertyId'] = $propertyId;

        $image = PropertyImage::create($validatedData);

        return response()->json($image, 201);
    }

    // Delete an image
    public function destroy($imageId) {
        $image = PropertyImage::find($imageId);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }

    // Get all images from propertyId
    public function index($propertyId) {
        $images = PropertyImage::where('propertyId', $propertyId)->get();
        return response()->json($images);
    }

    // Get image by id
    public function show($imageId) {
        $image = PropertyImage::find($imageId);

        if ($image) {
            return response()->json($image);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }
}
