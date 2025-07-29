@extends('layouts.app')
@section('title', 'Search Properties by Map')
@section('styles')
<style>
  #map {
    border: 2px solid #4CAF50;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  body {
    background-color: #f7f9fb;
  }
</style>
@endsection

@section('content')
<div class="container bg-white p-4 shadow rounded mt-4">



  <!-- View List Button -->
  <div class="text-end mb-3">
    <a href="{{ route('search-properties') }}" class="btn btn-outline-primary mt-2">
      <i class="bi bi-list"></i> View List
    </a>
  </div>

  <!-- Map Section -->
  <div id="map" style="height: 500px; width: 100%;"></div>
</div>
</div>

<script>
  const properties = @json($properties);

  function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: {
        lat: 45.4215,
        lng: -75.6993
      },
    });

    properties.forEach(property => {
      const marker = new google.maps.Marker({
        position: {
          lat: parseFloat(property.latitude),
          lng: parseFloat(property.longitude)
        },
        map: map,
        title: property.title
      });

      const infoWindow = new google.maps.InfoWindow({
        content: `<strong>${property.title}</strong><br>${property.propertyType}<br>$${property.price}`
      });

      marker.addListener('click', () => {
        infoWindow.open(map, marker);
      });
    });
  }
</script>


<!-- Load Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
@endsection