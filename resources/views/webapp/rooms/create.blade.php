@extends('layouts.argon.main')

@section('title', 'Create rooms')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Create room</h6>
  </div>
</div>
<form id="createRoomForm" action="{{ route('store-room') }}" method="POST">
  @csrf
</form>


<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label>Room type</label>
          <select class="form-control" form="createRoomForm" name="unit_type_id_foreign" id="unit_type_id_foreign"
            required>

            <option value="{{ old('unit_type_id_foreign') }}" selected>{{ old('unit_type_id_foreign') }}</option>
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

        <div class="form-group residential">
          <label>Number of rooms</label>
          <input form="createRoomForm" type="number" min="1" value="{{ old('no_of_rooms') }}" class="form-control"
            name="no_of_rooms" required>
          @error('no_of_rooms')
          <small class="text-danger">
            {{ $message }}
          </small>
          @enderror
        </div>

        <div class="form-group residential">
          <label>Building <small>(Optional)</small></label>
          <input form="createRoomForm" type="text" value="{{ old('building') }}" class="form-control" name="building"
            placeholder="Building 2">

        </div>

        <div class="form-group residential">
          <label>Size <small>(sqm)</small></label>
          <input form="createRoomForm" type="number" value="{{ old('size') }}" min="0.001" step="0.001"
            class="form-control" name="size" placeholder="20" required>

        </div>

        <div class="form-group residential">
          <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
          <label>Floor</label>
          <select class="form-control" form="createRoomForm" name="unit_floor_id_foreign" id="unit_floor_id_foreign"
            onchange="autoFillInitialName()" required>
            <option value="{{ old('unit_floor_id_foreign') }}" selected>{{ old('unit_floor_id_foreign') }}</option>
            @foreach ($room_floors as $item)
            @if($item->unit_floor>=0)
            <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format($item->unit_floor) }} floor</option>
            @else
            <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format(intval($item->unit_floor)*-1) }}
              basement</option>
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
          <label>Room name</label>
          <input form="createRoomForm" class="form-control" name="unit_no" value="{{ old('unit_no') }}" id="unit_no">
          @error('unit_no')
          <small class="text-danger">
            {{ $message }}
          </small>
          @enderror
        </div>


        @if(Session::get('property_type') !== 5)

        <div class="form-group residential">
          <label>Occupancy </label>
          <input form="createRoomForm" type="number" min="1" value="{{ old('occupancy') }}" class="form-control"
            name="occupancy">
          @error('occupancy')
          <small class="text-danger">
            {{ $message }}
          </small>
          @enderror
        </div>

        <div class="form-group residential">
          <label>Monthly rent</label>
          <input form="createRoomForm" type="number" value="{{ old('rent') }}" step="0.01" class="form-control"
            name="rent" id="rent">
          @error('rent')
          <small class="text-danger">
            {{ $message }}
          </small>
          @enderror
        </div>




        @endif
        <div class="form-group">
          <button type="submit" form="createRoomForm" class="btn btn-primary btn-block"
            onclick="this.form.submit(); this.disabled = true;"> Save</button>
          <br>
          <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/rooms">Cancel</a>
          </p>
        </div>


      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function autoFillInitialName(){
      $floor = document.getElementById('unit_floor_id_foreign').value;
      $unit_name = document.getElementById('unit_no');
      if($floor === '1'){
        $unit_name.value = 'GF';
      }
      if($floor === '2'){
        $unit_name.value = '2F';
      }
      if($floor === '3'){
        $unit_name.value = '3F';
      }
      if($floor === '4'){
        $unit_name.value = '4F';
      }
      if($floor === '5'){
        $unit_name.value = '5F';
      }
      if($floor === '6'){
        $unit_name.value = '6F';
      }
      if($floor === '7'){
        $unit_name.value = '7F';
      }
      if($floor === '8'){
        $unit_name.value = '8F';
      }
      if($floor === '9'){
        $unit_name.value = '9F';
      }

      if($floor === '-1'){
        $unit_name.value = '1B';
      }
      if($floor === '-2'){
        $unit_name.value = '2B';
      }
      if($floor === '-3'){
        $unit_name.value = '3B';
      }
      if($floor === '-4'){
        $unit_name.value = '4B';
      }
      if($floorfed === '-5'){
        $unit_name.value = '5B';
      }
    }
</script>
@endsection