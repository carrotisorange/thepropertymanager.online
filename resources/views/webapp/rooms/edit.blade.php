@extends('layouts.argon.main')

@section('title', 'Edit room')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Edit room</h6>
    </div>
</div>
<form id="updateRoomForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/update"
    method="POST">
    @csrf
    @method('PUT')
</form>


<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Room</label>
                    <input form="updateRoomForm" type="text" value="{{ $room->unit_no }}" class="form-control"
                        name="unit_no">
                    @error('unit_no')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" form="updateRoomForm" name="unit_type_id_foreign"
                        id="unit_type_id_foreign">

                        <option value="{{ $room->unit_type_id_foreign }}" selected>{{ $room->unit_type_id_foreign }}
                        </option>
                        @foreach ($room_types as $item)
                        <option value="{{ $item->unit_type_id }}">{{ $item->unit_type }}</option>
                        @endforeach
                    </select>

                    @error('unit_type_id_foreign')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" form="updateRoomForm" name="status" id="status">

                        <option value="{{ $room->status }}" selected>{{ $room->status }}</option>

                        <option value="active">active</option>
                        <option value="pending">pending</option>
                        <option value="occupied">occupied</option>

                    </select>

                    @error('status')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group residential">
                    <label>Building <small>(Optional)</small></label>
                    <input form="updateRoomForm" type="text" value="{{ $room->building }}" class="form-control"
                        name="building" placeholder="Building 2">

                </div>

                <div class="form-group residential">
                    <label>Size <small>(sqm)</small></label>
                    <input form="updateRoomForm" type="number" value="{{ $room->size }}" min="0.001" step="0.001"
                        class="form-control" name="size" placeholder="20" required>

                </div>

                <div class="form-group residential">
                    <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
                    <label>Floor</label>
                    <select class="form-control" form="updateRoomForm" name="unit_floor_id_foreign"
                        id="unit_floor_id_foreign" onchange="autoFillInitialName()" required>
                        <option value="{{ $room->unit_floor_id_foreign }}" selected>{{ $room->unit_floor_id_foreign }}
                        </option>
                        @foreach ($room_floors as $item)
                        @if($item->unit_floor>=0)
                        <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format($item->unit_floor) }}
                            floor</option>
                        @else
                        <option value="{{ $item->unit_floor_id }}">
                            {{ $numberFormatter->format(intval($item->unit_floor)*-1) }} basement</option>
                        @endif
                        @endforeach
                    </select>
                    @error('unit_floor_id_foreign')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>


                <div class="form-group residential">
                    <label>Occupancy</label>
                    <input form="updateRoomForm" type="number" min="1" value="{{ $room->occupancy }}"
                        class="form-control" name="occupancy">
                    @error('occupancy')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group residential">
                    <label>Monthly rent</label>
                    <input form="updateRoomForm" type="number" value="{{ $room->rent }}" step="0.01"
                        class="form-control" name="rent" id="rent">
                    @error('rent')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" form="updateRoomForm" class="btn btn-primary btn-block"
                        onclick="this.form.submit(); this.disabled = true;"> Update</button>
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