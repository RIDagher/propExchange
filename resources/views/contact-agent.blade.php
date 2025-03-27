@extends('layouts.app')
@section('title', 'Contact ' . $agent->username)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold">Contact Agent: {{ $agent->username }}</h1>
            <p class="text-muted">{{ $agent->email }}</p>
            
            @if($agent->phone)
                <p><i class="bi bi-telephone"></i> {{ $agent->phone }}</p>
            @endif
            
            <div class="my-4">
                <h3>Managed Properties</h3>
                @if($properties->count() > 0)
                    <div class="list-group">
                        @foreach($properties as $property)
                        <a href="{{ route('properties.show', $property->propertyId) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $property->title }}</h5>
                                <span class="badge bg-{{ $property->isSold ? 'danger' : 'success' }}">
                                    {{ $property->isSold ? 'Sold' : '$' . number_format($property->price) }}
                                </span>
                            </div>
                            <p class="mb-1">{{ $property->address }}, {{ $property->city }}</p>
                            <small>{{ $property->propertyType }} • {{ $property->bedrooms }} beds • {{ $property->bathrooms }} baths</small>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        This agent is not currently managing any properties.
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Send Message</h5>
                </div>
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection