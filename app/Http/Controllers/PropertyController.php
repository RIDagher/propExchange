<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{

    // Show property creation form
    public function create() {
        return view('create-property', [
            'agents' => User::where('role', 'agent')->get()
        ]);
    }
    // Create a property
    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string|regex:/^[a-zA-Z0-9,! -]{1,255}$/',
            'description' => 'required|string|regex:/^[a-zA-Z0-9,.!@ -]+$/',
            'price' => 'required|numeric|regex:/^\d{1,10}([.,]\d{2})?$/',
            'address' => 'required|string|max:255|regex:/^\d{1,5}\s[A-Za-z\s\-.]+$/',
            'city' => 'required|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'province' => 'required|string|max:100|regex:/^[A-Za-z\s\-.]+$/',
            'postalCode' => 'required|string|max:7|regex:/^[A-Z]\d[A-Z] \d[A-Z]\d$/i',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'agentId' => 'required|exists:users,userId,role,agent',
            'propertyType' => 'required|in:House,Condo,Cottage,Multiplex',
            'floors' => 'required|integer',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'squareFootage' => 'required|numeric',
            'yearBuilt' => 'required|integer',
            'isGarage' => 'boolean',
        ]);

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
    public function edit($propertyId) {
        $property = Property::findOrFail($propertyId);
        if (Auth::id() !== $property->agentId) {
            return back()->with('error', 'Unauthorized');
        }

        return view('edit-property', [
            'property' => $property,
            'agent' => User::where('role', 'agent')->get()
        ]);
    }
    // Update a property
    public function update(Request $request, $propertyId) {
        $property = Property::findOrFail($propertyId);
        $user = Auth::user();

        if ($user->userId !== $property->agentId) {
            return back()->with('error', 'Only an agent can edit a property');
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|regex:/^[a-zA-Z0-9,! -]{1,255}$/',
            'description' => 'sometimes|string|regex:/^[a-zA-Z0-9,.!@ -]+$/',
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
    public function destroy($propertyId) {
        $property = Property::findOrFail($propertyId);

        if (Auth::id() !== $property->agentId) {
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
    public function index() {
        return view('search-properties', [
            'properties' => Property::all()
        ]);
    }

    // Show single property
    public function show($propertyId) {
        $property = Property::with(['agent', 'images'])->findOrFail($propertyId);
        return view('show-property', compact('property'));
    }

    // Show properties by user
    public function userProperties($userId) {
        if (Auth::id() != $userId) {
            abort(403);
        }

        return view('properties.user', [
            'properties' => Property::where('ownerId', $userId)->latest()->get(),
            'user' => User::findOrFail($userId)
        ]);
    }

    // Check if user is an agent or client to view they're properties
    public function myProperties() {
        $user = Auth::user();

        if ($user->role === 'agent') {
            $properties = Property::where('agentId', $user->userId)->get();
        } else {
            $properties = Property::where('ownerId', $user->userId)->get();
        }

        return view('my-properties', [
            'properties' => $properties,
            'user' => $user
        ]);
    }

    // Search properties
    public function search(Request $request) {
        
        $query = property::query();

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('type')) {
            $query->where('propertyType', $request->type);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->filled('min-price')) {
            $query->where('price', '>=', $request->{'min-price'});
        }

        if ($request->filled('max-price')) {
            $query->where('price', '<=', $request->{'max-price'});
        }

        if ($request->filled('yearBuilt')) {
            $query->where('yearBuilt', $request->yearBuilt);
        }

        if ($request->filled('isGarage')) {
            $query->where('isGarage', true);
        }

        $properties = $query->orderBy('createdAT', 'desc')->paginate(10);

        return view('search-properties', compact('properties'));
    }

    // Show add agent form
    public function showAddAgentForm($propertyId) {
        $property = Property::findOrFail($propertyId);
        
        if (Auth::id() !== $property->ownerId) {
            abort(403, 'Unauthorized action.');
        }

        $agents = User::where('role', 'agent')->get();
        
        return view('add-agent', [
            'property' => $property,
            'agents' => $agents
        ]);
    }

    // Assign agent to property
    public function addAgent(Request $request, $propertyId) {
        $property = Property::findOrFail($propertyId);
        
        if (Auth::id() !== $property->ownerId) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'agentId' => 'required|exists:users,userId,role,agent'
        ]);

        try {
            $property->update(['agentId' => $validatedData['agentId']]);
            
            return redirect()->route('properties.my')
                ->with('success', 'Agent added successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add agent: ' . $e->getMessage());
        }
    }

    // get all properties for map
    public function mapView() {
        $properties = Property::all();

        return view('map-properties', [
            'properties' => $properties
        ]);
    }

    // Landing search bar
    public function landingSearch(Request $request) {
        
        $keyword = $request->input('keyword');

        $properties = Property::where('city', 'like', "%{keyword}%")
                            ->orderBy('createdAT', 'desc')
                            ->paginate(10);

        return view('landing-search-results', compact('properties'));        
    }
}
