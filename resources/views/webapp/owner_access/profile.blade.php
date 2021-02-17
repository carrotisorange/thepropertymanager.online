@extends('webapp.owner_access.template')

@section('title', 'Profile')


@section('sidebar')

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Owner Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
              <i class="fas fa-file-signature text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
          </li>
  

        </ul>
      </div>
    </div>
  </div>
</nav>
@endsection

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Profile</h6>
    
  </div>
@endsection

@section('main-content')
<div class="col-md-12 mx-auto">
<form id="editUserForm" action="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/profile" method="POST">
      @method('put')
      @csrf
    </form>
      <label>Name</label>
      <input form="editUserForm" id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" >
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      <br>
      <label>Email</label>
      <input form="editUserForm" id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      <br>
      <label>Mobile</label>
      <input form="editUserForm" id="contact_no" type="text" class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ $owner->mobile }}" required autocomplete="contact_no">
            @error('contact_no')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      <br>
      <label>New Password</label>
      <input form="editUserForm" id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" autocomplete="password">
            <small class="text-danger">Changing your password will log you out of the application.</small>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      <p class="text-right">
        <button form="editUserForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?');"> Update</button>
      </p>

     
  </div>
@endsection

@section('scripts')
  
@endsection



