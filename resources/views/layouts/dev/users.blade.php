@extends('layouts.argon.main')

@section('title', 'Users')

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
              <a class="nav-link active" href="/dev/users">
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
              <a class="nav-link" href="/dev/tenants">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Users</h6>
    
  </div>
  

</div>
<div class="row">
<div class="table-responsive text-nowrap">
<table class="table" >
  <?php $ctr=1; ?>
  <thead>
    <tr>
     <th>#</th>
     <th>Name</th>
     <th>Email</th>
  
     <th>Role</th>
      <th>Plan</th>
     <th>Created at</th>
     <th>Verified at</th>
   
  </tr>
  </thead>
  <tbody>
   @foreach ($users as $item)
   <tr>
    <th>{{ $ctr++ }}</th>
     <td><a href="/dev/user/{{ $item->id }}">{{ $item->name }}</a></td>
     <td>{{ $item->email }}</td>
     <td>{{ $item->user_type }}</td>
     <td><a href="/dev/user/{{ $item->id }}/plans">{{ $item->account_type }}</a></td>
      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
      <td>
        @if($item->email_verified_at == null)
        null
        @else
        {{ Carbon\Carbon::parse($item->email_verified_at)->format('M d Y').' '.Carbon\Carbon::parse($item->email_verified_at)->toTimeString() }}
        @endif
      </td>
   
     
   @endforeach
  </tbody>
</table>


</div>
</div>
  

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection


