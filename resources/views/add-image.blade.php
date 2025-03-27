@extends('layouts.app')
@section('title', 'Add Property Image')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Image to Property</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('properties.images.store', $property->propertyId) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <h5>Property: {{ $property->title }}</h5>
                            <p class="text-muted">{{ $property->address }}, {{ $property->city }}</p>
                        </div>
                        
                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="form-label">Property Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" required>
                            
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <div class="form-text">
                                Upload a high-quality image of your property (JPEG, PNG, etc.)
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="isMain" name="isMain" value="1">
                            <label class="form-check-label" for="isMain">
                                Set as main property image
                            </label>
                            <div class="form-text">
                                The main image will be used as the thumbnail in property listings
                            </div>
                        </div>
                        
                        <div class="mb-4 d-none" id="imagePreviewContainer">
                            <label class="form-label">Image Preview</label>
                            <div class="border p-2 rounded">
                                <img id="imagePreview" src="#" alt="Image Preview" 
                                     class="img-fluid d-none" style="max-height: 300px;">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('properties.my') }}" class="btn btn-outline-secondary me-md-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Image
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                previewContainer.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endsection
@endsection