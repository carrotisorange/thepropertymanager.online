@extends('templates.webapp-new.template')

@section('title',  $tenant->first_name.' '.$tenant->last_name)

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
              <a class="nav-link " href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/calendar">
                <i class="fas fa-calendar-alt text-red"></i>
                <span class="nav-link-text">Calendar</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{$property->property_id }}/tenants">
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
              <a class="nav-link" href="/property/{{$property->property_id }}/users">
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
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6>
    
  </div>

</div>
<form id="editTenantForm" action="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}" method="POST">
    @method('put')
    {{ csrf_field() }}
</form>
 
            <div class="form-group row">
                <div class="col">
                    <small>First Name</small>
                    <input form="editTenantForm" class="form-control" type="text" name="first_name" value="{{ $tenant->first_name }}">
                </div>
                <div class="col">
                    <small>Middle Name</small>
                    <input form="editTenantForm" class="form-control" type="text" name="middle_name" value="{{ $tenant->middle_name }}">
                </div>
                <div class="col">
                    <small>Last Name</small>
                    <input form="editTenantForm" class="form-control" type="text" name="last_name" value="{{ $tenant->last_name }}">
                </div>
            </div>
     
            <div class="form-group row">
                <div class="col">
                    <small>Gender</small>
                    <select form="editTenantForm" class="form-control" name="gender" id="">
                        <option value="{{ $tenant->gender }}">{{ $tenant->gender }}</option>
                        <option value="female">female</option>
                        <option value="male">male</option>
                    </select>
                </div>
                <div class=" col">
                    <small>Birthdate</small>
                    <input form="editTenantForm" class="form-control" type="date" name="birthdate" value="{{ $tenant->birthdate }}">
                </div>
                <div class="col">
                    <small>Civil Status:</small>
                    <select form="editTenantForm"  id="civil_status" name="civil_status" class="form-control">
                        <option value="{{ $tenant->civil_status }}" selected>{{ $tenant->civil_status }}</option>
                        <option value="single" selected>single</option>
                        <option value="married">married</option>
                    </select>
                </div>
                <div class=" col">
                    <small>ID/ID number</small>
                    <input form="editTenantForm" class="form-control" type="text" name="id_number" value="{{ $tenant->id_number }}">
                </div>
            </div>
           
            <div class="form-group row">
                <div class=" col-md-8">
                    <small for="">Barangay</small>
                    <input form="editTenantForm" class="form-control" type="text" name="barangay" value="{{ $tenant->barangay }}">
                </div>
                <div class=" col-md-4">
                    <small for="">City</small>
                    <input form="editTenantForm" class="form-control" type="text" name="city" value="{{ $tenant->city }}">
                </div>
               
            </div>
            <div class="form-group row">
                <div class=" col-md-4">
                    <small for="">Province</small>
                    <input form="editTenantForm" class="form-control" type="text" name="province" value="{{ $tenant->province }}">
                </div>
                <div class=" col-md-4">
                    <small for="">Country</small>
                    <input form="editTenantForm" class="form-control" type="text" name="country" value="{{ $tenant->country }}">
                </div>
                <div class=" col-md-4">
                    <small for="">Zipcode</small>
                    <input form="editTenantForm" class="form-control" type="text" name="zip_code" value="{{ $tenant->zip_code }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <small for="">Contact No</small>
                    <input form="editTenantForm" class="form-control" type="text" name="contact_no" value="{{ $tenant->contact_no }}">
                </div>
                <div class="col" id="email_address">
                    <small for="">Email Address</small>
                    <input form="editTenantForm" class="form-control" type="text" name="email_address" value="{{ $tenant->email_address }}">
                  @if($tenant->email_address === null)
                  <small class="text-danger">Please add an email</small>
                  @endif
                </div>
            </div>
      

            <hr>

            <div class="form-group row">
                <div class="col">
                    <small for="">High School</small>
                    <input form="editTenantForm" class="form-control" type="text" name="high_school" value="{{ $tenant->high_school }}">
                </div>
                <div class="col">
                    <small for="">Adddress</small>
                    <input form="editTenantForm" class="form-control" type="text" name="high_school_address" value="{{ $tenant->high_school_address }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <small for="">College/University</small>
                    <input form="editTenantForm" class="form-control" type="text" name="college_school" value="{{ $tenant->college_school }}">
                </div>
                <div class="col">
                    <small for="">Address</small>
                    <input form="editTenantForm" class="form-control" type="text" name="college_school_address" value="{{ $tenant->college_school_address }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <small for="">Course</small>
                    <input form="editTenantForm" class="form-control" type="text" name="course" value="{{ $tenant->course }}">
                </div>
                <div class="col">
                    <small for="">Year Level</small>
                    <select form="editTenanForm" class="form-control" name="year_level" id="">
                        <option value="{{ $tenant->year_level }}">{{ $tenant->year_level }}</option>
                          <option value="senior high">junior high</option>
                          <option value="first year">first year</option>
                          <option value="second year">second year</option>
                          <option value="third year">third year</option>
                          <option value="fourth year">fourth year</option>
                          <option value="fifth year">fifth year</option>
                          <option value="graduate student">graduate student</option>
                      </select>
                </div>
            </div>

            <hr>


            <div class="form-group row">
                <div class="col">
                    <small for="">Employer/Company</small>
                    <input form="editTenantForm" class="form-control" type="text" name="employer" value="{{ $tenant->employer }}">
                </div>
                <div class="col">
                    <small for="">Position/Job description</small>
                    <input form="editTenantForm" class="form-control" type="text" name="job" value="{{ $tenant->job }}">
                </div>
                <div class="col">
                    <small for="">Years of Employment</small>
                    <input form="editTenantForm" class="form-control" type="number" name="years_of_employment" value="{{ $tenant->years_of_employment }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <small for="">Address</small>
                    <input form="editTenantForm" class="form-control" type="text" name="employer_address" value="{{ $tenant->employer_address }}">
                </div>
                <div class="col">
                    <small for="">Contact No</small>
                    <input form="editTenantForm" class="form-control" type="text" name="employer_contact_no" value="{{ $tenant->employer_contact_no }}">
                </div>
                
            </div>
            <hr>
            {{-- @if($tenant->tenants_note !== 'new' )
            <div class="form-group row">
                <div class="col">
                  <small>Note</small>
                    <textarea form="editTenantForm" class="form-control" name="tenants_note" id="" cols="30" rows="5">
                        {{ $tenant->tenants_note }}
                    </textarea>
                </div>
            </div>
            @endif --}}


<p class="text-right">   
    <a href="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}" class="btn btn-secondary"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</a>
    <button type="submit" form="editTenantForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Save Changes</button>
</p>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



