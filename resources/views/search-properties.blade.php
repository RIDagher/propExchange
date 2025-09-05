@extends('layouts.app')
@section('title', 'Search Properties')

@section('content')
<div class="container mt-4">
  <form method="GET" action="{{route('search-properties')}}" class="row g-3 align-items-end bg-light p-4 rounded shadow">
    <div class="col-md-3">
      <input type="text" name="city" class="form-control" placeholder="City">
    </div>
    <div class="col-md-3">
      <input type="text" name="title" class="form-control" placeholder="title">
    </div>

    <!-- Type search -->
    <div class="col-md-2">
      <select name="type" class="form-select">
        <option value="">Type</option>
        <option value="House">House</option>
        <option value="Condo">Condo</option>
        <option value="Cottage">Cottage</option>
        <option value="Multiplex">Myltiplex</option>
      </select>
    </div>

    <!-- bedrooms -->
    <div class="col-md-2">
      <select name="bedrooms" class="form-select">
        <option value="">Bedrooms</option>
        @for($i =1; $i <= 5; $i++)
          <option value="{{$i}}">{{$i}}+</option>
          @endfor
      </select>
    </div>

    <!-- Bathrooms -->
    <div class="col-md-2">
      <select name="bathrooms" class="form-select">
        <option value="">Bathrooms</option>
        @for($i =1; $i <= 5; $i++)
          <option value="{{$i}}">{{$i}}+</option>
          @endfor
      </select>
    </div>

    <!-- Price Range -->
    <div class="col-md-2">
      <input type="number" name="min-price" class="form-control" placeholder="Min Price">
    </div>
    <div class="col-md-2">
      <input type="number" name="max-price" class="form-control" placeholder="Max Price">
    </div>

    <!-- Year Built -->
    <div class="col-md-2">
      <input type="number" name="year_built" class="form-control" placeholder="Year Built">
    </div>

    <!-- Has Garage -->
    <div class="col-md-2 form-check">
      <input class="form-check-input" type="checkbox" name="isGarage" value="1" id="garageCheck">
      <label class="form-check-label" for="garageCheck">
        Has Garage
      </label>
    </div>

    <!-- Search -->
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-primary px-5 mt-2"><i class="bi bi-search"></i>Search</button>
    </div>
  </form>

  <!-- View Map Button -->
  <div class="text-end mt-2">
    <a href="{{ route('map-properties') }}" class="btn btn-outline-primary">
      <i class="bi bi-map"></i> View Map
    </a>
  </div>
</div>
</div>
@if(isset($properties) && $properties->count())
<div class="container">
  <h4>Search Results:</h4>

  <div class="row">
    @foreach($properties as $property)
    <div class="col-md-4 mb-4">
      <div class="card h-100 bg-light p-4 rounded shadow">
          @if($property->images->first())
              <img src="{{ image_url($property->images->first()->imagePath) }}" class="card-img-top" alt="{{ $property->title }}">
          @else
            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
              No Image Available
            </div>
          @endif
            <div class="card-body">
                <h5 class="card-title">{{ $property->title }}</h5>
                <p class="card-text"><strong>Price:</strong> ${{ number_format($property->price) }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $property->address }}, {{ $property->city }}, {{ $property->province }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $property->propertyType }}</p>
                <div class="d-flex justify-content-between">
                    <span><strong>Beds:</strong> {{ $property->bedrooms }}</span>
                    <span><strong>Baths:</strong> {{ $property->bathrooms }}</span>
                    <span><strong>Sqft:</strong> {{ $property->squareFootage }}</span>
                </div>
                <a href="{{ route('properties.show', $property->propertyId) }}" class="btn btn-primary mt-3">View Property</a>
            </div>
        </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center">
    {{ $properties->links() }}
  </div>
</div>
@elseif(request()->all())
<div class="alert alert-warning mt-4">
  No properties matched your search.
</div>
@endif
@endsection