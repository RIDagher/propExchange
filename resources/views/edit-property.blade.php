@extends('layouts.app')
@section('title', 'Edit Property')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Property</h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('properties.update', $property->propertyId) }}">
                        @csrf
                        @method('POST')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $property->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $property->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $property->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       id="address" name="address" value="{{ old('address', $property->address) }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $property->city) }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="province" class="form-label">Province</label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                       id="province" name="province" value="{{ old('province', $property->province) }}" required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="postalCode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control @error('postalCode') is-invalid @enderror" 
                                       id="postalCode" name="postalCode" value="{{ old('postalCode', $property->postalCode) }}" required>
                                @error('postalCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="propertyType" class="form-label">Property Type</label>
                                <select class="form-select @error('propertyType') is-invalid @enderror" 
                                        id="propertyType" name="propertyType" required>
                                    <option value="House" {{ old('propertyType', $property->propertyType) == 'House' ? 'selected' : '' }}>House</option>
                                    <option value="Condo" {{ old('propertyType', $property->propertyType) == 'Condo' ? 'selected' : '' }}>Condo</option>
                                    <option value="Cottage" {{ old('propertyType', $property->propertyType) == 'Cottage' ? 'selected' : '' }}>Cottage</option>
                                    <option value="Multiplex" {{ old('propertyType', $property->propertyType) == 'Multiplex' ? 'selected' : '' }}>Multiplex</option>
                                </select>
                                @error('propertyType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="yearBuilt" class="form-label">Year Built</label>
                                <input type="number" class="form-control @error('yearBuilt') is-invalid @enderror" 
                                       id="yearBuilt" name="yearBuilt" value="{{ old('yearBuilt', $property->yearBuilt) }}" required>
                                @error('yearBuilt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="squareFootage" class="form-label">Square Footage</label>
                                <input type="number" class="form-control @error('squareFootage') is-invalid @enderror" 
                                       id="squareFootage" name="squareFootage" value="{{ old('squareFootage', $property->squareFootage) }}" required>
                                @error('squareFootage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" 
                                       id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" required>
                                @error('bedrooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" 
                                       id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" required>
                                @error('bathrooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <label for="floors" class="form-label">Floors</label>
                                <input type="number" class="form-control @error('floors') is-invalid @enderror" 
                                       id="floors" name="floors" value="{{ old('floors', $property->floors) }}" required>
                                @error('floors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-check mt-4 pt-2">
                                    <input class="form-check-input" type="checkbox" id="isGarage" name="isGarage" 
                                           value="1" {{ old('isGarage', $property->isGarage) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isGarage">
                                        Has Garage
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-check mt-4 pt-2">
                                    <input class="form-check-input" type="checkbox" id="isSold" name="isSold" 
                                           value="1" {{ old('isSold', $property->isSold) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isSold">
                                        Mark as Sold
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePropertyModal">
                                Delete Property
                            </button>
                            
                            <div>
                                <a href="{{ route('properties.my') }}" class="btn btn-outline-secondary me-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePropertyModal" tabindex="-1" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deletePropertyModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to permanently delete this property? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('properties.destroy', $property->propertyId) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger">Delete Property</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection