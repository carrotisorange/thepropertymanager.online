@extends('layouts.argon.main')

@section('title', 'Tenant Information Sheet')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Tenant Information Sheet</h6>
  </div>
</div>
<form id="createTenantForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/store/tenant"
  method="POST">
  @csrf
</form>

<div class="row">
  <div class="col-md-10 py-3 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="">Room:</label>
            <input form="createTenantForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control"
              type="text" required readonly>
          </div>
          <div class="form-group col-md-4">
            <label for="">Beds:</label>
            <input form="createTenantForm" value="{{ $room->occupancy }} pax" class="form-control" type="text" required
              readonly>
          </div>
          <div class="form-group col-md-4">
            <label for="">Rent/mo:</label>
            <input form="createContractForm" value="{{ $room->rent }}" class="form-control" type="number" required
              readonly>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="">Last name:</label>
            <input name="last_name" form="createTenantForm" value="{{ old('last_name') }}" class="form-control"
              type="text" required>
            @error('last_name')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">First name:</label>
            <input name="first_name" form="createTenantForm" value="{{ old('first_name') }}" class="form-control"
              type="text" required>
            @error('first_name')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">Middle name:</label>
            <input name="middle_name" form="createTenantForm" value="{{ old('middle_name') }}" class="form-control"
              type="text" required>
            @error('middle_name')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="">Birthdate:</label>
            <input name="birthdate" form="createTenantForm" value="{{ old('birthdate') }}" class="form-control"
              type="date" required>
            @error('birthdate')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">Gender:</label>
            <select form="createTenantForm" class="form-control" name="gender">
              <option value="{{ old('gender') }}">{{ old('gender') }}</option>
              <option value="female">female</option>
              <option value="male">male</option>
            </select>
            @error('gender')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">Civil status:</label>
            <select form="createTenantForm" class="form-control" name="civil_status">
              <option value="{{ old('civil_status') }}">{{ old('civil_status') }}</option>
              <option value="married">married</option>
              <option value="single">single</option>
            </select>
            @error('civil_status')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="">Nationality:</label>
            <input name="nationality" form="createTenantForm" value="{{ old('birthdate') }}" class="form-control"
              type="text" required>
            @error('nationality')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">Ethnicity:</label>
            <input name="ethnicity" form="createTenantForm" value="{{ old('ethnicity') }}" class="form-control"
              type="text" required>
            @error('ethnicity')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">ID presented/ID number:</label>
            <input name="id_number" form="createTenantForm" value="{{ old('id_number') }}" class="form-control"
              type="text" required>
            @error('id_number')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="">Provincial address:</label>
            <input name="provincial_address" form="createTenantForm" value="{{ old('provincial_address') }}"
              class="form-control" type="text" required>
            @error('provincial_address')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="">Contact number:</label>
            <input name="contact_no" form="createTenantForm" value="{{ old('contact_no') }}" class="form-control"
              type="number" required>
            @error('contact_no')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label for="">Email address:</label>
            <input name="email" form="createTenantForm" value="{{ old('email') }}" class="form-control" type="email"
              required>
            @error('email')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-group col-md-11 mx-auto">
          <button type="submit" form="createTenantForm" class="btn btn-primary btn-block"
            onclick="this.form.submit(); this.disabled = true;"> Continue</button>
          <br>
          <p class="text-center">
            <a class="text-center text-dark"
              href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}">Cancel</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection