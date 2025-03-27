@extends('layouts.app')

@section('title', 'Login - PropExchange')

@section('content')
<div class="container mt-4">
  <h1 class="text-center">Add a property</h1>

  <form id="propertyForm" method="POST" action="{{route('properties.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" name="title" id="title">
      <div class="invalid-feedback" id="error-title"></div>
    </div>

    <div class="mb-3">
      <lable for="description" class="form-label">Description</lable>
      <textarea class="form-control" name="description" rows="3" id="description"></textarea>
      <div class="invalid-feedback" id="error-description"></div>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price</label>
      <input type="number" class="form-control" name="price" step="0.01" id="price">
      <div class="invalid-feedback" id="error-price"></div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" name="address" id="address">
        <div class="invalid-feedback" id="error-address"></div>
      </div>

      <div class="col-md-3 mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" name="city" id="city">
        <div class="invalid-feedback" id="error-city"></div>
      </div>

      <div class="col-md-3 mb-3">
        <label for="province" class="form-label">Province</label>
        <input type="text" class="form-control" name="province" id="province">
        <div class="invalid-feedback" id="error-province"></div>
      </div>
    </div>

    <div class="mb-3">
      <label for="postalCode" class="form-label">Postal Code</label>
      <input type="text" class="form-control" name="postalCode" id="postalCode">
      <div class="invalid-feedback" id="error-postalCode"></div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="latitude" class="form-label">Latitude</label>
        <input type="number" step="any" class="form-control" name="latitude" id="latitude">
      </div>
      <div class="col-md-6 mb-3">
        <label for="longitude" class="form-label">Longitude</label>
        <input type="number" step="any" class="form-control" name="longitude" id="longitude">
      </div>
    </div>

    <!-- Dropdowns -->
    <div class="mb-3">
      <label for="propertyType" class="form-label">Property Type</label>
      <select class="form-select" name="propertyType" id="propertyType">
        <option value="">Select Type</option>
        <option value="House">House</option>
        <option value="Condo">Condo</option>
        <option value="Cottage">Cottage</option>
        <option value="Multiplex">Multiplex</option>
      </select>
    </div>

    <div class="row">
      <div class="col-md-3 mb-3">
        <label for="floors" class="form-label">Floors</label>
        <input type="number" class="form-control" name="floors" id="floors">
      </div>
      <div class="col-md-3 mb-3">
        <label for="bedrooms" class="form-label">Bedrooms</label>
        <input type="number" class="form-control" name="bedrooms" id="bedrooms">
      </div>
      <div class="col-md-3 mb-3">
        <label for="bathrooms" class="form-label">Bathrooms</label>
        <input type="number" class="form-control" name="bathrooms" id="bathrooms">
      </div>
      <div class="col-md-3 mb-3">
        <label for="squareFootage" class="form-label">Square Footage</label>
        <input type="number" class="form-control" name="squareFootage" id="squareFootage">
      </div>
    </div>

    <div class="mb-3">
      <label for="yearBuilt" class="form-label">Year Built</label>
      <input type="number" class="form-control" name="yearBuilt" id="yearBuilt">
    </div>

    <div class="mb-3 form-check">
      <input type="hidden" name="isGarage" value="0">
      <input type="checkbox" class="form-check-input" name="isGarage" value="1">
      <label class="form-check-label" for="isGarage">Garage Available</label>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Upload Property Images</label>
      <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
    </div>

    <input type="hidden" name="ownerId" value="1">
    <input type="hidden" name="agentId" value="2">
    <input type="hidden" name="isSold" value="0">

    <button type="submit" class="btn btn-success">Add Property</button>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
      <div id="successToast" class="toast align-items-center text-bg-success border 0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            ✅ Property added successfully!
          </div>
          <button type="button" class="btn btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="close"></button>
        </div>
      </div>
    </div>
  </form>


</div>
@section('scripts')
<script src="{{ asset('addProperty.js') }}"></script>
@endsection

@endsection