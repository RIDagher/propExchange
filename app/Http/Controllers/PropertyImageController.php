<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyImageController extends Controller {

    // Return add-image view
    public function create($propertyId) {
        return view('add-image', [
            'property' => Property::findOrFail($propertyId)
        ]);
    }
    // Add image to folder (works locally and in production with cloud storage)
    public function store(Request $request, $propertyId) {
        $property = Property::findOrFail($propertyId);
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isMain' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $image = $request->file('image');
            
            // Generate unique filename based on the current time
            $filename = time().'_'.$propertyId.'.'.$image->getClientOriginalExtension();
            
            // Always use 'public' disk for both local and production (Render)
            $path = $image->storeAs('property_images', $filename, 'public');
            
            $imageRecord = new PropertyImage();
            $imageRecord->propertyId = $propertyId;
            $imageRecord->imagePath = $path;
            $imageRecord->isMain = $request->has('isMain');
            $imageRecord->save();

            if ($imageRecord->isMain) {
                PropertyImage::where('propertyId', $propertyId)
                    ->where('imageId', '!=', $imageRecord->id)
                    ->update(['isMain' => false]);
            }

            return redirect()->route('properties.my')
                ->with('success', 'Image uploaded successfully!');

        } catch (\Exception $error) {
            return redirect()->back()
                ->with('error', 'Failed to upload image: '.$error->getMessage())
                ->withInput();
        }
    }

    // Delete an image
    public function destroy($imageId) {
        try {
            $image = PropertyImage::findOrFail($imageId);
            
            Storage::delete('public/'.$image->imagePath);
            
            $image->delete();
            
            return back()->with('success', 'Image deleted successfully');
            
        } catch (\Exception $error) {
            return back()->with('error', 'Failed to delete image: '.$error->getMessage());
        }
    }
}