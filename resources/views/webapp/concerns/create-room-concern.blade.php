@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Details</h6>
  </div>
</div>
<form id="createConcernForm"
  action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/store/concern" method="POST">
  @csrf
</form>



<div class="row">
  <div class="col-md-10 py-3 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="">Reported on:</label>
            <input form="createConcernForm" name="reported_at" class="form-control" type="date"
              value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
            @error('reported_at')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Room:</label>
            <input form="createConcernForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control"
              type="text" required readonly>
            <input form="createConcernForm" name="concern_unit_id" value="{{ $room->unit_id }}" class="form-control"
              type="hidden" required readonly>
          
          </div>
          <div class="form-group col-md-3">
            <label for="">Reported by:</label>
            <select form="createConcernForm" class="form-control" name="concern_tenant_id">
              <option value="{{ old('concern_tenant_id') }}" selected>{{ old('concern_tenant_id') }}</option>
              @foreach ($tenants as $item)
              <option value="{{ 'tenant-'.$item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} | tenant | {{ $item->contract_status }}</option>
              @endforeach
              @foreach ($owners as $item)
              <option value="{{ 'owner-'.$item->owner_id }}">{{ $item->name }} | owner | {{ $item->status }}</option>
              @endforeach
            </select>
            @error('concern_tenant_id')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Contact no:</label>
            <input name="contact_no" form="createConcernForm" value="{{ old('contact_no') }}" class="form-control"
              type="number" required>
            @error('contact_no')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="">Concern/Request:</label>
              <textarea form="createConcernForm" name="details" cols="115%" rows="5"
                class="form-control">{{ old('details') }}</textarea>
              @error('details')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>


          </div>


      
      </div>

      <div class="form-row">
        <div class="form-group col-md-12 mx-auto">
          <button type="submit" form="createConcernForm" class="btn btn-primary btn-block"
            onclick="this.form.submit(); this.disabled = true;"> Next</button>
          <br>
          <p class="text-center">
            <a class="text-center text-dark"
              href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/#concerns">Cancel</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')

@endsection