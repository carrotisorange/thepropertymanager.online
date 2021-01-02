@extends('layouts.argon.main')

@section('title', 'Plans')

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
                <a class="nav-link active" href="/dev/plans">
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
  <div class="col-md-3">
    <h6 class="h2 text-dark d-inline-block mb-0">Plans</h6>
    
  </div>

  <div class="col-md-9 text-right">
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addPlan" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
  </div>
  

</div>
<div class="row">
    <div class="table-responsive text-nowrap">
        <table class="table" >
          <?php $ctr=1; ?>
          <thead>
            <tr>
             <th>#</th>
             <th>Plan</th>
             <th>Price/month</th>
             <th>Price/year</th>
             <th>Room limit</th>
             <th>User limit</th>
             <th>Property limit</th>
             <th>Trial expired at</th>
          </tr>
          </thead>
          <tbody>
           @foreach ($plans as $item)
           <tr>
            <th>{{ $ctr++ }}</th>
           <td>{{ $item->plan }}</td>
           <td>{{ $item->price_per_month }}</td>
           <td>{{ $item->price_per_year }}</td>
           <td>{{ $item->room_limit }}</td>
           <td>{{ $item->user_limit }}</td>
           <td>{{ $item->property_limit }}</td>
           <td>{{ $item->trial_expired_at }}</td>
           @endforeach
          </tbody>
        </table>
        
        
        </div>
</div>
  

<div class="modal fade" id="addPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Add Plan</h5>
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="addPlanForm" action="/plan" method="POST">
                @csrf
            </form>
  
            <div class="form-group">
                <label>Plan</label>
                <input form="addPlanForm" type="text" class="form-control" name="plan" required>
                
            </div>
  
            <div class="form-group">
                <label>Prince/month</label>
                <input form="addPlanForm" type="number" step="0.01" class="form-control" name="price_per_month" required>
                
            </div>
  
            <div class="form-group">
                <label>Price/year</label>
                <input form="addPlanForm" type="number" step="0.01" class="form-control" name="price_per_year" required>
                
            </div>

            
            <div class="form-group">
                <label>Room limit</label>
                <input form="addPlanForm" type="number" class="form-control" min="1" name="room_limit" required>
            </div>

            <div class="form-group">
                <label>User limit</label>
                <input form="addPlanForm" type="number" class="form-control" min="1" name="user_limit" required>
            </div>

            <div class="form-group">
                <label>Property limit</label>
                <input form="addPlanForm" type="number" class="form-control" min="1" name="property_limit" required>
            </div>

            <div class="form-group">
                <label>Trial expired at</label>
                <input form="addPlanForm" type="number" class="form-control" min="1" name="trial_expired_at" required>
                
            </div>
  
  
        </div>
        <div class="modal-footer">
          
            <button form="addPlanForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add</button>
            </div>
    </div>
    </div>
  </div>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



