<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{

    // Show property creation form
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
        return view('search-properties', [
            'properties' => Property::all()
        ]);
    }

    // Show single property
    public function show($propertyId)
    {
        return view('properties.show', [
            'property' => Property::findOrFail($propertyId)
        ]);
    }

    // Get a list of agents
    public function searchAgents()
    {
        $agents = User::where('role', 'agent')->get();
        return view('search-users-agents', ['agents' => $agents]);
    }

    // Show properties by user
    public function userProperties($userId)
    {
        if (Auth::id() != $userId) {
            abort(403);
        }

        return view('properties.user', [
            'properties' => Property::where('ownerId', $userId)->latest()->get(),
            'user' => User::findOrFail($userId)
        ]);
    }

    // Show a property specificed by propertyId or create one
    public function showOrCreate(Request $request)
    {
        if ($request->has('propertyId')) {
            return $this->show($request->propertyId);
        }

        return view('properties.create', [
            'agents' => User::where('role', 'agent')->get()
        ]);
    }

    // Check if user is an agent or client to view they're properties
    public function myProperties()
    {
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
    public function search(Request $request)
    {
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

    // get all properties for map
    public function mapView()
    {
        $properties = Property::all();

        return view('map-properties', [
            'properties' => $properties
        ]);
    }
}
