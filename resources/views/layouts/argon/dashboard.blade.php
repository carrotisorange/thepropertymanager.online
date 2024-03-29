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
       <!-- Load Facebook SDK for JavaScript -->
       @include('layouts.argon.chat-messenger')

  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#/">
        {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}"> --}}
        <img src="{{asset('arsha/assets/img/logo3.png')}}" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="dashboard.html">
                {{-- <img alt="Image placeholder" src="{{ asset('/argon/assets/img/brand/logo.png') }}"> --}}
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
       
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
             <li class="nav-item">
              <a class="nav-link nav-link-icon text-primary" href="https://www.facebook.com/onlinepropertymanager" target="_blank" data-toggle="tooltip" data-original-title="Like us on Facebook">
                <i class="fab fa-facebook-square"></i>
                <span class="nav-link-inner--text d-lg-none">Facebook</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon text-indigo" href="https://www.instagram.com/onlinepropertymanager/" target="_blank" data-toggle="tooltip" data-original-title="Follow us on Instagram">
                <i class="fab fa-instagram"></i>
                <span class="nav-link-inner--text d-lg-none">Instagram</span>
              </a>
            </li>
           <li class="nav-item">
              <a class="nav-link nav-link-icon" href="https://twitter.com/ThePropertyMan3" target="_blank" data-toggle="tooltip" data-original-title="Follow us on Twitter">
                <i class="fab fa-twitter-square text-teal"></i>
                <span class="nav-link-inner--text d-lg-none">Twitter</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="https://www.youtube.com/channel/UCZkxSsob3vWJu3tJztyZIVg" target="_blank" data-toggle="tooltip" data-original-title="Subscribe on Youtube Channel">
                <i class="fab fa-youtube text-danger"></i>
                <span class="nav-link-inner--text d-lg-none">Github</span>
              </a>
            </li>
          <li class="nav-item d-none d-lg-block ml-lg-4">
            <a href="/user/upgrade" target="_blank" class="btn btn-neutral btn-icon">
              <span class="btn-inner--icon">
                <i class="fas fa-shopping-cart mr-2"></i>
              </span>
              <span class="nav-link-inner--text">Upgrade to PRO</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Header -->
    <div class="header py-7 py-lg-8">

      {{-- <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div> --}}
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      @include('layouts.argon.notifications')
      <div class="row justify-content-center">
      {{-- @yield('title') --}}
          <div class="col-md-12">
            <div class="card border-0 mb-0">
              @yield('content')
            </div>
          </div>
      </div>
    </div>
  </div>
 
  <!-- Footer -->
  {{-- <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2020 <a href="/" class="font-weight-bold ml-1" target="_blank">The PMO Co</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="/" class="nav-link" target="_blank">About Us</a>
            </li>
           
            <li class="nav-item">
              <a href="/terms-of-service" class="nav-link" target="_blank">Terms of service</a>
            </li>
            <li class="nav-item">
              <a href="/privacy-policy" class="nav-link" target="_blank">Privacy policy</a>
            </li>
            <li class="nav-item">
              <a href="/acceptable-use-policy" class="nav-link" target="_blank">Acceptable use policy</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <br><br><br>
  </footer> --}}
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