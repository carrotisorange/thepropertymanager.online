@extends('layouts.argon.main')

@section('title', 'Create rooms')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Create credentials</h6>
    </div>
</div>
<form id="createCredentialsForm"
    action="{{ route('store-credentials', ['property_id' => Session::get('property_id'), 'tenant_id' => $tenant->tenant_id]) }}"
    method="POST">
    @csrf
</form>


<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Number of rooms</label>
                    <input type="text" name="name" form="createCredentialsForm"
                        class="form-control form-control-user @error('name') is-invalid @enderror"
                        value="{{ $tenant->first_name.' '.$tenant->last_name }}" required readonly>
                    <input type="hidden" name="tenant_id" form="createCredentialsForm" value="{{ $tenant->tenant_id }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" form="createCredentialsForm"
                        class="form-control form-control-user @error('email') is-invalid @enderror"
                        value="{{ old('email')? old('email'): $tenant->email }}" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" form="createCredentialsForm"
                        class="form-control form-control-user @error('password') is-invalid @enderror"
                        value="{{ old('password')? old('password'): $tenant->password }}" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>





                <div class="form-group">
                    <button type="submit" form="createCredentialsForm" class="btn btn-primary btn-block"
                        onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Save</button>
                    <br>
                    <p class="text-center">
                        <a class="text-center text-dark"
                            href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#credentials"><i class="fas fa-times"></i> Cancel</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection