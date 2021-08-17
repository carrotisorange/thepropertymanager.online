@extends('layouts.argon.main')

@section('title', 'Create certificates')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Create certificate</h6>
    </div>
</div>
<form id="createCertificateForm" action="{{ route('store-certificate', ['property_id'=> Session::get('property_id'), 'owner_id' => $owner->owner_id]) }}" method="POST">
    @csrf
  </form>


  <div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                  <div class="form-group">
                    <label >Purchased date</label>
                    <input form="createCertificateForm" class="form-control" type="date" name="date_purchased" value="{{ old('date_purchased')? old('date_purchased'):Carbon\Carbon::now()->format('Y-m-d') }}" required >
                    @error('date_purchased')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
                </div>

                <div class="form-group">
                    <label for="">Select a room</label>
                    <select form="createCertificateForm" class="form-control" name="unit_id_foreign" id="" required>
                     <option value="{{ old('unit_id_foreign')? old('unit_id_foreign'): "" }}">{{ old('unit_id_foreign')? old('unit_id_foreign'): "Please select one" }}</option>
                     @foreach ($all_rooms as $item)
                         <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>
                     @endforeach
                  </select>
                  @error('unit_id_foreign')
                  <small class="text-danger">
                      {{ $message }}
                  </small>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="">Select type of payment</label>
                    <select form="createCertificateForm" class="form-control" name="payment_type" id="" required>
                     <option value="{{ old('payment_type')? old('payment_type'):"" }}>{{ old('payment_type')? old('payment_type'):"Please select one" }}</option>
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

                  <div class="form-group">
                    <label >Purchased amount</label>
                    <input form="createCertificateForm" class="form-control" type="number" min="0" step="0.001" name="price" value="{{ old('price') }}" required >
                    @error('price')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
                </div>
                  
                    <div class="form-group">
                        <button type="submit" form="createCertificateForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Save</button>
                        <br>
                        <p class="text-center">
                            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/#certificates">Cancel</a>
                        </p>
                    </div>

                   

            </div>
        </div>
      </div>
  </div>

@endsection

@section('scripts')

@endsection



