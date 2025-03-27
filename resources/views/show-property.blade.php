@extends('layouts.app')
@section('title', $property->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold">{{ $property->title }}</h1>
            <p class="text-muted">{{ $property->address }}, {{ $property->city }}, {{ $property->province }}, {{ $property->postalCode }}</p>
            
            @if($property->images->count() > 0)
            <div class="property-images mb-4">
                <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        @foreach($property->images as $key => $image)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->imagePath) }}" 
                                 class="d-block w-100" 
                                 alt="Property image {{ $key + 1 }}"
                                 style="max-height: 500px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    @if($property->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
                
                @if($property->images->count() > 1)
                <div class="d-flex flex-wrap mt-2">
                    @foreach($property->images as $key => $image)
                    <img src="{{ asset('storage/' . $image->imagePath) }}" 
                        class="img-thumbnail me-2 mb-2" 
                        style="width: 80px; height: 60px; cursor: pointer; object-fit: cover;"
                        onclick="jumpToSlide({{ $key }})"
                        alt="Thumbnail {{ $key + 1 }}"
                        data-bs-target="#propertyCarousel">
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="bg-light rounded mb-4 d-flex align-items-center justify-content-center" style="height: 300px;">
                <p class="text-muted">No images available for this property</p>
            </div>
            @endif

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
                    @if($property->agentId)
                        <form method="POST" action="#">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control" placeholder="Your Phone">
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="3" placeholder="Your Message" required></textarea>
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
                <a href="{{ route('properties.images.create', $property->propertyId) }}" class="btn btn-outline-secondary">
                    Add Images
                </a>
            </div>
        @endif
    @endauth
</div>
@section('scripts')
@if($property->images->count() > 1)
<script>
    const carousel = new bootstrap.Carousel(document.getElementById('propertyCarousel'), {
        interval: false,
        touch: true
    });

    function jumpToSlide(index) {
        const myCarousel = document.getElementById('propertyCarousel');
        const carousel = bootstrap.Carousel.getInstance(myCarousel);
        carousel.to(index);
    }
</script>
@endif
@endsection
@endsection