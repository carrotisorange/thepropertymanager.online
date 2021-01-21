@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no )

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{Session::get('property_name')}}
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
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/rooms">
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
  <div class="col-lg-4">
    {{-- <a class="btn btn-primary" href="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}"><i class="fas fa-home"></i> Home</a> --}}
    <h6 class="h2 text-dark d-inline-block mb-0">Occupant registration form</h6> 
    
  </div>
</div>
<form id="addTenantForm1" action="/property/{{ $property->property_id }}/unit/{{ $unit->unit_id }}/occupant" method="POST">
  @csrf
  </form>

  <div class="row">

      <div class="col">
          <small class="">First Name <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" name="first_name" id="first_name"  value="{{ old('first_name') }}">
             @error('first_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      <div class="col">
          <small class="">Middle Name</small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('middle_name') is-invalid @enderror" name="middle_name" id="middle_name"  value="{{ old('middle_name') }}">
          @error('middle_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="col">
          <small class="">Last Name  <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" name="last_name" id="last_name"  value="{{ old('last_name') }}">
  
          @error('last_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      </div>
      <br>
  <div class="row">
      <div class="col">
          <small class="">Birthdate <span class="text-danger">*</span></small></small>
          <input form="addTenantForm1" type="date" class="form-control form-control-user @error('birthdate') is-invalid @enderror" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" >
  
          @error('birthdate')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">Gender <span class="text-danger">*</span></small></small>
          <select form="addTenantForm1"  id="gender" name="gender" class="form-control form-control-user @error('gender') is-invalid @enderror">        
              <option value="{{ old('gender')? old('gender'): '' }}" selected>{{ old('gender')? old('gender'): 'Please select one' }} </option>
              <option value="male">male</option>
              <option value="female">female</option>
          </select>
  
          @error('gender')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">Civil Status <span class="text-danger">*</span></small></small>
          <select form="addTenantForm1"  id="civil_status" name="civil_status" class="form-control form-control-user @error('civil_status') is-invalid @enderror">   
            <option value="{{ old('civil_status')? old('civil_status'): '' }}" selected>{{ old('civil_status')? old('civil_status'): 'Please select one' }} </option>
              <option value="single">single</option>
              <option value="married">married</option>
          </select>

          @error('civil_status')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">ID/ID Number <span class="text-danger">*</span></small></small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('id_number') is-invalid @enderror" name="id_number" id="id_number" value={{ old('id_number') }}>

          @error('id_number')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
  </div>

  <input type="hidden" form="addTenantForm1" value="{{ $property->property_id }}" name="property_id">
  <br>
  <div class="row">
      <div class="col">
          <small class="">Mobile <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="number" class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no" id="contact_no"  value="{{ old('contact_no') }}">
  
        @error('contact_no')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="col">
          <small class="">Email <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="email" class="form-control form-control-user @error('email_address') is-invalid @enderror" name="email_address" id="email_address" value="{{ old('email_address') }}">
  
        @error('email_address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
  </div>
  <hr>
    
      {{-- <a href="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}/tenant" class="btn btn-danger">Reset</a> --}}
      <button type="submit" form="addTenantForm1" class="btn btn-success btn-user btn-block"> Submit</button>

  

@endsection

@section('main-content')

@endsection

@section('scripts')


@endsection



