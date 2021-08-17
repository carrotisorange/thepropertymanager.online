@extends('layouts.argon.main')

@section('title', 'Create owner')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Create owner</h6>
    </div>
</div>
<form id="createOwnerForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/store/owner" method="POST">
    @csrf
  </form>

  <div class="row">
    <div class="col-md-10 py-3 mx-auto">
      <div class="card">
        <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-4">
          <label for="">Room:</label>
          <input form="createOwnerForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control" type="text" required readonly>
        </div>
        <div class="form-group col-md-4">
          <label for="">Beds:</label>
          <input form="createOwnerForm" value="{{ $room->occupancy }} pax" class="form-control" type="text" required readonly>
        </div>
        <div class="form-group col-md-4">
          <label for="">Rent/mo:</label>
          <input form="createOwnerForm" value="{{ $room->rent }}" class="form-control" type="number" required readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="">Full name:</label>
          <input name="name" form="createOwnerForm" value="{{ old('name') }}" class="form-control" type="text" required>
          @error('name')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
       
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="">Contact no:</label>
          <input name="mobile" form="createOwnerForm" value="{{ old('mobile') }}" class="form-control" type="number" required>
          @error('mobile')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-6">
          <label for="">Email:</label>
          <input name="email" form="createOwnerForm" value="{{ old('email') }}" class="form-control" type="email" required>
          @error('email')
          <small class="text-danger">
            {{ $message }}
          </small>
        @enderror
        </div>
       
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="">Occupation:</label>
          <input name="occupation" form="createOwnerForm" value="{{ old('occupation') }}" class="form-control" type="text" required>
          @error('occupation')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
     
        <div class="form-group col-md-6">
          <label for="">Address:</label>
          <input name="address" form="createOwnerForm" value="{{ old('address') }}" class="form-control" type="text" required>
          @error('address')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
     
      
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="">Bank:</label>
          <input name="bank_name" form="createOwnerForm" value="{{ old('bank_name') }}" class="form-control" type="text" required>
          @error('bank_name')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="">Account name:</label>
            <input name="account_name" form="createOwnerForm" value="{{ old('account_name') }}" class="form-control" type="text" required>
            @error('account_name')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="">Account number:</label>
            <input name="account_number" form="createOwnerForm" value="{{ old('account_number') }}" class="form-control" type="text" required>
            @error('account_number')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="">Authorized representative:</label>
          <input name="representative" form="createOwnerForm" value="{{ old('representative') }}" class="form-control" type="text" required>
          @error('representative')
          <small class="text-danger">
            {{ $message }}
          </small>
        @enderror
        </div>
     
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="">Select type of payment</label>
          <select form="createOwnerForm" class="form-control" name="payment_type" id="" required>
           <option value="{{ old('payment_type')? old('payment_type'):"" }}selected>{{ old('payment_type')? old('payment_type'):"Please select one"}}</option>
           <option value="spot_tsp">Spot TSP</option>
           <option value="spot_dp">Spot DP</option>
           <option value="installment_dp">Installment DP</option>
           <option value="inhouse_tsp">Inhouse TSP</option>
        </select>
        @error('payment_type')
        <small class="text-danger">
            {{ $message }}
        </small>
          @enderror
        </div>

        <div class="form-group col-md-6">
          <label >Purchased amount</label>
          <input form="createOwnerForm" class="form-control" type="number" min="0" step="0.001" name="price" value="{{ old('price') }}" required >
          @error('price')
          <small class="text-danger">
              {{ $message }}
          </small>
      @enderror
      </div>
      </div>

      <div class="form-group col-md-11 mx-auto">
        <button type="submit" form="createOwnerForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Submit</button>
        <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/#owners">Cancel</a>
        </p>
    </div>
    </div>
  </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection



