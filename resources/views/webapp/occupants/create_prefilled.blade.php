@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no )

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-4">
        {{-- <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/home/{{ $unit->unit_id }}"><i
            class="fas fa-home"></i> Home</a> --}}
        <h6 class="h2 text-dark d-inline-block mb-0">Occupant registration form</h6>

    </div>
</div>
<form id="addTenantForm1" action="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}/occupant"
    method="POST">
    @csrf
</form>
<?php $explode = explode(" ", $current_owner->name);?>
<div class="row">

    <div class="col">
        <small class="">First Name <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="text" class="form-control form-control" name="first_name" id="first_name"
            value="{{ $explode[0] }}">
    </div>
    <div class="col">
        <small class="">Middle Name</small>
        <input form="addTenantForm1" type="text"
            class="form-control form-control-user @error('middle_name') is-invalid @enderror" name="middle_name"
            id="middle_name" value="{{ old('middle_name') }}">
        @error('middle_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col">
        <small class="">Last Name <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="text" class="form-control form-control-user" name="last_name" id="last_name"
            value="{{ old('last_name')? old('last_name'): $explode[1] }}">


    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <small class="">Birthdate <span class="text-danger">*</span></small></small>
        <input form="addTenantForm1" type="date"
            class="form-control form-control-user @error('birthdate') is-invalid @enderror" name="birthdate"
            id="birthdate" value="{{ old('birthdate') }}">

        @error('birthdate')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col">
        <small class="">Gender <span class="text-danger">*</span></small></small>
        <select form="addTenantForm1" id="gender" name="gender"
            class="form-control form-control-user @error('gender') is-invalid @enderror">
            <option value="{{ old('gender')? old('gender'): '' }}" selected>
                {{ old('gender')? old('gender'): 'Please select one' }} </option>
            <option value="male">male</option>
            <option value="female">female</option>
        </select>

        @error('gender')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col">
        <small class="">Civil Status <span class="text-danger">*</span></small></small>
        <select form="addTenantForm1" id="civil_status" name="civil_status"
            class="form-control form-control-user @error('civil_status') is-invalid @enderror">
            <option value="{{ old('civil_status')? old('civil_status'): '' }}" selected>
                {{ old('civil_status')? old('civil_status'): 'Please select one' }} </option>
            <option value="single">single</option>
            <option value="married">married</option>
        </select>

        @error('civil_status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col">
        <small class="">ID/ID Number <span class="text-danger">*</span></small></small>
        <input form="addTenantForm1" type="text"
            class="form-control form-control-user @error('id_number') is-invalid @enderror" name="id_number"
            id="id_number" value={{ old('id_number') }}>

        @error('id_number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<input type="hidden" form="addTenantForm1" value="{{Session::get('property_id')}}" name="property_id">
<br>
<div class="row">
    <div class="col">
        <small class="">Mobile <span class="text-danger">*</span></small>
        {{-- <input form="addTenantForm1" type="number" class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no" id="contact_no"  value="{{ $current_owner->mobile }}">
        --}}
        <input form="addTenantForm1" type="number"
            class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no"
            id="contact_no" value="12">
        @error('contact_no')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    {{-- <div class="col">
          <small class="">Email <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="email" class="form-control form-control-user @error('email_address') is-invalid @enderror" name="email_address" id="email_address" value="{{ $current_owner->email }}">

    @error('email_address')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div> --}}
</div>
<hr>

{{-- <a href="/property/{{Session::get('property_id')}}/home/{{ $unit->unit_id }}/tenant" class="btn
btn-danger">Reset</a> --}}
<button type="submit" form="addTenantForm1" class="btn btn-success btn-user btn-block"> Submit</button>



@endsection

@section('main-content')

@endsection

@section('scripts')


@endsection