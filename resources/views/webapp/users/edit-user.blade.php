@extends('layouts.argon.main')

@section('title', 'Profile | Edit')

@section('content')
<div class="col-lg-12 mb-4">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">EDIT PROFILE </h6>
    </div>
    <div class="card-body">
      <form id="editUserForm" action="/users/{{ $user->id }}" method="POST">
        @method('put')
        {{ csrf_field() }}
      </form>
      <div class="row">
        <div class="col">
          <small>Name</small>
          <input form="editUserForm" id="name" type="text"
            class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
            value="{{ $user->name }}" required autocomplete="name">
          @error('name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col">
          <small>Email</small>
          <input form="editUserForm" id="email" type="email"
            class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
            value="{{ $user->email }}" required autocomplete="email">
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
      <hr>
      {{-- <div class="row">
    <div class="col">
      <small>Property</small>
      <input form="editUserForm" id="email" type="text" class="form-control form-control-user @error('property') is-invalid @enderror" name="property" value="{{ $user->property }}"
      required autocomplete="property">
      @error('property')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
  <hr> --}}
  <div class="row">
    <div class="col">

    </div>
  </div>
  <div class="row">
    <div class="col">
      <p class="text-right">
        <a href="/users/{{ Auth::user()->id }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
            class="fas fa-times fa-sm text-white-50"></i> Cancel</a>

      </p>
    </div>
  </div>


</div>
</div>

</div>
@endsection

@section('scripts')

@endsection