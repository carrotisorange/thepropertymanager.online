@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Scope of work</h6>
    </div>
</div>
<form id="createConcernForm"
    action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concer/{{ $concern->concern_id }}/store/scope_of_work"
    method="POST">
    @csrf
    @method('PUT')
</form>



<div class="row">
    <div class="col-md-10 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                            <label for="">Start on:</label>
                            <input name="scheduled_at" form="createConcernForm" value="{{ old('scheduled_at')?old('scheduled_at'):$concern->scheduled_at }}" class="form-control"
                                type="date" required>
                            @error('scheduled_at')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">End on:</label>
                            <input name="ended_on" form="createConcernForm" value="{{ old('ended_on')?old('ended_on'):$concern->ended_on }}" class="form-control"
                                type="date" required>
                            @error('ended_on')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Endorsed to:</label>
                            <select form="createConcernForm" class="form-control" name="concern_user_id">
                                <option value="{{ old('concern_user_id')?old('concern_user_id'):$concern->concern_user_id }}">
                                    {{ old('concern_user_id')?old('concern_user_id'):$concern->concern_user_id }}</option>
                                @foreach($users as $item)
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
                        <label for="">Scope of work:</label>
                        <textarea form="createConcernForm" name="scope_of_work" cols="115%" rows="5"
                            class="form-control">{{ old('scope_of_work')?old('scope_of_work'):$concern->scope_of_work }}</textarea>
                        @error('scope_of_work')
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
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/assessment">Back</a>
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