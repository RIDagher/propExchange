@extends('layouts.app')
@section('title', 'Search Properties by Map')

@section('content')
<div class="container mt-4">
  <h1 class="text-center">Properties on Map</h1>

  <!-- View List Button -->
  <div class="text-end mb-3">
    <a href="{{ route('search.properties') }}" class="btn btn-outline-primary">
      <i class="bi bi-list"></i> View List
    </a>
  </div>

  <!-- Map Section -->
  <div id="map" style="height: 500px; width: 100%;"></div>
</div>

<script>
  function initMap() {
    let map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: {
        lat: 45.4215,
        lng: -75.6993
      } // Default center: Ottawa
    });

    // data
    const properties = [{
        title: "Modern House",
        type: "House",
        lat: 43.6532,
        lng: -79.3832
      },
      {
        title: "Luxury Condo",
        type: "Condo",
        lat: 49.2827,
        lng: -123.1207
      },
      {
        title: "Cozy Cottage",
        type: "Cottage",
        lat: 46.8139,
        lng: -71.2082
      }
    ];

    // 
    properties.forEach(property => {
      const marker = new google.maps.Marker({
        position: {
          lat: property.lat,
          lng: property.lng
        },
        map: map,
        title: property.title
      });

      const infoWindow = new google.maps.InfoWindow({
        content: `<strong>${property.title}</strong><br>Type: ${property.type}`
      });

      marker.addListener('click', () => {
        infoWindow.open(map, marker);
      });
    });
  }
</script>


<!-- Load Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSoL_nhXPC7ACkJCDxqNdyWRYwIcEeBtI&callback=initMap"></script>
@endsection