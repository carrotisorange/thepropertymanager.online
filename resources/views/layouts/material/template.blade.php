<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
@include('layouts.material.css')
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('/material/assets/img/sidebar-1.jpg') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          The PMO DEV
        </a></div>
        @include('layouts.material.sidebar')
    </div>
    @include('layouts.argon.notifications')
    <div class="main-panel">
      <!-- Navbar -->
      @include('layouts.material.navbar')
      <!-- End Navbar -->
   @yield('content')
   
     @include('layouts.material.footer')
    </div>
  </div>
 @include('layouts.material.settings')
  <!--   Core JS Files   -->
@include('layouts.material.js')

</body>

</html>