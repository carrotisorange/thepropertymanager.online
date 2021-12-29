@extends('layouts.argon.main')

@section('title', 'Create Bill')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 d-inline-block mb-0"><a
                href="/property/{{ Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/#bills">{{
                $tenant->first_name.' '.$tenant->last_name }}</a>/ Create Bill/ {{ $particular->particular }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <form id="createBillForm"
                    action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/particular/{{ $particular->particular_id }}/bill/{{ $bill->bill_id }}/store/bill"
                    method="POST">
                    @csrf
                </form>
                <div class="form-group ">
                    <label><b>Room</b></label>
                    <select class="form-control" form="createBillForm" name="bill_unit_id" id="" required>
                        <option value="{{ old('bill_unit_id')? old('bill_unit_id'): ''}}" selected>
                            {{ old('bill_unit_id')? old('bill_unit_id'): 'Please select one' }}</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->unit_id }}">{{ $room->building.' '.$room->unit_no }}</option>
                        @endforeach
                    </select>
                    @error('bill_unit_id')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                @if($particular->particular_id == '2' || $particular->particular_id == '3')
                <label for=""><b>More details</b></label>
                <div class="form-row residential">

                    <div class="col-md-4">
                        <label>Rate </label>
                        @foreach ($property_bill as $bill)
                        <input class="form-control" form="createBillForm" type="number" step="0.001" value="{{ $bill->rate }}"
                            name="rate" id="rate" class="" oninput="autoComputeAmount()">
                        @endforeach
                    </div>

                    <div class="col-md-4">
                        <label>Previous </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="previous"
                            id="previous" class="" oninput="autoComputeAmount()">
                    </div>

                    <div class="col-md-4">
                        <label>Current </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="current"
                            id="current" class="" oninput="autoComputeAmount()">
                    </div>
                </div>
                <br>
                <div class="form-row residential">

                    <div class="col-md-3">
                        <label>Consumption </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="consumption"
                            id="consumption" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Minimum </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="minimum"
                            id="minimum" class="" oninput="autoComputeAmount()">
                    </div>

                    <div class="col-md-3">
                        <label>Unpaid </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="unpaid"
                            id="unpaid" class="" oninput="autoComputeAmount()">
                    </div>

                    <div class="col-md-3">
                        <label>Surcharge </label>
                        <input class="form-control" form="createBillForm" type="number" value="" name="surcharge"
                            id="surcharge" class="" oninput="autoComputeAmount()">
                    </div>


                </div>
                <br>
                @endif

                <label for=""><b>Biling period</b></label>
                <div class="form-row residential">

                    <div class="col-md-6">
                        <label>Start </label>
                        <input class="form-control" form="createBillForm" type="date"
                            value="{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}" name="start" id="start"
                            class="" required>
                        @error('start')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>End </label>
                        <input class="form-control" form="createBillForm" type="date"
                            value="{{ Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d') }}" name="end" id="end"
                            class="" required>
                        @error('end')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>
                <br>
                <div class="form-group residential">
                    <label><b>Amount</b></label>
                    @if($particular->particular=='1')
                    <input class="form-control" form="createBillForm" type="number" min="1" value="{{ old('amount') }}"
                        step="0.001" name="amount" id="amount" class="" required>
                    @elseif($particular->particular_id == '2' || $particular->particular_id == '3')
                    <input class="form-control" form="createBillForm" type="number" min="1" value="{{ old('amount') }}"
                        step="0.001" name="amount" id="amount" class="" required>
                    @else
                    <input class="form-control" form="createBillForm" type="number" min="1" value="{{ old('amount') }}"
                        step="0.001" name="amount" id="amount" class="" required>
                    @endif

                    @error('amount')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" form="createBillForm" class="btn btn-primary btn-block"><i
                            class="fas fa-check"></i> Save</button>
                    <br>
                    <p class="text-center">
                        <a class="text-center text-dark" href="{{ url()->previous() }}"><i class="fas fa-times"></i>
                            Cancel</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    function autoComputeAmount(){
      var previous = parseFloat(document.getElementById('previous').value);
      var current = parseFloat(document.getElementById('current').value);
      var rate = parseFloat(document.getElementById('rate').value);

      var consumption = document.getElementById('consumption').value = (current - previous) * rate;

      var minimum = document.getElementById('minimum').value;

      var surcharge = document.getElementById('surcharge').value;

      var unpaid = document.getElementById('unpaid').value;

      document.getElementById('amount').value = (parseFloat(consumption) + parseFloat(minimum) + parseFloat(surcharge) + parseFloat(unpaid));

      
    }
</script>
@endsection