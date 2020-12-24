@extends('layouts.argon.main')

@section('title', 'Users')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{ $property->name }} 
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link active active" href="/property/{{Session::get('property_id')}}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Users</span>
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
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{Session::get('property_id')}}/announcements" target="_blank">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Users</h6>
    
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


<h4>Active today ({{ $sessions->count() }}) </h4>
<div class="table-responsive text-nowrap">
  <table class="table">
    <?php $ctr = 1; ?>
    <thead>
    <tr>
      <th>#</th>  
      <th>Name</th>
      <th>Role</th>

      <th>IP Address</th>
      <th>Login at</th>
      <th>Logout at</th>
      <th>Usage time</th>
      
    </tr>
    </thead>
    <tbody>
    @foreach ($sessions as $item)
      <tr>
       <th>{{ $ctr++ }}</th>
       <td>{{ $item->user_name }}</td>
       <td>{{ $item->user_type }}</td>
       
       
        <td>{{ $item->session_last_login_ip }}</td>
       <td>{{ $item->session_last_login_at? Carbon\Carbon::parse($item->session_last_login_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_login_at)->toTimeString() : null }}</td>
       <td>{{ $item->session_last_logout_at? Carbon\Carbon::parse($item->session_last_logout_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_logout_at)->toTimeString() : null }}</td>
       
     <td>
      @if($item->session_last_logout_at == null)
        0.0 hours
       @else
       {{  number_format(Carbon\Carbon::parse($item->session_last_login_at)->DiffInHours(Carbon\Carbon::parse($item->session_last_logout_at)),1) }} hours
       @endif
      </td>
      </tr>
    @endforeach
    </tbody>
  </table>

</div>
<br>
<h4>All Users ({{ $users->count() }})</h4>
<div class="table-responsive text-nowrap">
<table class="table" >
  <?php $ctr=1; ?>
  <thead>
    <tr>
     <th>#</th>
     <th>Name</th>
     <th>Email</th>
  
     <th>Role</th>

     <th>Created at</th>
     <th>Verified at</th>
   

 
  </tr>
  </thead>
  <tbody>
   @foreach ($users as $item)
   <tr>
    <th>{{ $ctr++ }}</th>
     <td><a href="/property/{{ $property->property_id }}/user/{{ $item->id }}">{{ $item->name }}</a></td>
     <td>{{ $item->email }}</td>
     <td>{{ $item->user_type }}</td>

      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
      <td>{{ Carbon\Carbon::parse($item->email_verified_at)->format('M d Y').' '.Carbon\Carbon::parse($item->email_verified_at)->toTimeString() }}</td>
   
     
   @endforeach
  </tbody>
</table>
@if(Auth::user()->email === 'thepropertymanager2020@gmail.com' || Auth::user()->email === 'tecson.pamela@gmail.com' || Auth::user()->email === 'sales@thepropertymanager.online')
{{ $users->links() }}
@endif

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

@section('scripts')
{!! $signup_rate->script() !!}
@endsection



