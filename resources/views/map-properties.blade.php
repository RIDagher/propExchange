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
    <a href="{{ route('index') }}" class="btn btn-outline-primary mt-2">
      <i class="bi bi-list"></i> View List
    </a>
  </div>

  <!-- Map Section -->
  <div id="map" style="height: 500px; width: 100%;"></div>
</div>
</div>

<script>
  function initMap() {
    let map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: {
        lat: 45.4215,
        lng: -75.6993
      },
      styles: [{
          "featureType": "all",
          "elementType": "labels.text",
          "stylers": [{
            "color": "#878787"
          }]
        },
        {
          "featureType": "all",
          "elementType": "labels.text.stroke",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "landscape",
          "elementType": "all",
          "stylers": [{
            "color": "#f9f5ed"
          }]
        },
        {
          "featureType": "road.highway",
          "elementType": "all",
          "stylers": [{
            "color": "#f5f5f5"
          }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry.stroke",
          "stylers": [{
            "color": "#c9c9c9"
          }]
        },
        {
          "featureType": "water",
          "elementType": "all",
          "stylers": [{
            "color": "#aee0f4"
          }]
        }
      ]
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