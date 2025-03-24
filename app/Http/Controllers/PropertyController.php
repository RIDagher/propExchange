<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller {
    // create, update and delete methods
    // Create a property
    public function store(Request $request) {
        try {    
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
                'ownerId' => 'required|exists:users,userId',
                'agentId' => 'required|exists:users,userId',
                'isSold' => 'boolean',
                'propertyType' => 'required|in:House,Condo,Cottage,Multiplex',
                'floors' => 'required|integer',
                'bedrooms' => 'required|integer',
                'bathrooms' => 'required|integer',
                'squareFootage' => 'required|numeric',
                'yearBuilt' => 'required|integer',
                'isGarage' => 'boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $error) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $error->errors(),
            ], 422);
        }
    
        try { 
            $property = Property::create($validatedData);
            return response()->json($property, 201);

        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }

    // Update a property
    public function update(Request $request, $propertyId) {
        try {
            $property = Property::find($propertyId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        try {
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
                'ownerId' => 'sometimes|exists:users,userId',
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
        } catch (\Illuminate\Validation\ValidationException $error) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $error->errors(),
            ], 422);
        }

        try {
            $property->update($validatedData);
            return response()->json($property);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }

    // Delete a property
    public function destroy($propertyId) {
        try {
            $property = Property::find($propertyId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        try {
            $property->delete();
            return response()->json(['message' => 'Property deleted']);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }


    // Get methods
    // Get Property by owner id
    public function getByOwner($ownerId) {
        try {
            $validUser = User::find($ownerId);
            if (!$validUser) {
                return response()->json(['message' => 'Owner not found'], 404);
            } else if ($validUser->role !== 'client') {
                return response()->json(['message' => 'User is not a client'], 400);
            }

            $properties = Property::where('ownerId', $ownerId)->get();
            return response()->json($properties);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }

    // Get property by agent id
    public function getByAgent($agentId) {
        try {
            $validUser = User::find($agentId);
            if (!$validUser) {
                return response()->json(['message' => 'Agent not found'], 404);
            } else if ($validUser->role !== 'agent') {
                return response()->json(['message' => 'User is not a agent'], 400);
            }

            $properties = Property::where('agentId', $agentId)->get();
            return response()->json($properties);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }
    }

    // Get property by id
    public function show($propertyId) {
        try {
            $property = Property::find($propertyId);
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json($property);
    }

    // Get all properties
    public function index() {
        try {
            $properties = Property::all();
        } catch (\Exception $error) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $error->getMessage()], 500);
        }

        return response()->json($properties);
    }
}