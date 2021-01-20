@extends('layouts.argon.main')

@section('title', 'Results for ' .'"'.$search_key.'"')

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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
           <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Rooms</span>
              </a>
              @endif
            
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/occupants">
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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/users">
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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
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
    <h6 class="h2 text-dark d-inline-block mb-0"><span class=""> <small> you searched for </small></span> <span class="text-danger">"{{ $search_key }}"<span></h6>
  </div>

</div>
<div class="row">
    <div class="table-responsive text-nowrap">
       <div class="col-md-12">
        <p><span class="font-weight-bold">{{ $all_tenants->count() }}</span> matched for tenants...</p>
        @if($all_tenants->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
        
                <th>Email</th>
                <th>Mobile</th>
    
                <th>Civil status</th>
              
            </tr>
            <?php $tenant_ctr=1;?>
            @foreach ($all_tenants as $tenant)
            <tr>
                <th>{{ $tenant_ctr++ }}</th>
                <td><a href="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}">{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}</a></td>
                
              
                <td>{{ $tenant->email_address }}</td>
                <td>{{ $tenant->contact_no }}</td>
        
                <td>{{ $tenant->civil_status }}</td>
               
            </tr>
            @endforeach
            
         </table>
        @endif
         <br>

         <p><span class="font-weight-bold">{{ $units->count() }}</span> matched for rooms...</p>
         @if($units->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Building</th>
                <th>Room</th>
                <th>Floor</th>
                <th>Type</th>
          
                <th>Status</th>
                <th>Occupancy</th>
                <th>Rent</th>
            </tr>
            <?php $unit_ctr=1;?>
            @foreach ($units as $unit)
            <tr>
                <th>{{ $unit_ctr++ }}</th>
                <td>{{ $unit->building }}</td>
                <td><a href="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}">{{ $unit->unit_no }}</a></td>
                <td>{{ $unit->floor }}</td>
                <td>{{ $unit->type }}</td>
                <td>{{ $unit->status }}</td>
                <td>{{ $unit->occupancy }} pax</td>
                <td>{{ number_format($unit->rent, 2) }}</td>
            </tr>
            @endforeach
         </table>
          @endif
         <br>

         <p><span class="font-weight-bold">{{ $all_owners->count() }}</span> matched for owners...</p>
         @if($all_owners->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                
                <th>Email</th>
                <th>Mobile</th>
                <th>Representative</th>
       
             
            </tr>
            <?php $owner_ctr=1;?>
            @foreach ($all_owners as $owner)
            <tr>
                <th>{{ $owner_ctr++ }}</th>
                <td><a href="/property/{{ $property->property_id }}/owner/{{ $owner->owner_id }}">{{ $owner->name }} </a></td>
              
               <td>{{ $owner->email}}</td>
               <td>{{ $owner->mobile }}</td>
               <td>{{ $owner->representative }}</td>
             
              

             
            </tr>
            @endforeach
    
         </table>
         @endif
       </div>
        
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



