<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class PropertyImageController extends Controller
{
    // Upload an image
    public function store(Request $request, $propertyId) {
        // Validate property exists
        $property = Property::findOrFail($propertyId);
        
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048', // 2MB max
            'mainImage' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Additional image validation
        $image = $request->file('image');
        $validationError = $this->validateImage($image);
        if ($validationError) {
            return back()->with('error', $validationError);
        }

        try {
            // Generate unique filename
            $filename = $this->generateUniqueFilename($property, $image);
            
            // Process and store the image
            $path = $this->processAndStoreImage($image, $filename);
            
            // Create database record
            $imageRecord = PropertyImage::create([
                'propertyId' => $propertyId,
                'path' => $path,
                'mainImage' => $request->mainImage ?? false
            ]);

            // If this is the main image, unset others
            if ($imageRecord->mainImage) {
                PropertyImage::where('propertyId', $propertyId)
                    ->where('id', '!=', $imageRecord->id)
                    ->update(['mainImage' => false]);
            }

            return back()->with('success', 'Image uploaded successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

    // Delete an image
    public function destroy($imageId) {
        $image = PropertyImage::findOrFail($imageId);
        
        // Delete file from storage
        Storage::delete('public/' . $image->path);
        
        // Delete record
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully');
    }

    // Get all images for a property
    public function index($propertyId) {
        $property = Property::findOrFail($propertyId);
        return view('properties.images', [
            'property' => $property,
            'images' => $property->images
        ]);
    }

    // Helper methods
    private function validateImage($image) {
        // Check image dimensions
        list($width, $height) = getimagesize($image->getPathname());
        
        if ($width < 100 || $width > 1000 || $height < 100 || $height > 1000) {
            return "Width and height must be within 100-1000 pixels range";
        }

        // Check MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image->getMimeType(), $allowedMimes)) {
            return "Only JPG, PNG and GIF file types are accepted";
        }

        return null;
    }

    private function generateUniqueFilename($property, $image) {
        $extension = $image->getClientOriginalExtension();
        $lastImageId = PropertyImage::max('id') ?? 0;
        
        // Format: propertyId_ownerId_imageId.extension
        return sprintf('%d_%d_%d.%s',
            $property->propertyId,
            $property->ownerId,
            $lastImageId + 1,
            $extension
        );
    }

    private function processAndStoreImage($image, $filename) {
        // Create intervention image instance
        $img = Image::make($image->getRealPath());
        
        // Resize if needed (maintain aspect ratio)
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Store the image
        $path = 'property_images/' . $filename;
        Storage::put('public/' . $path, $img->stream());
        
        return $path;
    }
}