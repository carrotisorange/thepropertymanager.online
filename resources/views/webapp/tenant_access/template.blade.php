<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('/argon/assets/img/brand/favicon.ico') }}" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('/argon/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('/argon/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
        <!-- Page plugins -->
        <!-- Argon CSS -->
        <link rel="stylesheet" href="{{ asset('/argon/assets/css/argon.css?v=1.2.0') }}" type="text/css">
      
        @yield('css')
      </head>
<body>
  <!-- Sidenav -->
@include('webapp.tenant_access.sidebar')
@show
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <!-- Topnav -->
@include('webapp.tenant_access.header')

@include('layouts.argon.notifications')
    <!-- Header -->
    <!-- Header -->
    <div class="header pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">

           @yield('upper-content')
        
          </div>
          <!-- Card stats -->

        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      
      @yield('main-content')
      
      <!-- Footer -->
      <hr>
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; 2020 <a href="/" class="font-weight-bold ml-1" target="_blank">The PMO Co</a>
            </div>
            
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="#/" class="nav-link">The Property Manager</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>

  @include('layouts.argon.logout')
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('/argon/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('/argon/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/argon/assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('/argon/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('/argon/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('/argon/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('/argon/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('/argon/assets/js/argon.js?v=1.2.0') }}"></script>

  @yield('scripts')
</body>

</html>
