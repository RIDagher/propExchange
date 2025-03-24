<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller {

    // Show property creation form (GET)
    public function create()
    {
        return view('properties.create', [
            'agents' => User::where('role', 'agent')->get()
        ]);
    }

    // Create a property
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|regex:/^[a-zA-Z0-9! -]{1,255}$/',
            'description' => 'required|string|regex:/^[a-zA-Z0-9.!@ -]+$/',
            'price' => 'required|numeric|regex:/^\d{1,10}([.,]\d{2})?$/',
            'address' => 'required|string|max:255|regex:/^\d{1,5}\s[A-Za-z\s\-.]+$/',
            'city' => 'required|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'province' => 'required|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'postalCode' => 'required|string|max:7|regex:/^[A-Z]\d[A-Z] \d[A-Z]\d$/i',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'agentId' => 'required|exists:users,userId',
            'propertyType' => 'required|in:House,Condo,Cottage,Multiplex',
            'floors' => 'required|integer',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'squareFootage' => 'required|numeric',
            'yearBuilt' => 'required|integer',
            'isGarage' => 'boolean',
        ]);

        // Set ownerId to current user
        $validatedData['ownerId'] = Auth::id();
        $validatedData['isSold'] = false;

        try {
            Property::create($validatedData);
            return redirect()->route('properties.my')
                ->with('success', 'Property created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create property')->withInput();
        }
    }

    // Show property edit form
    public function edit($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        if (Auth::id() !== $property->ownerId) {
            return back()->with('error', 'Unauthorized');
        }

        return view('properties.edit', [
            'property' => $property,
            'agents' => User::where('role', 'agent')->get()
        ]);
    }

    // Update a property
    public function update(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $user = Auth::user();

        if ($user->userId !== $property->ownerId) {
            return back()->with('error', 'You can only edit your own properties');
        }


        $validatedData = $request->validate([
            'title' => 'sometimes|string|regex:/^[a-zA-Z0-9! -]{1,255}$/',
            'description' => 'sometimes|string|regex:/^[a-zA-Z0-9.!@ -]+$/',
            'price' => 'sometimes|numeric|regex:/^\d{1,10}([.,]\d{2})?$/',
            'address' => 'sometimes|string|max:255|regex:/^\d{1,5}\s[A-Za-z\s\-.]+$/',
            'city' => 'sometimes|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'province' => 'sometimes|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'postalCode' => 'sometimes|string|max:7|regex:/^[A-Z]\d[A-Z] \d[A-Z]\d$/i',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'agentId' => 'sometimes|exists:users,userId',
            'isSold' => 'sometimes|boolean',
            'propertyType' => 'sometimes|in:House,Condo,Cottage,Multiplex',
            'floors' => 'sometimes|integer',
            'bedrooms' => 'sometimes|integer',
            'bathrooms' => 'sometimes|integer',
            'squareFootage' => 'sometimes|numeric',
            'yearBuilt' => 'sometimes|integer',
            'isGarage' => 'sometimes|boolean',
        ]);

        try {
            $property->update($validatedData);
            return redirect()->route('properties.show', $propertyId)
                ->with('success', 'Property updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update property')->withInput();
        }
    }

    // Delete a property
    public function destroy($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        if (Auth::id() !== $property->ownerId) {
            abort(403);
        }

        try {
            $property->delete();
            return redirect()->route('properties.my')
                ->with('success', 'Property deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete property');
        }
    }


    // Show all properties
    public function index()
    {
        return view('properties.index', [
            'properties' => Property::latest()->paginate(10)
        ]);
    }

    // Show single property
    public function show($propertyId)
    {
        return view('properties.show', [
            'property' => Property::findOrFail($propertyId)
        ]);
    }

    // Show current user's properties
    public function myProperties()
    {
        $userId = Auth::id();
        return view('properties.my', [
            'properties' => Property::where('ownerId', $userId)->latest()->get()
        ]);
    }

    // Show properties by user
    public function userProperties($userId)
    {
        // Only allow viewing own properties unless admin
        if (Auth::id() != $userId) {
            abort(403);
        }

        return view('properties.user', [
            'properties' => Property::where('ownerId', $userId)->latest()->get(),
            'user' => User::findOrFail($userId)
        ]);
    }

    // Search properties
    public function search(Request $request)
    {
        $query = Property::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        return view('properties.search', [
            'properties' => $query->paginate(10),
            'searchTerm' => $request->search ?? ''
        ]);
    }
}