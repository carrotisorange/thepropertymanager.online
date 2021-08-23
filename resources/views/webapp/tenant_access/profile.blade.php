@extends('webapp.tenant_access.template')

@section('title', 'Profile')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Profile</h6>

</div>
@endsection

@section('main-content')
<div class="col-md-12 mx-auto">
    <form id="editUserForm" action="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/profile" method="POST">
        @method('put')
        @csrf
    </form>
    <label>Name</label>
    <input form="editUserForm" id="name" type="text"
        class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}"
        required autocomplete="name">
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <br>
    <label>Email</label>
    <input form="editUserForm" id="email" type="email"
        class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
        value="{{ $user->email }}" required autocomplete="email">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <br>
    <label>Mobile</label>
    <input form="editUserForm" id="contact_no" type="text"
        class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no"
        value="{{ $tenant->contact_no }}" required autocomplete="contact_no">
    @error('contact_no')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <br>
    <label>New Password</label>
    <input form="editUserForm" id="password" type="password"
        class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
        autocomplete="password">
    <small class="text-danger">Changing your password will log you out of the application.</small>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <p class="text-right">
        <button form="editUserForm" type="submit" class="btn btn-primary btn-sm"
            onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-check"></i>
            Update</button>
    </p>


</div>
@endsection

@section('scripts')

@endsection