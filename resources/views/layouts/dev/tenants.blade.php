@extends('layouts.argon.main')

@section('title', 'Tenants')

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
              <a class="nav-link" href="/property/all">
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

           
            <li class="nav-item">
              <a class="nav-link active" href="/dev/tenants">
                <i class="fas fa-user-circle text-red"></i>
                <span class="nav-link-text">Tenants</span>
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
    <h6 class="h2 text-dark d-inline-block mb-0">Tenants</h6>
    
  </div>
  

</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card card-stats">
        <!-- Card body -->
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0"> TOTAL</h5>
              <span class="h2 font-weight-bold mb-0">{{ number_format($tenants->count(),0) }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                <i class="fas fa-user"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-sm">
            {{-- @if($increase_in_room_acquired > 0)
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_in_room_acquired }}%</span>
            @else
            <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_in_room_acquired }}%</span>
            @endif
            <span class="text-nowrap">Since last month</span> --}}
            </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0"> ACTIVE</h5>
                <span class="h2 font-weight-bold mb-0">{{ number_format($active_tenants->count(),0) }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                  <i class="fas fa-user"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              {{-- @if($increase_in_room_acquired > 0)
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_in_room_acquired }}%</span>
              @else
              <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_in_room_acquired }}%</span>
              @endif
              <span class="text-nowrap">Since last month</span> --}}
              </p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0"> INACTIVE</h5>
                <span class="h2 font-weight-bold mb-0">{{ number_format($inactive_tenants->count(),0) }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                  <i class="fas fa-user"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              {{-- @if($increase_in_room_acquired > 0)
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_in_room_acquired }}%</span>
              @else
              <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_in_room_acquired }}%</span>
              @endif
              <span class="text-nowrap">Since last month</span> --}}
              </p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0"> PENDING</h5>
                <span class="h2 font-weight-bold mb-0">{{ number_format($pending_tenants->count(),0) }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                  <i class="fas fa-user"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              {{-- @if($increase_in_room_acquired > 0)
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_in_room_acquired }}%</span>
              @else
              <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_in_room_acquired }}%</span>
              @endif
              <span class="text-nowrap">Since last month</span> --}}
              </p>
          </div>
        </div>
      </div>

   
  </div>

  <div class="row">

    <!-- Occupancy Line Chart -->
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">OCCUPANCY RATE</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            {!! $movein_rate->container() !!}
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-lg-6 mb-4">
        <!-- Illustrations -->
        <div class="card shadow mb-4">
    
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">SOURCES</h6>
           
            </div>

      
          <div class="card-body">
            {!! $point_of_contact->container() !!}
          </div>
        </div>
    
      </div>

      <div class="col-lg-6 mb-4">
        <!-- Illustrations -->
        <div class="card shadow mb-4">
    
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">STATUS</h6>
           
            </div>

      
          <div class="card-body">
            {!! $status->container() !!}
          </div>
        </div>
    
      </div>
  </div>

  <div class="row">
    {{-- Moveout Line Chart --}}
    <div class="col-lg-6 mb-4">
      <!-- Illustrations -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">MOVEOUT FOR THE LAST 6 MONTHS</h6>
        </div>
        <div class="card-body">
            {!! $moveout_rate->container() !!}
        </div>
      </div>
  
    </div>
  
    <div class="col-lg-6 mb-4">
      <!-- Moveout Pie Chart -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">REASON FOR MOVING-OUT</h6>
        </div>
        <div class="card-body">
          {!! $reason_for_moving_out_chart->container() !!}
      </div>
      </div>
  
    </div>
  </div>

@endsection

@section('main-content')

@endsection

@section('scripts')
{!! $moveout_rate->script() !!}
{!! $reason_for_moving_out_chart->script() !!}
{!! $point_of_contact->script() !!}
{!! $status->script() !!}
{!! $movein_rate->script() !!}
@endsection



