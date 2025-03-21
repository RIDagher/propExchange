<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PropExchange')</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


</head>

<body>

  <!-- Top Red Navbar -->
  <nav class="navbar top-nav">
    <div class="container d-flex justify-content-between">
      <a class="navbar-brand text-white" href="/">PropExchange</a>
      <div>
        <a href="#" class="mx-2">Sign In</a>
        <a href="#" class="mx-2">Register</a>
      </div>
    </div>
  </nav>

  <!-- Main White Navigation Bar -->
  <nav class="navbar navbar-expand-lg main-nav">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/search-properties">Find a Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/search-agent">Find a REALTOR</a></li>
          <li class="nav-item"><a class="nav-link" href="/search-location">Map</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-4">
    @yield('content') <!-- Child views  -->
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>