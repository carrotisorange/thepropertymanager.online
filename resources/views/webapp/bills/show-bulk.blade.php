@extends('layouts.argon.main')

@section('title', $particular->particular)

@section('css')
<style>
  /*This will work on every browser*/
  thead tr:nth-child(1) th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 10;
  }
</style>
@endsection

{{-- content of the page --}}
@section('upper-content')
{{-- header of the page --}}
<div class="row align-items-center py-4">
  <div class="col text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Creating <b>{{ $bills->count().' '.$particular->particular }}</b> bills
    </h6>
  </div>

  <div class="col text-right">
    <a href="/property/{{Session::get('property_id')}}/bills" class="btn btn-primary"><i class="fas fa-arrow-left"></i>
      Back </a>
    <a href="/property/{{ Session::get('property_id') }}/create/bill/{{ $particular->particular_id }}/batch/{{ $batch_no }}/options"
      class="btn btn-primary"><i class="fas fa-edit"></i> Options</a>

    <button type="submit" form="createBulkBillsForm" class="btn btn-primary"
      onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Save</button>

  </div>
</div>
{{-- body of the page --}}
<div row style="overflow-y:scroll;overflow-x:scroll;height:500px;">
  <table class="table table-responsinve">
    <thead>
      <th>#</th>
      <th>Room</th>
      <th>Tenant</th>
      <th>Start</th>
      <th>End</th>
      @if($particular->particular_id == '3')
      <th>Electricity Rate (/KwH)</th>
      <th>Prev reading</th>
      <th>Curr reading</th>
      <th>Consumption</th>
      @endif

      @if($particular->particular_id == '2')
      <th>Water Rate (/CuM)</th>
      <th>Prev reading</th>
      <th>Curr reading</th>
      <th>Consumption</th>
      @endif

      <th>Amount</th>
      <th></th>
    </thead>
    <tbody>
      <?php
        $ctr = 1;
        $start_ctr = 1;
        $end_ctr = 1;
        $amount_ctr = 1;
        $bill_id_ctr =1;
        $room_id_ctr =1;
        $id_amt = 1;

        // previus electric reading
        $elecricity_previous_reading = 1;
        $elecricity_previous_reading_id = 1;
        $elecricity_previous_reading_ctr = 1;
        //current electric reading
        $elecricity_current_reading = 1;
        $elecricity_current_reading_id = 1;
        $elecricity_current_reading_ctr = 1;
        //actual elecric consumption
        $elecricity_consumption = 1;
        $elecricity_consumption_id = 1;

        // previus electric reading
        $water_previous_reading = 1;
        $water_previous_reading_id = 1;
        $water_previous_reading_ctr = 1;
        //current electric reading
        $water_current_reading = 1;
        $water_current_reading_id = 1;
        $water_current_reading_ctr = 1;
        //actual elecric consumption
        $water_consumption = 1;
        $water_consumption_id = 1;
    ?>
      <form id="createBulkBillsForm"
        action="/property/{{ Session::get('property_id') }}/create/bill/{{ $particular->particular_id }}/batch/{{ $batch_no}}/store"
        method="POST">
        @csrf
        @method('put')
      </form>
      @foreach ($bills as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
        <input form="createBulkBillsForm" type="hidden" name="bill_id{{ $bill_id_ctr++ }}" value="{{ $item->bill_id }}">
        <input form="createBulkBillsForm" type="hidden" name="room_id{{ $room_id_ctr++ }}" value="{{ $item->unit_id }}">
        <td>{{ $item->building.' '.$item->unit_no }}</td>
        <td>{{ $item->first_name.' '.$item->last_name }}</td>
        <td><input form="createBulkBillsForm" type="date" name="start{{ $start_ctr++ }}" value="{{ $item->start }}">
        </td>
        <td><input form="createBulkBillsForm" type="date" name="end{{ $end_ctr++ }}" value="{{ $item->end }}"></td>
        {{-- show when the particular is electricity --}}
        @if($particular->particular_id == '3')
        <th>
          @foreach($electricity_rate as $rate)
          <input form="createBulkBillsForm" class="col-md-12" type="number" value={{ $item->electricity_rate?
          $item->electricity_rate: $rate->rate }}
          step="0.001" class="col-md-12" id="electricity_rate" name="electricity_rate" readonly>
          @endforeach
        </th>

        <th><input form="createBulkBillsForm" class="col-md-12" type="number"
            name="elecricity_previous_reading{{ $elecricity_previous_reading++ }}" id="elecricity_previous_reading_id{{ $elecricity_previous_reading_id++ }}"
            value="{{ $item->prev_electricity_reading }}"
            oninput="autoComputeElectricityConsumption({{ $elecricity_previous_reading_ctr++ }})"></th>

        <th><input form="createBulkBillsForm" class="col-md-12" type="number"
            name="elecricity_current_reading{{ $elecricity_current_reading++ }}" id="elecricity_current_reading_id{{ $elecricity_current_reading_id++ }}"
            oninput="autoComputeElectricityConsumption({{ $elecricity_current_reading_ctr++ }})" value="0.00"></th>
            
        <th><input form="createBulkBillsForm" class="col-md-12" type="number" name="elecricity_consumption{{ $elecricity_consumption++ }}"
            id="elecricity_consumption_id{{ $elecricity_consumption_id++ }}" value="0" required readonly value="{{ $item->amount?$item->amount:'0.00' }}"></th>
        {{-- show when the particular is water --}}
        @elseif($particular->particular_id == '2')
        <th>
          @foreach($electricity_rate as $rate)
          <input form="createBulkBillsForm" class="col-md-12" type="number" value={{ $item->water_rate?
          $item->electricity_rate: $rate->rate }}
          step="0.001" class="col-md-12" id="water_rate" name="water_rate" readonly>
          @endforeach
        </th>

        <th><input form="createBulkBillsForm" class="col-md-12" type="number"
            name="water_previous_reading{{ $elecricity_previous_reading++ }}" id="water_previous_reading_id{{ $water_previous_reading_id++ }}"
            value="{{ $item->prev_water_reading?$item->prev_water_reading: '0.00' }}" oninput="autoComputeWaterConsumption({{ $water_previous_reading_ctr++ }})"></th>

        <th><input form="createBulkBillsForm" class="col-md-12" type="number"
            name="water_current_reading{{ $water_current_reading++ }}" id="water_current_reading_id{{ $water_current_reading_id++ }}"
            oninput="autoComputeWaterConsumption({{ $water_current_reading_ctr++ }})" value="0.00"></th>

        <th><input form="createBulkBillsForm" class="col-md-12" type="number" name="water_consumption{{ $water_consumption++ }}"
            id="water_consumption_id{{ $water_consumption_id++ }}" required readonly value="0.00"></th>
        
        @endif
        <td>
  
          @if ($particular->particular_id == '1')
          <input form="createBulkBillsForm" type="number" class="col-md-12" name="rent{{ $amount_ctr++ }}"
            step="0.001" value="{{ $item->amount? $item->amount: $item->rent }}">
          @elseif ($particular->particular_id == '2' || $particular->particular_id == '3')
          <input form="createBulkBillsForm" type="number" name="amount{{ $amount_ctr++ }}" step="0.001"
            id="id_amt{{ $id_amt++ }}" value="{{ $item->amount?$item->amount:'0.00' }}">
          @else
          <input form="createBulkBillsForm" type="number" step="0.001" name="amount{{ $amount_ctr++ }}"
          id="id_amt{{ $id_amt++ }}" value="{{ $item->amount?$item->amount:'0.00' }}">
          @endif
        </td>
        <td><a class="text-danger" href="/bill/{{ $item->bill_id }}/delete/bill"><i class="fas fa-times"></i> Remove</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

{{-- scripts --}}
@section('scripts')
<script>
  function autoComputeElectricityConsumption(val) {
    var elecricity_previous_reading = 'elecricity_previous_reading_id'+val;
    var elecricity_current_reading = 'elecricity_current_reading_id'+val;
    var elecricity_consumption = 'elecricity_consumption_id'+val;
    var amt = 'id_amt'+val;

    var rate = parseFloat(document.getElementById('electricity_rate').value);
 
    var actual_consumption = document.getElementById(elecricity_current_reading).value - document.getElementById(elecricity_previous_reading).value;
    
    document.getElementById(elecricity_consumption).value = parseFloat(actual_consumption,2);
    document.getElementById(amt).value = parseFloat(actual_consumption) * rate;
   
  }

  function autoComputeWaterConsumption(val) {
  var water_previous_reading = 'water_previous_reading_id'+val;
  var water_current_reading = 'water_current_reading_id'+val;
  var water_consumption = 'water_consumption_id'+val;
  var amt = 'id_amt'+val;
  
  var rate = parseFloat(document.getElementById('water_rate').value);
  
  var actual_consumption = document.getElementById(water_current_reading).value - document.getElementById(water_previous_reading).value;
  
  document.getElementById(water_consumption).value = parseFloat(actual_consumption,2);
  document.getElementById(amt).value = parseFloat(actual_consumption) * rate;
  
  }
</script>
@endsection