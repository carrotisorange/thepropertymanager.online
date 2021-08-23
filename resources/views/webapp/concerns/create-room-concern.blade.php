@extends('layouts.argon.main')

@section('title', 'Create Concern')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Create Concern</h6>
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
              <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} |
                {{ $item->contract_status }}</option>
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
          <div class="form-group col-md-3">
            <label for="">Urgency:</label>
            <select form="createConcernForm" name="urgency" class="form-control" required>
              <option value="{{ old('urgency') }}" selected>{{ old('urgency') }}</option>
              <option value="emergency"> Emergency</option>
              <option value="major_concern"> Major Concern</option>
              <option value="minor_concern"> Minor Concern</option>

            </select>
            @error('urgency')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Warranty:</label>
            <select form="createConcernForm" name="is_warranty" id="is_warranty" class="form-control" required>
              <option value="{{ old('is_warranty') }}" selected>{{ old('is_warranty') }}</option>
              <option value="yes"> Yes</option>
              <option value="no"> No</option>

            </select>
            @error('is_warranty')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Scheduled on:</label>
            <input name="scheduled_at" form="createConcernForm" value="{{ old('scheduled_at') }}" class="form-control"
              type="date" required>
            @error('scheduled_at')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Endorsed to:</label>
            <select form="createConcernForm" class="form-control" name="concern_user_id">
              <option value="{{ old('concern_user_id') }}">{{ old('concern_user_id') }}</option>
              @foreach ($users as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
            @error('concern_user_id')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="">Course of action taken:</label>
            <textarea form="createConcernForm" name="action_taken" cols="115%" rows="5"
              class="form-control">{{ old('action_taken') }}</textarea>
            @error('action_taken')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>

        <div class="form-row">

          <div class="form-group col-md-3">
            <label for="">Resolved by:</label>
            <select form="createConcernForm" class="form-control" name="resolved_by">
              <option value="{{ old('resolved_by')? old('resolved_by'): '36' }}" selected>
                {{ old('resolved_by')? old('resolved_by'): 'NA' }}</option>
              @foreach ($users as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
            @error('resolved_by')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>

          <div class="form-group col-md-3">
            <label for="">Status:</label>
            <select form="createConcernForm" id="status" name="status" class="form-control" required>
              <option value="{{ old('status') }}" selected>{{ old('status') }}</option>
              <option value="pending">pending</option>
              <option value="active">active</option>
              <option value="closed">closed</option>
            </select>
            @error('status')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>

          <div class="form-group col-md-3">
            <label for="">Resolved on:</label>
            <input name="resolved_at" form="createConcernForm" value="{{ old('resolved_at') }}" class="form-control"
              type="date" required>
            @error('resolved_at')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>

          <div class="form-group col-md-3">
            <label for="">Rating:</label>
            <select form="createConcernForm" id="rating" class="form-control" required>
              <option value="{{ old('rating') }}" selected>{{ old('rating') }}</option>
              <option value="very poor">very poor</option>
              <option value="satisfactory">satisfactory</option>
              <option value="average">average</option>
              <option value="superior">superior</option>
              <option value="somewhat unsatisfactory">somewhat unsatisfactory</option>
            </select>
            @error('rating')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="">Remarks:</label>
            <textarea form="createConcernForm" name="remarks" cols="115%" rows="5"
              class="form-control">{{ old('remarks') }}</textarea>
            @error('remarks')
            <small class="text-danger">
              {{ $message }}
            </small>
            @enderror
          </div>
        </div>

      </div>

      <div class="form-group col-md-11 mx-auto">
        <button type="submit" form="createConcernForm" class="btn btn-primary btn-block"
          onclick="this.form.submit(); this.disabled = true;"> Submit</button>
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
@endsection

@section('scripts')

@endsection