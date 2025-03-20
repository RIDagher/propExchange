<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Get all properties.
     */
    public function index()
    {
        $properties = Property::all();
        return response()->json($properties);
    }

    /**
     * Get a specific property by ID.
     */
    public function show($propertyId)
    {
        $property = Property::find($propertyId);

        if ($property) {
            return response()->json($property);
        }

        return response()->json(['message' => 'Property not found'], 404);
    }

    /**
     * Create a new property.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postalCode' => 'required|string|max:7',
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

        $property = Property::create($validatedData);

        return response()->json($property, 201);
    }

    /**
     * Update a property.
     */
    public function update(Request $request, $propertyId)
    {
        $property = Property::find($propertyId);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'province' => 'sometimes|string|max:100',
            'postalCode' => 'sometimes|string|max:7',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'agentId' => 'sometimes|exists:users,userId',
            'propertyType' => 'sometimes|in:House,Condo,Cottage,Multiplex',
            'floors' => 'sometimes|integer',
            'bedrooms' => 'sometimes|integer',
            'bathrooms' => 'sometimes|integer',
            'squareFootage' => 'sometimes|numeric',
            'yearBuilt' => 'sometimes|integer',
            'isGarage' => 'sometimes|boolean',
        ]);

        $property->update($validatedData);

        return response()->json($property);
    }

    /**
     * Delete a property.
     */
    public function destroy($propertyId)
    {
        $property = Property::find($propertyId);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $property->delete();

        return response()->json(['message' => 'Property deleted']);
    }
}