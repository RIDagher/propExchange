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
    // return view to create an image
    public function create($propertyId) {
        return view('add-image', [
            'property' => Property::findOrFail($propertyId)
        ]);
    }

    // Upload an image
    public function store(Request $request, $propertyId) {
        $property = Property::findOrFail($propertyId);
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048',
            'mainImage' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $image = $request->file('image');
        $validationError = $this->validateImage($image);
        if ($validationError) {
            return back()->with('error', $validationError);
        }

        try {
            $filename = $this->generateUniqueFilename($property, $image);
            $path = $this->processAndStoreImage($image, $filename);
            
            $imageRecord = PropertyImage::create([
                'propertyId' => $propertyId,
                'path' => $path,
                'mainImage' => $request->mainImage ?? false
            ]);

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
        
        Storage::delete('public/' . $image->path);
        
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

    // Function to validate image type and size
    private function validateImage($image) {
        list($width, $height) = getimagesize($image->getPathname());
        
        if ($width < 100 || $width > 1000 || $height < 100 || $height > 1000) {
            return "Width and height must be within 100-1000 pixels range";
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image->getMimeType(), $allowedMimes)) {
            return "Only JPG, PNG and GIF file types are accepted";
        }

        return null;
    }

    // Function to rename image file path
    private function generateUniqueFilename($property, $image) {
        $extension = $image->getClientOriginalExtension();
        $lastImageId = PropertyImage::max('id') ?? 0;
        
        return sprintf('%d_%d_%d.%s',
            $property->propertyId,
            $property->ownerId,
            $lastImageId + 1,
            $extension
        );
    }

    // Function to upload image in image folder
    private function processAndStoreImage($image, $filename) {
        $img = Image::make($image->getRealPath());
        
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $path = 'property_images/' . $filename;
        Storage::put('public/' . $path, $img->stream());
        
        return $path;
    }
}