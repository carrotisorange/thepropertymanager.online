@extends('layouts.argon.main')

@section('title',  $user->name)

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
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $user->name }}</h6>
    
  </div>
  

</div>

<form id="editPropertyForm" action="/dev/user/{{ $user->id }}/" method="POST">
    @method('put')
    @csrf


<div class="row">
    <div class="col">
        <label>Name</label>
        <input form="editPropertyForm" class="form-control" type="text" name="name" value="{{ $user->name }}" >
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label>Email</label>
        <input form="editPropertyForm" class="form-control" type="email" name="email" value="{{ $user->email }}" >
    </div>
   
</div>
<br>
<div class="row">
    <div class="col">
        <label>Role</label>
        <select form="editPropertyForm" class="form-control" name="user_type" type="text" id="">
            <option value="{{ $user->user_type }}">{{ $user->user_type }}</option>
            <option value="admin">admin</option>
            <option value="ap">ap</option>
            <option value="billing">billing</option>
        
            <option value="treasury">treasury</option>
        </select>
    </div>
</div>
<br>
<div class="row">
  <div class="col">
      <label>Plan</label>
      <select form="editPropertyForm" class="form-control" name="account_type" type="text" id="">
          <option value="{{ $user->account_type }}">{{ $user->account_type }}</option>
          <option value="starter">starter</option>
          <option value="basic">basic</option>
          <option value="large">large</option>
          <option value="advanced">advanced</option>
          <option value="enterprise">enterprise</option>
      </select>
  </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label>Email verified at</label>
        <input form="editPropertyForm" class="form-control" type="date" name="email_verified_at" value="{{ Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d') }}" >
    </div>
   
</div>
            <br>    
         <div class="row">
         <div class="col">
          <p class="text-right">   
           
            <button type="submit" form="editPropertyForm" class="btn btn-primary" > Update</button>
        </p>   
         </div>
        </div>  
  



</div>
  

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



