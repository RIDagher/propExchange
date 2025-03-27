@extends('layouts.app')
@section('title', $property->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold">{{ $property->title }}</h1>
            <p class="text-muted">{{ $property->address }}, {{ $property->city }}, {{ $property->province }}, {{ $property->postalCode }}</p>
            
            <div class="d-flex align-items-center mb-4">
                <span class="badge bg-{{ $property->isSold ? 'danger' : 'success' }} me-3">
                    {{ $property->isSold ? 'Sold' : 'For Sale' }}
                </span>
                <h2 class="mb-0">${{ number_format($property->price) }}</h2>
            </div>

            <div class="property-details mb-5">
                <h3 class="mb-3">Property Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Property Type</span>
                                <span>{{ $property->propertyType }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Bedrooms</span>
                                <span>{{ $property->bedrooms }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Bathrooms</span>
                                <span>{{ $property->bathrooms }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Square Footage</span>
                                <span>{{ $property->squareFootage }} sqft</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Floors</span>
                                <span>{{ $property->floors }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Year Built</span>
                                <span>{{ $property->yearBuilt }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{ $property->isGarage ? 'checked' : '' }} disabled>
                            <label class="form-check-label">
                                Has Garage
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="property-description mb-5">
                <h3 class="mb-3">Description</h3>
                <p class="lead">{{ $property->description }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Contact Agent</h5>
                </div>
                <div class="card-body">
                    @if($property->agent)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($property->agent->name) }}&background=random" 
                                     class="rounded-circle" width="60" height="60">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>{{ $property->agent->name }}</h5>
                                <p class="text-muted mb-1">Real Estate Agent</p>
                                <p class="mb-0"><i class="bi bi-telephone"></i> {{ $property->agent->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" placeholder="Your Phone">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" placeholder="Your Message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    @else
                        <p class="text-muted">No agent assigned to this property.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @auth
        @if(Auth::id() === $property->ownerId || Auth::user()->role === 'agent')
            <div class="mt-5 d-flex justify-content-end gap-2">
                <a href="{{ route('properties.edit', $property->propertyId) }}" class="btn btn-outline-primary">
                    Edit Property
                </a>
                <a href="{{ route('properties.images.create', $property->propertyId) }}" class="btn btn-outline-secondary">
                    Add Images
                </a>
            </div>
        @endif
    @endauth
</div>
@endsection

@section('scripts')
@if(config('services.google.maps_key'))
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const mapElement = document.getElementById('propertyMap');
        const lat = parseFloat(mapElement.dataset.lat);
        const lng = parseFloat(mapElement.dataset.lng);
        
        const propertyLocation = { lat: lat, lng: lng };
        const map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: propertyLocation
        });
        
        new google.maps.Marker({
            position: propertyLocation,
            map: map,
            title: '{{ $property->title }}'
        });
    }
</script>
@endif
@endsection