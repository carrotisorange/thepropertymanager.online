@extends('layouts.argon.main')

@section('title', 'System Updates')

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
              <a class="nav-link" href="/dev/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/dev/updates" target="_blank">
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
  <div class="col-md-9 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">System Updates</h6>

  </div>
     

</div>

<div class="row">
  <div class="col">

      

        <form action="/dev/updates/store" method="POST">
          @csrf

          <label for="">What feature is the update for?</label>
          <input class="form-control form-control-user @error('feature') is-invalid @enderror" name="feature" id="" cols="30" rows="3" value="{{ old('feature') }}" placeholder="remittance"/>
          
            @error('feature')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <br>
       <label for="">What is the link for the update?</label>
          <input class="form-control form-control-user @error('link') is-invalid @enderror" name="link" id="" cols="30" rows="3" value="{{ old('link') }}" placeholder="/property/tenant/123/"/>
          
            @error('link')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
    <br>
    <label for="">What is the update all about?</label>
          <textarea  class="form-control form-control-user @error('description') is-invalid @enderror" name="description" id="" cols="30" rows="3" value="{{ old('description') }}" placeholder="A feature to add remittance to unit owner has been added."></textarea required>
          
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
        <br>
      <p class="text-right">
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Post Updates </button>
      </p>
      </form>
    
  
  </div>
</div>
<div class="row">
  <div class="col">
      <div class="list-group list-group-flush">
          @foreach ($updates as $item)
       
          <a href="#!" class="list-group-item list-group-item-action">
            <div class="row align-items-center">
              <div class="col-auto">
                <!-- Avatar -->
                @if($item->feature === 'tenant')
              <i class="fas fa-user text-green fa-lg"></i>
              @elseif($item->feature === 'payable')
              <i class="fas fa-file-export text-indigo fa-lg"></i>
              @elseif($item->feature === 'owner')
              <i class="fas fa-user-tie text-teal fa-lg"></i>
              @elseif($item->feature === 'concern')
              <i class="fas fa-tools text-cyan fa-lg"></i>
              @elseif($item->feature === 'payment')
              <i class="fas fa-coins text-yellow fa-lg"></i>
              @elseif($item->feature === 'bill')
              <i class="fas fa-file-invoice-dollar text-pink fa-lg"></i>
              @elseif($item->feature === 'joborder')
              <i class="fas fa-list text-dark fa-lg"></i>
              @elseif($item->feature === 'unit')
              <i class="fas fa-home text-indigo fa-lg"></i>
              @elseif($item->feature === 'contract')
              <i class="fas fa-file-signature text-teal fa-lg"></i>
              @elseif($item->feature === 'search')
              <i class="fas fa-search text-blue fa-lg"></i>
              @elseif($item->feature === 'financial')
              <i class="fas fa-file-export text-indigo fa-lg"></i>
              @elseif($item->feature === 'user')
              <i class="fas fa-user-circle text-green fa-lg"></i>
              @elseif($item->feature === 'issue')
              <i class="fas fa-dizzy text-red text-red fa-lg"></i>
              @elseif($item->feature === 'remittance')
              <i class="fas fa-hand-holding-usd text-teal fa-lg"></i>
              @else
              <i class="fas fa-building text-primary fa-lg"></i>
              @endif
              </div>
              <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h4 class="mb-0 text-sm">{{ $item->feature }}</h4>
                  </div>
                  <div class="text-right text-muted">
                    <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                  </div>
                </div>
                <p class="text-sm text-muted mb-0">{{ $item->description }}</p>
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



