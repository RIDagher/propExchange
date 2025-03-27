@extends('layouts.app')
@section('title', 'Add Agent to Property')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Agent to Property</h4>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title">{{ $property->title }}</h5>
                    <p class="text-muted">{{ $property->address }}, {{ $property->city }}</p>
                    
                    @if($property->agent)
                        <div class="alert alert-info mb-4">
                            Current Agent: <strong>{{ $property->agent->username }}</strong>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('properties.agent.store', $property->propertyId) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="agentId" class="form-label">Select Agent</label>
                            <select class="form-select @error('agentId') is-invalid @enderror" 
                                    id="agentId" name="agentId" required>
                                <option value="">-- Select an Agent --</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->userId }}" 
                                        {{ old('agentId') == $agent->userId ? 'selected' : '' }}>
                                        {{ $agent->username }} ({{ $agent->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('agentId')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('properties.my') }}" class="btn btn-outline-secondary me-md-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Assign Agent
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection