@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Assessment</h6>
    </div>
</div>
<form id="createConcernForm"
    action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $concern->concern_tenant_id?$tenant->tenant_id:$tenant->owner_id }}/concern/{{ $concern->concern_id }}/store/assessment"
    method="POST">
    @csrf
    @method('PUT')
</form>



<div class="row">
    <div class="col-md-10 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Assessed on:</label>
                        <input form="createConcernForm" name="assessed_at" class="form-control" type="date"
                            value="{{ old('assessed_at')?old('assessed_at'):$concern->assessed_at }}" required>
                        @error('assessed_at')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Assessed by:</label>
                        <select form="createConcernForm" class="form-control" name="assessed_by_id">
                            <option value="{{ old('assessed_by_id')?old('assessed_by_id'):$concern->assessed_by_id }}"
                                selected>{{ old('assessed_by_id')?old('assessed_by_id'):$concern->assessed_by_id }}
                            </option>
                            @foreach ($personnels as $item)
                            <option value="{{ $item->personnel_id }}">{{ $item->personnel_name }} |
                                {{ $item->personnel_availability }}</option>
                            @endforeach
                        </select>
                        @if(!$personnels->count())
                        <small class="text-danger">
                           No available personnels. Please click <a target="_blank" href="/property/{{ Session::get('property_id') }}/personnels">here</a> to add one and refresh this page.
                        </small>
                        @endif
                        @error('assessed_by_id')
                        <br>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Category:</label>
                        <select form="createConcernForm" name="category" class="form-control" required>
                            <option value="{{ old('category')?old('category'):$concern->category }}" selected>
                                {{ old('category')?old('category'):$concern->category }}
                            </option>
                            <option value="unit_work"> Unit work</option>
                            <option value="hrr_violations"> HRR violations</option>
                            <option value="contract"> Contract</option>
                            <option value="remmittance">Remittance</option>
                            <option value="billing">Billing</option>

                        </select>
                        @error('category')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Urgency:</label>
                        <select form="createConcernForm" name="urgency" class="form-control" required>
                            <option value="{{ old('urgency')?old('urgency'):$concern->urgency }}" selected>
                                {{ old('urgency')?old('urgency'):$concern->urgency }}
                            </option>
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

                    <div class="form-group col-md-4">
                        <label for="">Warranty:</label>
                        <select form="createConcernForm" name="is_warranty" id="is_warranty" class="form-control"
                            required>
                            <option value="{{ old('is_warranty')?old('is_warranty'):$concern->is_warranty }}" selected>
                                {{ old('is_warranty')?old('is_warranty'):$concern->is_warranty }}</option>
                            <option value="yes"> Yes</option>
                            <option value="no"> No</option>

                        </select>
                        @error('is_warranty')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>


                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Assessment:</label>
                        <textarea form="createConcernForm" name="assessment" cols="115%" rows="5"
                            class="form-control">{{ old('assessment')?old('assessment'):$concern->assessment }}</textarea>
                        @error('assessment')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>


                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 mx-auto">
                        <button type="submit" form="createConcernForm" class="btn btn-primary btn-block"
                            onclick="this.form.submit(); this.disabled = true;"> Next</button>
                        <br>
                        <p class="text-center">
                            <a class="text-center text-dark"
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/#concenrs">Save
                                and continue later</a>
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