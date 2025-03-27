@extends('layouts.app')

@section('content')

<div class="container mt-4 py-5" id="agent-container">
    <form method="GET" action="{{ route('search-agents') }}" class="g-3 bg-light p-4 rounded shadow">
        <h1 class="my-4">Search for Agents</h1>
        @csrf
        <div>
            <input type="text" class="form-control my-3" placeholder="Search for Agents..." autocomplete="off">
            <div class="list-group position-absolute w-100 shadow bg-white"></div>
        </div>
    </form>

    <div class="row mt-4" id="agent-results">
        @forelse($agents as $agent)        
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title">{{ $agent->username }}</h5>
                        <p class="card-text">{{ $agent->email }}</p>
                        <a href="{{ route('agent.profile', $agent->id) }}" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No agents found</p>
            </div>
        @endforelse
    </div>
</div>

@endsection