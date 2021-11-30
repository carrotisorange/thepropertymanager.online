@extends('layouts.argon.main')

@section('title', 'Create owner"s credentials')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Create owner's credentials</h6>
    </div>
</div>
<form id="createOwnerCredentialsForm"
    action="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/store/credentials" method="POST">
    @csrf
</form>


<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">


                <div class="form-group">
                    <label>Name</label>
                    <input form="createOwnerCredentialsForm" type="text"
                        value="{{ old('name')?old('name'):$owner->name }}" class="form-control" name="name" required>
                    @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input form="createOwnerCredentialsForm" type="email"
                        value="{{ old('email')?old('email'):$owner->email }}" class="form-control" name="email">
                    @error('email')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input form="createOwnerCredentialsForm" type="password" class="form-control" name="password"
                        required>
                    @error('password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror

                </div>


                <div class="form-group">
                    <button type="submit" form="createOwnerCredentialsForm" class="btn btn-primary btn-block"
                        onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Save</button>
                    <br>
                    <p class="text-center">
                        <a class="text-center text-dark"
                            href="{{ url()->previous() }}/#credentials"><i class="fas fa-times"></i> Cancel</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection