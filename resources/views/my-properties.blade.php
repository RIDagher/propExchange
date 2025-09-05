@extends('layouts.app')
@section('title', 'My Properties')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold">My Properties</h1>
        @if(Auth::user()->role === 'client')
            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Property
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($properties->isEmpty())
        <div class="alert alert-info">
            @if(Auth::user()->role === 'client')
                You don't have any properties listed yet. 
                <a href="{{ route('properties.create') }}" class="alert-link">Create your first property</a>.
            @else
                You currently aren't managing any properties.
            @endif
        </div>
    @else
        <div class="row g-4">
            @foreach($properties as $property)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if($property->images->first())
                            <img src="{{ image_url($property->images->first()->imagePath) }}" 
                                 class="card-img-top" 
                                 alt="{{ $property->title }}" 
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $property->title }}</h5>
                                <span class="badge bg-{{ $property->isSold ? 'danger' : 'success' }}">
                                    {{ $property->isSold ? 'Sold' : 'Available' }}
                                </span>
                            </div>
                            
                            <p class="card-text text-muted mb-2">
                                <small>{{ $property->address }}, {{ $property->city }}</small>
                            </p>
                            
                            <h4 class="text-primary mb-3">${{ number_format($property->price) }}</h4>
                            
                            <div class="d-flex justify-content-between text-muted mb-3">
                                <span><i class="bi bi-house-door"></i> {{ $property->propertyType }}</span>
                                <span><i class="bi bi-grid-3x3-gap"></i> {{ $property->squareFootage }} sqft</span>
                            </div>
                            
                            <div class="d-flex justify-content-between text-muted mb-3">
                                <span><i class="bi bi-door-open"></i> {{ $property->bedrooms }} beds</span>
                                <span><i class="bi bi-bathtub"></i> {{ $property->bathrooms }} baths</span>
                                <span><i class="bi bi-building"></i> {{ $property->floors }} floors</span>
                            </div>
                            
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('properties.show', $property->propertyId) }}" 
                                    class="btn btn-sm btn-outline-primary">
                                    View Property Details
                                </a>
                                <a href="{{ route('properties.images.create', $property->propertyId) }}" 
                                    class="btn btn-sm btn-outline-secondary">
                                    Add Images
                                </a>
                                @if(Auth::user()->role === 'client')
                                    <a href="{{ route('properties.agent.create', $property->propertyId) }}" 
                                        class="btn btn-sm btn-outline-info">
                                        Change Agent
                                    </a>
                                @else
                                    <a href="{{ route('properties.edit', $property->propertyId) }}" 
                                        class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection