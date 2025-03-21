@extends('layouts.app')
@section('title', 'Search Properties')

@section('content')
<div class="container mt-4">
  <h1 class="text-center">Find a Property</h1>

  <!-- Search Form -->
  <form method="GET" action="{{ route('search.properties') }}" class="bg-light p-3 rounded shadow">
    <div class="row g-2">
      <div class="col-md-3">
        <input type="text" name="title" class="form-control" placeholder="Property Title">
      </div>
      <div class="col-md-3">
        <input type="text" name="city" class="form-control" placeholder="City">
      </div>
      <div class="col-md-2">
        <select name="property_type" class="form-select">
          <option value="">Type</option>
          <option value="House">House</option>
          <option value="Condo">Condo</option>
          <option value="Cottage">Cottage</option>
        </select>
      </div>
      <div class="col-md-3">
        <select id="priceRange" class="form-select">
          <option value="">Price Range</option>
          <option value="0-250000">Up to $250,000</option>
          <option value="250000-500000">$250,000 - $500,000</option>
          <option value="500000-750000">$500,000 - $750,000</option>
          <option value="750000-1000000">$750,000 - $1M</option>
          <option value="1000000+">Over $1M</option>
        </select>
      </div>
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-search"></i> Search</button>
      </div>

      <!-- View Map Button -->
      <div class="text-end mt-2">
        <a href="{{ route('search.map') }}" class="btn btn-outline-primary">
          <i class="bi bi-map"></i> View Map
        </a>
      </div>
    </div>
  </form>

  <!-- Search Results -->
  <div class="row mt-4">
    @if(count($properties) > 0)
    @foreach ($properties as $property)
    <div class="col-md-4 mb-4">
      <div class="card">
        <img src="{{ $property['image'] }}" class="card-img-top" alt="Property">
        <div class="card-body">
          <h5 class="card-title">${{ number_format($property['price']) }}</h5>
          <p class="card-text">{{ $property['type'] }}, {{ $property['city'] }}</p>
          <a href="#" class="btn btn-primary">View Details</a>
        </div>
      </div>
    </div>
    @endforeach
    @else
    <p class="text-center mt-4">No properties found.</p>
    @endif
  </div>
</div>
@endsection