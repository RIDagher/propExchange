@extends('layouts.app')

@section('content')
<div class="container mt-4 py-5" id="agent-container">
    <form method="GET" action="{{ route('search-agents') }}" class="g-3 bg-light p-4 rounded shadow">
        <h1 class="my-4">Search for Agents</h1>
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="username" class="form-control" 
                       placeholder="Search by username..." 
                       value="{{ request('username') }}"
                       id="agentSearchInput">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <div class="row mt-4" id="agent-results">
        @forelse($agents as $agent)        
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $agent->username }}</h5>
                        <p class="card-text">{{ $agent->email }}</p>
                        @if ($agent)
                            <a href="{{ route('contact.agent', $agent->userId) }}" class="btn btn-primary mt-3">Contact Agent</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No agents found matching your search.
                    @if(request('username'))
                        <a href="{{ route('search-agents') }}" class="alert-link">
                            Show all agents
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('agentSearchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();
            
            if (searchTerm.length > 2) {
                fetch(`/search-agents?username=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateAgentResults(data);
                    });
            } else if (searchTerm.length === 0) {
                fetch(`/search-agents`)
                    .then(response => response.json())
                    .then(data => {
                        updateAgentResults(data);
                    });
            }
        });
    }
    
    function updateAgentResults(agents) {
        const resultsContainer = document.getElementById('agent-results');
        
        if (agents.length > 0) {
            resultsContainer.innerHTML = agents.map(agent => `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">${agent.username}</h5>
                            <p class="card-text">${agent.email}</p>
                            ${agent ? `<a href="/contact-agent/${agent.userId}" class="btn btn-primary mt-3">Contact Agent</a>` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            resultsContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info">
                        No agents found matching your search.
                        <a href="/search-agents" class="alert-link">
                            Show all agents
                        </a>
                    </div>
                </div>
            `;
        }
    }
});
</script>
@endsection
@endsection