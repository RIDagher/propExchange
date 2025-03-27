@extends('layouts.app')

@section('content')

<div class="container mt-4 py-5" id="agent-container">
    <form action="POST" class="g-3 bg-light p-4 rounded shadow">
        <h1 class="my-4">Search for Agents</h1>
        @csrf
        <div>
            <input type="text" class="form-control my-3" placeholder="Search for Agents..." autocomplete="off">
            <div class="list-group position-absolute w-100 shadow bg-white"></div>
        </div>
    </form>

    <div class="row mt-4" id="agent-results">
        
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        
    </div>
</div>

@endsection