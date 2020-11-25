@extends('templates.webapp-new.template')

@section('title', 'Personnels')

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
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/calendar">
                <i class="fas fa-calendar-alt text-red"></i>
                <span class="nav-link-text">Calendar</span>
              </a>
            </li>
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
              <a class="nav-link active" href="/property/{{$property->property_id }}}/personnels">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Personnels</h6>
    
  </div>
  <div class="col-lg-6 col-5 text-right">
    <a href="#" data-toggle="modal" data-target="#addPersonnelModal" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
  </div>


</div>

<div class="row">
  
<div class="table-responsive text-nowrap">
     
  <table class="table">
    <thead>
      <?php $ctr=1;?>
      <tr>
          <th>#</th>
          <th>Name</th>
          <th>Mobile NO</th>
          <th>Role</th>
          <th>Added On</th>
     </tr>
    </thead>
    <tbody>
    @foreach ($personnels as $item)
    <tr>
      <th>{{ $ctr++ }}</th>
        <td>{{ $item->personnel_name }}</td>
        <td>{{ $item->personnel_contact_no }}</td>
       
        <td>{{ $item->personnel_type }}</td>
        <td>{{ $item->created_at }}</td>
    </tr>
      @endforeach
    </tbody>
  </table>
  
</div>
</div>

   {{-- Modal to moveout tenant --}}
   <div class="modal fade" id="addPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Personnel</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="addPersonnelForm" action="/property/{{ $property->property_id }}/personnel" method="POST">
            @csrf
            </form>
            <input type="hidden" form="addPersonnelForm" name="property_id" value="{{ $property->property_id }}" required>
           <div class="row">
             <div class="col">
              <small>Name</small>
              <input type="text" form="addPersonnelForm" class="form-control" name="personnel_name" required >
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col">
               <small>Mobile</small>
               <input form="addPersonnelForm" type="number" class="form-control" name="personnel_contact_no" required>
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col">
               <small>Role</small>
               <select class="form-control" form="addPersonnelForm" name="personnel_type" id="" required>
                 <option value="" selected>Please select one</option>
                 <option value="housekeeping">housekeeping</option>
                 <option value="maintenance">maintenance</option>
               </select>
             </div>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-sm text-dark-50"></i> Cancel</button> 
            <button type="submit" form="addPersonnelForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
        </div>
     
    </div>
    </div>
</div>
</div>

@endsection



@section('scripts')
  
@endsection



