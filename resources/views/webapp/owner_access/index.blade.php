@extends('webapp.owner_access.template')

@section('title', 'Dashboard')

@section('sidebar')

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Owner Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
              <i class="fas fa-file-signature text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
          </li>
  

        </ul>
      </div>
    </div>
  </div>
</nav>
@endsection
@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
    
  </div>


@endsection

@section('main-content')
<div class="card">
  <div class="card-body">
    <?php $explode = explode(" ", Auth::user()->name);?>
    Dear {{ $explode[0] }},
    <p class="text-justify">
        
    <br>
    We value our relationships with our clients and wanted to reach out to you in these difficult and uncertain times. The COVID-19 pandemic, and the measures being taken to reduce transmission of the virus, will mean adjustments and challenges for all of us. We want to assure you the health and safety of our clients and employees are our top priorities. We also want you to know that we will be working with you to ensure your housing is secure, despite the challenges ahead.
    <br><br>
    We have asked our maintenance staff to take extra steps to sanitize high-touch surfaces, including door handles, railings etc. in common areas. As a safety precaution, we are reviewing the delivery of in-suite maintenance and repairs to occupied units, to reduce risk to you and to our staff and contractors. We will prioritize urgent repair requests but defer non-urgent in-suite repairs and maintenance, to reduce exposure.
    <br><br>
    We encourage you to use this portal as to transact business with us. Most especially, in reporting your concerns. 
    <br><br>
    Sincerely, 
    <br>
    The Management
  </p>
  </div>
</div>
@endsection

@section('scripts')
  
@endsection



