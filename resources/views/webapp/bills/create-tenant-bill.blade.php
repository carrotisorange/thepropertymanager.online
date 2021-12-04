@extends('layouts.argon.main')

@section('title', 'Create Bill')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 d-inline-block mb-0"><a
        href="/property/{{ Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/#bills">{{
        $tenant->first_name.' '.$tenant->last_name }}</a>/ Create Bill</h6>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="form-group ">
          <label><b>Particular</b></label>
          <form id="selectParticularForm"
            action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/post/particular" method="POST"
            onchange="submit();">
            @csrf
    
          <select class="form-control" form="selectParticularForm" name="particular_id_foreign" id="">
            <option value="{{ old('particular_id_foreign')? old('particular_id_foreign'): ''}}" selected>
              {{ old('particular_id_foreign')? old('particular_id_foreign'): 'Please select one' }}
            </option>
            @foreach ($particulars as $particular)
            <option value="{{ $particular->particular_id }}">{{ $particular->particular }}</option>
            @endforeach
          </select>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection