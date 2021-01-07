@extends('layouts.argon.main')

@section('title', 'Issues')

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
              <a class="nav-link active" href="/dev/issues" target="_blank">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Issue # {{ $issue->issue_id }}</h6>
    
  </div>
  

</div>


<form id="editPropertyForm" action="/dev/issue/{{ $issue->issue_id }}/update" method="POST">
    @method('put')
    @csrf

<div class="row">
    <div class="col">
        <label>Status</label>
        <select form="editPropertyForm" class="form-control" name="status" type="text" id="">
            <option value="{{ $issue->status }}">{{ $issue->status }}</option>
            <option value="closed">closed</option>
            <option value="active">active</option>
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label>Details</label>
        <textarea form="editPropertyForm" rows="4" cols="50" class="form-control" name="details">{{ $issue->details }}</textarea>
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
</form>
<hr>


<div class="row">
  <div class="col">

      

        <form action="/dev/issue/{{ $issue->issue_id }}/responses" method="POST">
          @csrf
      
    
          <textarea  class="form-control form-control-user @error('response') is-invalid @enderror" name="response" id="" cols="30" rows="3" placeholder="enter your response here..."></textarea required>
          
            @error('response')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
        <br>
      <p class="text-right">
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add </button>
      </p>
      </form>
    
  
  </div>
</div>

<div class="row">
  <div class="col">
    
      <h6 class="h2 text-dark d-inline-block mb-0">Responses ({{ $responses->count() }})</h6>
      <br><br>

     
    
      
            <div class="list-group list-group-flush">
                @foreach ($responses as $item)
             
                <a href="#/" class="list-group-item list-group-item-action">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <!-- Avatar -->
                    @if($item->user_type === 'dev')
                    <i class="fas fa-user-secret text-red"></i>
                    @else
                    <i class="fas fa-user-circle text-primary"></i>
                    @endif
                    </div>
                    <div class="col">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <h4 class="mb-0 text-sm">{{ $item->name }}</h4>
                        </div>
                        <div class="text-right text-muted">
                          <small>{{ Carbon\Carbon::parse($item->responded_at)->format('M-d-Y') }}</small>
                        </div>
                      </div>
                      <p class="text-sm text-muted mb-0">{{ $item->response }}</p>
                    </div>
                  </div>
                </a>
      
                @endforeach
      
              </div>
      
 
    </div>
  </div>
    
@endsection

@section('main-content')

@endsection

@section('scripts')

@endsection



