@extends('layouts.argon.main')

@section('title', 'Dashboard')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}The Property Manager
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="/property/all">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
        
            <li class="nav-item">
              <a class="nav-link" href="/dev/activities">
                <i class="fas fa-snowboarding text-indigo"></i>
                <span class="nav-link-text">Activities</span>
              </a>
            </li>
       
            <li class="nav-item">
                <a class="nav-link" href="/dev/properties">
                  <i class="fas fa-building text-green"></i>
                  <span class="nav-link-text">Properties</span>
                </a>
              </li>
 
  
            <li class="nav-item">
              <a class="nav-link" href="/dev/users">
                <i class="fas fa-user text-teal"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/dev/plans">
                <i class="fas fa-tags text-pink"></i>
                <span class="nav-link-text">Plans</span>
              </a>
            </li>



          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
                   <li class="nav-item">
              <a class="nav-link" href="/dev/starter" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/dev/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/dev/updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/dev/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>

            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
    
  </div>
  

</div>

<div class="row">


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a class="text-primary" href="#/">  PROPERTIES</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $properties->count() }}</div>
              {{-- <small>PENDING ({{ $pending_tenants->count() }})</small> --}}
              
            </div>
            <div class="col-auto">
              <i class="fas fa-home fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a class="text-info" href="#/"> ACTIVE USERS</a> </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_users->count() }}</div>
              {{-- <small>|</small> --}}
              
            </div>
            <div class="col-auto">
              <i class="fas fa-user-check fa-2x text-gray-300"></i>
            
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a class="text-success"  href="#/">  PAYING USERS</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paying_users->count() }}</div>
    {{--                            
              <small>PENDING ({{ $pending_concerns->count() }})</small> --}}
            </div>
            <div class="col-auto">
              <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
             
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><a class="text-warning"  href="#/">  UNVERFIFIED USERS</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unverified_users->count() }}</div>
    {{--                            
              <small>PENDING ({{ $pending_concerns->count() }})</small> --}}
            </div>
            <div class="col-auto">
              <i class="fas fa-user-clock fa-2x text-gray-300"></i>
        
            </div>
          </div>
        </div>
      </div>
    </div>
    
    </div>
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">SIGN UP RATE</h6>
              
            </div>
            <!-- Card Body -->
            <div class="card-body">
             
                {!! $signup_rate->container() !!}
              
            </div>
          </div>
        </div>
                </div>
@endsection

@section('main-content')

@endsection

@section('scripts')
{!! $signup_rate->script() !!}
@endsection



