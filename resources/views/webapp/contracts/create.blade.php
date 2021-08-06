@extends('layouts.argon.main')

@section('title', 'Contract Information Sheet')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Contract Information Sheet</h6>
    </div>
</div>
<form id="createContractForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/store/contract" method="POST">
    @csrf
</form>

  <div class="row">
    <div class="col-md-10 py-3 mx-auto">
      <div class="card">
        <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-4">
          <label for="">Room:</label>
          <input form="createContractForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control" type="text" required readonly>
         
        </div>
        <div class="form-group col-md-4">
          <label for="">Beds:</label>
          <input form="createContractForm" value="{{ $room->occupancy }} pax" class="form-control" type="text" required readonly>
        </div>
        <div class="form-group col-md-4">
          <label for="">Rent/mo:</label>
          <input form="createContractForm" value="{{ $room->rent }}" class="form-control" type="number" required readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="">Tenant:</label>
          <input form="createContractForm" value="{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}" class="form-control" type="text" required readonly>
        
          @error('last_name')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Move in:</label>
          <input name="movein_at" id="movein_at" form="createContractForm" value="{{ old('movein_at') }}" onchange='autoFill()' class="form-control" type="date" required>
          @error('movein_at')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Move out:</label>
          <input name="moveout_at" id="moveout_at" form="createContractForm" value="{{ old("moveout_at") }}" onchange='autoFill()' class="form-control" type="date" required>
          @error('moveout_at')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Lenght of stay:</label>
          <input name="number_of_months" id="number_of_months" form="createContractForm" value="{{ old('number_of_months') }}" class="form-control" type="text" required readonly>
           @error('number_of_months')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        <span class="text-danger" role="alert">
          <strong id="invalid-date"></strong>
        </span>
        </div>
        <div class="form-group col-md-3">
          <label for="">Term:</label>
          <input name="term" id="term" form="createContractForm" value="{{ old('term') }}" class="form-control" type="text" required readonly>
           @error('term')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        </div>
      </div>
       <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Rent/mo:</label>
          <input name="rent" id="rent" form="createContractForm" value="{{ $room->rent - old('discount') }}" class="form-control" type="number" required>
          <input form="createContractForm" type="hidden" class="" name="original" min="1" id="original" value="{{ $room->rent }}" required>
           @error('rent')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Discount:</label>
          <input name="discount" id="discount" form="createContractForm" value="{{ old('discount') }}" class="form-control" type="number" required>
           @error('discount')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Referrer:</label>
          <select form="createContractForm" class="form-control" name="referrer_id_foreign">
            <option value="{{ old('referrer_id_foreign') }}">{{ old('referrer_id_foreign') }}</option>
            @foreach ($users as $item)
            <option value="{{ $item->id }}">{{ $item->name }} | {{ $item->role }}</option>
            @endforeach
          </select>
           @error('referrer_id_foreign')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Form of interaction:</label>
          <select form="createContractForm" class="form-control" name="form_of_interaction">
            <option value="{{ old('form_of_interaction') }}">{{ old('form_of_interaction') }}</option>
            <option value="Facebook">Facebook</option>
            <option value="Flyers">Flyers</option>
            <option value="In house">In house</option>
            <option value="Instagram">Instagram</option>
            <option value="Website">Website</option>
            <option value="Walk in">Walk in</option>
            <option value="Word of mouth">Word of mouth</option>
          </select>
           @error('form_of_interaction')
           <small class="text-danger">
             {{ $message }}
           </small>
         @enderror
        </div>
       </div>
      </div>
      <div class="form-group">
        <button type="submit" form="createContractForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Continue</button>
        <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}">Cancel</a>
        </p>
    </div>
    </div>
  </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  function autoFill(){
    var moveout_date = document.getElementById('moveout_at').value;
    var movein_date = document.getElementById('movein_at').value;
    var rent = document.getElementById('rent').value;
    
    date1 = new Date(movein_date);
    date2 = new Date(moveout_date);

    let diff = date2-date1; 

    let months = 1000 * 60 * 60 * 24 * 28;

    var dateInMonths = Math.floor(diff/months);

    document.getElementById('number_of_months').value = dateInMonths +' month/s';

    if(dateInMonths <=0 ){
      document.getElementById('invalid-date').innerText = 'Moveout should be greater(>) than movein.';
    }else{
      document.getElementById('invalid-date').innerText = ' ';
    }

    if(dateInMonths <5 ){
        document.getElementById('term').value = 'Short Term';
        document.getElementById('discount').value = 0;
        document.getElementById('rent').value = document.getElementById('original').value;
      }else{
        document.getElementById('term').value = 'Long Term';
        document.getElementById('discount').value = (document.getElementById('original').value * .1);
        document.getElementById('rent').value = document.getElementById('original').value - (document.getElementById('original').value * .1) ;
      }
  }
</script>
@endsection





