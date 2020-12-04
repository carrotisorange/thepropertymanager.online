@extends('templates.webapp-new.template')

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
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link active active" href="/property/{{$property->property_id }}/users">
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
              <a class="nav-link" href="/property/{{ $property->property_id }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/announcements" target="_blank">
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
  {{-- <div class="col-lg-6 col-5 text-right">
    @if(Auth::user()->email === 'thepropertymanager2020@gmail.com' || Auth::user()->email !== 'Free')
    <a class="btn btn-primary" data-toggle="collapse" href="#addUserModal" role="button" aria-expanded="false" aria-controls=""> <i class="fas fa-user-plus  fa-sm text-white-50"></i> Add</a> 
  @else
    <a title="Your plan can't add another user." class="btn btn-primary" data-toggle="collapse" href="#/" role="button" aria-expanded="false" aria-controls=""> <i class="fas fa-user-plus  fa-sm text-white-50"></i> Add</a> 
  @endif
  </div> --}}
</div>


{{-- <div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="addUserModal">
      <div class="card card-body">
          <form id="addUserForm" action="/users" method="POST">
              {{ csrf_field() }}
          </form>
          <div class="row">
              <div class="col">
                  <small>Name</small>
                  <input form="addUserForm"  id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Full Name" required>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="col">
                  <small>Email</small>
                  <input form="addUserForm"  id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email" required>

              @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
              </div>
              <div class="col">
                 <small>Role</small>
                  <select class="form-control" form="addUserForm" name="user_type" required>
                      <option value="">Please select one</option>
                      <option value="admin">admin</option>
                      <option value="ap">ap</option>
                      <option value="billing">billing</option>
                      <option value="manager">manager</option>
                      <option value="treasury">treasury</option>
                      
                  </select>
              </div>
              <div class="col">
                <small>Password</small>
                  <input form="addUserForm" type="password" class="form-control" name="password" required>
            </div>
             
          </div>
          <br>
          <button form="addUserForm" type="submit" class="btn btn-primary btn-user btn-block" id="registerButton" onclick="this.form.submit(); this.disabled = true;">
             Register
    </button>
          

      </div>
    </div>
  </div>
</div> --}}
<h4>Active today ({{ $sessions->count() }}) </h4>
<div class="table-responsive text-nowrap">
  <table class="table">
    <?php $ctr = 1; ?>
    <thead>
    <tr>
      <th>#</th>  
      <th>Name</th>
      <th>Role</th>
      <th>Property</th>
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
       
       <td>{{ $item->property_name }}</td>
        <td>{{ $item->session_last_login_ip }}</td>
       <td>{{ $item->session_last_login_at? Carbon\Carbon::parse($item->session_last_login_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_login_at)->toTimeString() : null }}</td>
       <td>{{ $item->session_last_logout_at? Carbon\Carbon::parse($item->session_last_logout_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_logout_at)->toTimeString() : null }}</td>
       
       <td> @if($item->session_last_logout_at == null)
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
@if(Auth::user()->email === 'thepropertymanager2020@gmail.com' || Auth::user()->email === 'tecson.pamela@gmail.com' || Auth::user()->email === 'sales@thepropertymanager.online')

<br>
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

        <div class="row">
          <div class="col-md-12">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-properties-tab" data-toggle="tab" href="#properties" role="tab" aria-controls="nav-properties" aria-selected="true"><i class="fas fa-building fa-sm text-primary-50"></i> Properties <span class="badge badge-primary">{{ $properties->count() }}</span></a>
                <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="nav-active" aria-selected="false"><i class="fas fa-user-check fa-sm text-primary-50"></i> Active Users <span class="badge badge-primary">{{ $active_users->count() }}</span></a>
                <a class="nav-item nav-link" id="nav-unverified-tab" data-toggle="tab" href="#unverified" role="tab" aria-controls="nav-unverified" aria-selected="false"><i class="fas fa-user-times fa-sm text-primary-50"></i> Unverified Users <span class="badge badge-primary">{{ $unverified_users->count() }}</span> </a>
              </div>
            </nav>
          </div>
        </div>
     
          <div class="tab-content" id="nav-tabContent">
     
            <div class="tab-pane fade show active" id="properties" role="tabpanel" aria-labelledby="nav-properties-tab">
              <br>
                <div class="col-md-12 mx-auto">
                  <div class="table-responsive text-nowrap">
                    <table class="table" >
                      <?php $ctr=1; ?>
                      <thead>
                        <tr>
                          <th>#</th>
                         <th>Name</th>
                         <th>Type</th>
                         <th>Ownership</th>
                         <th>Status</th>
                         <th>Mobile</th>
                       
                        
                         <th>Adress</th>
                         <th>Country</th>
                         <th>Zip</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                       @foreach ($properties as $item)
                           <tr>
                            <th>{{ $ctr++ }}</th>
                             <td>
                               {{ $item->name }}
                              
                             </td>
                             <td>
                              {{ $item->type }} with
                     
                             </td>
                             <td>
                              {{ $item->ownership }}
                             </td>
                             <td>
                              {{ $item->status }}
                             </td>
                             <td>
                              {{ $item->mobile }}
                             </td>
                             <td>
                              {{ $item->address }}
                             </td>
                             <td>
                              {{ $item->country }}
                             </td>
                             <td>
                              {{ $item->zip }}
                             </td>
                           
            
                           </tr>
                       @endforeach
                      </tbody>
                    </table>
                   
                  </div>
                </div>
            </div>
            <div class="tab-pane fade" id="unverified" role="tabpanel" aria-labelledby="nav-unverified-tab">
             <br>
             <div class="col-md-12 mx-auto">
              <div class="table-responsive text-nowrap">
                <table class="table" >
                  <?php $ctr=1; ?>
                  <thead>
                    <tr>
                      <th>#</th>
                     <th>User</th>
                     <th>Property</th>
                     <th>Role</th>
                     
                     <th>Created at</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                   @foreach ($unverified_users as $item)
                       <tr>
                         <th>{{ $ctr++ }}</th>
                         <td>
                          
                           <a href="/property/{{ $property->property_id }}/user/{{ $item->id }}">{{ $item->name }}</a>
                           
                         </td>
                         <td>
                           {{ $item->property }}
                         </td>
                         <td>{{ $item->user_type }}</td>
                   
                        
                        
                        
                         <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
                   
                   
                       </tr>
                   @endforeach
                  </tbody>
                </table>
               
              </div>
             </div>
            </div>
            <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="nav-active-tab">
              <br>
              <div class="col-md-12 mx-auto">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <?php $ctr=1; ?>
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Created at</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Property</th>
                        <th>Type</th>
                        <th>Ownership</th>
                        <th>Email Verified At</th>
                        <th>Trial Ends At</th>
                        <th>Plan</th>
                        <th>Last Login IP</th>
                        <th>Last Login At</th>
                        <th>Last Logout At</th>
                        <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $item)
                   <tr>
                    <th>{{ $ctr++ }}</th>
                       <td><a href="/property/{{ $property->property_id }}/user/{{ $item->id }}">{{ $item->name }}</a></td>
                       <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
                       <td>{{ $item->email }}</td>
                       <td>{{ $item->user_type }}</td>
                       <td>{{ $item->property }}</td>
                       <td>{{ $item->property_type }}</td>
                      
                       <td>{{ $item->property_ownership }}</td>
                      
                       <td>{{ Carbon\Carbon::parse($item->email_verified_at)->format('M d Y').' '.Carbon\Carbon::parse($item->email_verified_at)->toTimeString() }}</td>
                    
                       <td>{{ $item->account_type }}</td>
                       <td>{{ $item->last_login_ip }}</td>
                       <td>{{ Carbon\Carbon::parse($item->last_login_at)->format('M d Y').' '.Carbon\Carbon::parse($item->last_login_at)->toTimeString() }}</td>
                       <td>{{ Carbon\Carbon::parse($item->last_logout_at)->format('M d Y').' '.Carbon\Carbon::parse($item->last_logout_at)->toTimeString() }}</td>
                       
                       <?php  
                          $diffInMinutes = Carbon\Carbon::parse($item->last_logout_at)->diffInMinutes();
                          $diffInHours = Carbon\Carbon::parse($item->last_logout_at)->diffInHours();
                          $diffInDays = Carbon\Carbon::parse($item->last_logout_at)->diffInDays()
                       ?>
                       <td>
                          @if($item->user_current_status === 'online')
                         <span class="badge badge-success"> {{ $item->user_current_status }}</span>
                         @else
                          @if($diffInMinutes < 60)
                          <span class="badge badge-secondary"> {{ $diffInMinutes }} minutes ago</span> 
                            @elseif($diffInHours > 24)
                            <span class="badge badge-secondary"> {{ $diffInDays }} days ago</span>
                            @else
                            <span class="badge badge-secondary">  {{ $diffInHours }} hours ago</span>
                            @endif
                         @endif
                        </td>      
                      
                   </tr>
                   @endforeach
                  </tbody>
                </table>
              </div> 
            </div>
            </div>
          </div>
        
@endif
                                    

@endsection


@section('scripts')
{!! $signup_rate->script() !!}
@endsection



