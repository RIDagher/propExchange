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

  .map-controls {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .property-counter {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 15px;
  }

  /* Remove custom filter styling to use Bootstrap classes */

  .map-legend {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-width: 250px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 12px;
  }

  .legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 8px;
  }

  .info-window-content {
    max-width: 280px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .info-window-title {
    font-size: 16px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .info-window-price {
    font-size: 18px;
    font-weight: 800;
    color: #4CAF50;
    margin-bottom: 6px;
  }

  .info-window-details {
    font-size: 13px;
    color: #666;
    line-height: 1.4;
    margin-bottom: 8px;
  }

  .info-window-address {
    font-size: 12px;
    color: #888;
    margin-bottom: 10px;
    font-style: italic;
  }

  .info-window-link {
    display: inline-block;
    background: #4CAF50;
    color: white !important;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    transition: background 0.3s ease;
  }

  .info-window-link:hover {
    background: #45a049;
    color: white !important;
  }

  .map-container {
    position: relative;
  }

  @media (max-width: 768px) {
    .map-legend {
      position: relative;
      top: auto;
      left: auto;
      margin-bottom: 15px;
      max-width: none;
    }
    
    .map-controls {
      padding: 15px;
    }
  }
</style>
@endsection

@section('content')
<div class="container mt-4">
  <!-- Header and Controls -->
  <div class="map-controls">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h2 class="mb-2">Property Map View</h2>
        <div class="property-counter">
          <i class="bi bi-geo-alt-fill me-2"></i>
          <span id="property-count">{{ count($properties) }}</span> Properties Found
        </div>
      </div>
      <a href="{{ route('search-properties') }}" class="btn btn-outline-primary">
        <i class="bi bi-list"></i> List View
      </a>
    </div>

    <!-- Filters -->
    <form class="row g-3 align-items-end bg-light p-4 rounded shadow">
      <div class="col-md-3">
        <select id="typeFilter" class="form-select" onchange="filterProperties()">
          <option value="">Property Type</option>
          <option value="house">House</option>
          <option value="condo">Condo</option>
          <option value="apartment">Apartment</option>
          <option value="townhouse">Townhouse</option>
        </select>
      </div>
      
      <div class="col-md-2">
        <select id="priceFilter" class="form-select" onchange="filterProperties()">
          <option value="">Max Price</option>
          <option value="300000">Under $300K</option>
          <option value="500000">Under $500K</option>
          <option value="750000">Under $750K</option>
          <option value="1000000">Under $1M</option>
        </select>
      </div>

      <div class="col-md-2">
        <select id="bedroomFilter" class="form-select" onchange="filterProperties()">
          <option value="">Bedrooms</option>
          <option value="1">1+</option>
          <option value="2">2+</option>
          <option value="3">3+</option>
          <option value="4">4+</option>
        </select>
      </div>

      <div class="col-md-2">
        <select id="cityFilter" class="form-select" onchange="filterProperties()">
          <option value="">All Cities</option>
          @foreach($properties->pluck('city')->unique() as $city)
            <option value="{{ $city }}">{{ $city }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <input type="text" id="searchFilter" class="form-control" placeholder="Search properties..." onkeyup="filterProperties()">
      </div>

      <div class="col-md-12 text-center">
        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
          <i class="bi bi-arrow-clockwise"></i> Clear Filters
        </button>
      </div>
    </form>
  </div>

  <!-- Map Container -->
  <div class="map-container bg-white p-3 shadow rounded">
    <!-- Loading State -->
    <div id="map-loading" class="text-center py-5">
      <div class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading map...</span>
      </div>
      <p class="mt-3 text-muted">Loading properties map...</p>
    </div>

    <!-- Legend -->
    <div class="map-legend d-none d-md-block">
      <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Property Types</h6>
      <div class="legend-item">
        <div class="legend-dot" style="background: #4CAF50;"></div>
        <span>House</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: #2196F3;"></div>
        <span>Condo</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: #FF9800;"></div>
        <span>Apartment</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: #9C27B0;"></div>
        <span>Townhouse</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: #F44336;"></div>
        <span>Other</span>
      </div>
    </div>

    <!-- Map -->
    <div id="map" style="height: 600px; width: 100%; display: none;"></div>
  </div>
</div>

<script>
  const properties = @json($properties);
  let map;
  let markers = [];
  let infoWindows = [];

  // Color mapping for property types
  const propertyTypeColors = {
    'house': '#4CAF50',
    'condo': '#2196F3', 
    'apartment': '#FF9800',
    'townhouse': '#9C27B0',
    'default': '#F44336'
  };

  function initMap() {
    // Hide loading and show map
    document.getElementById('map-loading').style.display = 'none';
    document.getElementById('map').style.display = 'block';

    // Initialize map with  styling
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 8,
      center: { lat: 45.4215, lng: -75.6993 },
      styles: [
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [{ color: "#e9e9e9" }, { lightness: 17 }]
        },
        {
          featureType: "landscape",
          elementType: "geometry",
          stylers: [{ color: "#f5f5f5" }, { lightness: 20 }]
        }
      ],
      mapTypeControl: true,
      streetViewControl: true,
      fullscreenControl: true,
      zoomControl: true
    });

    // Create markers for all properties
    createMarkers(properties);
    
    // Fit map to show all markers
    fitMapToMarkers();

    // Add click listener to close info windows when clicking on map
    map.addListener('click', closeAllInfoWindows);
  }

  function createMarkers(propertiesToShow) {
    // Clear existing markers
    clearMarkers();

    propertiesToShow.forEach((property, index) => {
      const position = {
        lat: parseFloat(property.latitude),
        lng: parseFloat(property.longitude)
      };

      // Get color based on property type
      const color = propertyTypeColors[property.propertyType.toLowerCase()] || propertyTypeColors.default;

      // Create custom marker
      const marker = new google.maps.Marker({
        position: position,
        map: map,
        title: property.title,
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 8,
          fillColor: color,
          fillOpacity: 0.8,
          strokeColor: '#ffffff',
          strokeWeight: 2
        },
        animation: google.maps.Animation.DROP
      });

      // Create enhanced info window content
      const infoWindowContent = createInfoWindowContent(property);

      const infoWindow = new google.maps.InfoWindow({
        content: infoWindowContent,
        maxWidth: 300
      });

      // Add click listener
      marker.addListener('click', () => {
        // Close all other info windows
        infoWindows.forEach(window => window.close());
        infoWindow.open(map, marker);
      });

      // Add hover effects
      marker.addListener('mouseover', () => {
        marker.setIcon({
          path: google.maps.SymbolPath.CIRCLE,
          scale: 10,
          fillColor: color,
          fillOpacity: 1,
          strokeColor: '#ffffff',
          strokeWeight: 3
        });
      });

      marker.addListener('mouseout', () => {
        marker.setIcon({
          path: google.maps.SymbolPath.CIRCLE,
          scale: 8,
          fillColor: color,
          fillOpacity: 0.8,
          strokeColor: '#ffffff',
          strokeWeight: 2
        });
      });

      markers.push(marker);
      infoWindows.push(infoWindow);
    });

    // Update property count
    document.getElementById('property-count').textContent = propertiesToShow.length;
  }

  function createInfoWindowContent(property) {
    const mainImage = property.images && property.images.length > 0 
      ? `<img src="{{ asset('storage') }}/${property.images[0].imagePath}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;" onerror="this.style.display='none'">`
      : '';

    return `
      <div class="info-window-content">
        ${mainImage}
        <div class="info-window-title">${property.title}</div>
        <div class="info-window-price">$${parseInt(property.price).toLocaleString()}</div>
        <div class="info-window-details">
          <strong>${property.propertyType}</strong> • 
          ${property.bedrooms || 'N/A'} bed • 
          ${property.bathrooms || 'N/A'} bath
          ${property.squareFootage ? ` • ${property.squareFootage} sq ft` : ''}
        </div>
        <div class="info-window-address">
          <i class="bi bi-geo-alt"></i> ${property.address}, ${property.city}, ${property.province}
        </div>
        <a href="/properties/${property.propertyId}" class="info-window-link" target="_blank">
          <i class="bi bi-eye"></i> View Details
        </a>
      </div>
    `;
  }

  function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
    infoWindows.forEach(window => window.close());
    infoWindows = [];
  }

  function fitMapToMarkers() {
    if (markers.length === 0) return;

    const bounds = new google.maps.LatLngBounds();
    markers.forEach(marker => bounds.extend(marker.getPosition()));
    
    map.fitBounds(bounds);
    
    // Ensure minimum zoom level
    google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
      if (map.getZoom() > 15) {
        map.setZoom(15);
      }
    });
  }

  function filterProperties() {
    const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
    const priceFilter = parseInt(document.getElementById('priceFilter').value) || Infinity;
    const bedroomFilter = parseInt(document.getElementById('bedroomFilter').value) || 0;
    const cityFilter = document.getElementById('cityFilter').value.toLowerCase();
    const searchFilter = document.getElementById('searchFilter').value.toLowerCase();

    const filteredProperties = properties.filter(property => {
      const typeMatch = !typeFilter || property.propertyType.toLowerCase().includes(typeFilter);
      const priceMatch = parseInt(property.price) <= priceFilter;
      const bedroomMatch = !bedroomFilter || (property.bedrooms && parseInt(property.bedrooms) >= bedroomFilter);
      const cityMatch = !cityFilter || property.city.toLowerCase().includes(cityFilter);
      
      // Search in title, description, address, city
      const searchMatch = !searchFilter || 
        property.title.toLowerCase().includes(searchFilter) ||
        (property.description && property.description.toLowerCase().includes(searchFilter)) ||
        property.address.toLowerCase().includes(searchFilter) ||
        property.city.toLowerCase().includes(searchFilter) ||
        property.propertyType.toLowerCase().includes(searchFilter);

      return typeMatch && priceMatch && bedroomMatch && cityMatch && searchMatch;
    });

    createMarkers(filteredProperties);
    
    if (filteredProperties.length > 0) {
      fitMapToMarkers();
    }
  }

  function clearFilters() {
    document.getElementById('typeFilter').value = '';
    document.getElementById('priceFilter').value = '';
    document.getElementById('bedroomFilter').value = '';
    document.getElementById('cityFilter').value = '';
    document.getElementById('searchFilter').value = '';
    
    createMarkers(properties);
    fitMapToMarkers();
  }

  // Close info windows when clicking on map
  function closeAllInfoWindows() {
    infoWindows.forEach(window => window.close());
  }

  // Google Maps API error handler
  function gm_authFailure() {
    const mapContainer = document.getElementById('map');
    mapContainer.innerHTML = `
      <div class="text-center py-5">
        <div class="alert alert-warning" role="alert">
          <h5><i class="bi bi-exclamation-triangle"></i> Google Maps Configuration Issue</h5>
          <p class="mb-2">The Google Maps API key is missing or invalid.</p>
          <p class="mb-0"><small>Please contact the administrator to configure the Google Maps API key.</small></p>
        </div>
      </div>
    `;
    document.getElementById('map-loading').style.display = 'none';
  }

  // Handle Google Maps loading errors
  window.addEventListener('error', function(e) {
    if (e.message && e.message.includes('Google Maps')) {
      gm_authFailure();
    }
  });

  // Fallback if Google Maps fails to load
  setTimeout(function() {
    if (typeof google === 'undefined') {
      gm_authFailure();
    }
  }, 5000);
</script>

<!-- Load Google Maps API with error handling -->
@if(config('services.google.maps_api_key'))
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap&onerror=gm_authFailure"></script>
@else
<script>
  // No API key configured
  document.addEventListener('DOMContentLoaded', function() {
    gm_authFailure();
  });
</script>
@endif
@endsection