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
    <h6 class="h2 text-dark d-inline-block mb-0">Creating {{ $particular->particular }} bills</h6>
  </div>
  
  <div class="col text-right">
    <a href="/property/{{Session::get('property_id')}}/bills"  class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back </a> 
    <a href="#" data-toggle="modal" data-target="#editPeriodCovered" class="btn btn-primary"><i class="fas fa-edit"></i> Options</a> 
   
    <button type="submit" form="add_billings" class="btn btn-primary"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Save</button>
    
  </div>
</div>
{{-- body of the page --}}
<div row style="overflow-y:scroll;overflow-x:scroll;height:500px;">

  <form id="add_billings" action="/property/{{Session::get('property_id')}}/bill/{{ $particular->particular_id }}/store" method="POST">
      @csrf
  </form>
    
  <table class="table table-hover">
   <thead>
     <?php $ctr = 1;?>
    <tr>
      {{-- bill # --}}
      <th>#</th>
      @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
      <th>Occupant</th>
      @else
      <th>Tenant</th>
      @endif

      {{-- unit/room no --}}
      @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
      <th>Unit</th>
      @else
      <th>Room</th>
      @endif
      @if($particular->particular_id != 2 || $particular->particular_id != 3)

      @else

      {{-- period covered  --}}
      <th>Period Covered</th>   
      @endif  

      {{-- # of days for rent bill  --}}
      @if($particular->particular_id == 1)
        <th>
          # of days
        </th> 
      @endif
    {{-- water rate for electric  --}}
      @if($particular->particular_id == 2)
        {{-- <th>
          Water rate/cum
        </th> --}}
        <th>
          Previous
        </th>
        <th>
          Current
        </th>
        <th>Actual</th>
      @endif

    {{-- electric rate for electric  --}}
    @if($particular->particular_id == 3)
      {{-- <th>
        Electric rate/kwh
      </th> --}}
      <th>
        Previous
      </th>
      <th>
        Current
      </th>
      <th>Actual</th>
    @endif

    <th>Amount </th>
  </tr>
   </thead>
   <?php
     $ctr = 1;
     $desc_ctr = 1;
     $tenant_id = 1;
     $contract_id = 1;
     $unit_id = 1;
     $unit_id_ctr = 1;
     $amt_ctr = 1;
     $id_amt = 1;

     $id_ctr = 1;
     $start = 1;
     $end = 1;
     $previous_reading = 1;
     $current_reading = 1;
     $id_previous_reading = 1;
     $id_current_reading = 1;
     $ctr_previous_reading = 1;
     $ctr_current_reading = 1;
     $ctr_consumption = 1;      
     $id_consumption = 1;
     $consumption = 1;
   ?>   
   
   @foreach($active_tenants as $item)
  
   {{-- <input type="hidden" form="add_billings" name="ctr" value="{{ $ctr++ }}" required>      --}}
  
   {{-- hidden fields --}}
    {{-- tenant id field --}}
    <input type="hidden" form="add_billings" name="bill_tenant_id{{ $id_ctr++ }}" value="{{ $item->tenant_id }}" required>
    {{-- unit id field --}}
    <input type="hidden" form="add_billings" name="bill_unit_id{{ $unit_id_ctr++ }}" value="{{ $item->unit_id }}" required>
    {{-- contract id field --}}
    <input type="hidden" form="add_billings" name="contract_id{{ $contract_id++ }}" value="{{ $item->contract_id }}" required>
    {{-- particular id field --}}
    <input type="hidden" form="add_billings" name="particular_id" value="{{ $particular->particular_id }}" required>
    {{-- tenant id field --}}
    <input class="" type="hidden" form="add_billings" name="tenant_id{{ $tenant_id++ }}" value="{{ $item->tenant_id }}" required readonly>
  
    <tr>
      {{-- bill no field --}}
      <th>{{ $ctr++ }}</th>
      {{-- tenant field --}}
      <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a></th>
      {{-- unit/room field --}}
      <th><a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a></th>
    
   @if($particular->particular_id != 2 || $particular->particular_id != 3)
   
    <input form="add_billings" type="hidden" name="start{{ $start++  }}" value="{{ $updated_start? $updated_start: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
    <input form="add_billings" type="hidden" name="end{{ $end++  }}" value="{{ $updated_end? $updated_end: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
  
   @else
   {{-- period covered field --}}
   @if(Carbon\Carbon::parse($item->movein_at)->format('MY') == Carbon\Carbon::now()->format('MY'))
   {{-- period covered for old tenant --}}
   <td>
     <input form="add_billings" type="date" name="start{{ $start++  }}" value="{{ $updated_start? $updated_start: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
     <input form="add_billings" type="date" name="end{{ $end++  }}" value="{{ $updated_end? $updated_end: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
   </td>
   {{-- period covered for new tenant --}}
   @else
   <td>
     <input form="add_billings" type="date" name="start{{ $start++  }}" value="{{ $updated_start? $updated_start: Carbon\Carbon::parse($item->movein_at)->format('Y-m-d') }}" required>
     <input form="add_billings" type="date" name="end{{ $end++  }}" value="{{ $updated_end? $updated_end: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
   </td>
   @endif
   @endif

      <?php 
        $prorated_rent =  Carbon\Carbon::parse($item->movein_at)->DiffInDays(Carbon\Carbon::now()->endOfMonth());
        $full_month = Carbon\Carbon::now()->month()->endOfMonth()->format('d');
        $prorated_monthly_rent =  ($item->contract_rent/$full_month) * $prorated_rent;
       ?>

    {{-- fields for rent bill only --}}
    @if($particular->particular_id == 1)
    <td>
      @if(Carbon\Carbon::parse($item->movein_at)->format('MY') == Carbon\Carbon::now()->format('MY'))
       {{-- # of dasys field for new tenant --}}
       {{ $prorated_rent }} days (prorated)
       
      @else
        {{-- # of days field for old tenant --}}
        {{ $full_month }} days
      @endif
    </td>
    <td>
      @if(Carbon\Carbon::parse($item->movein_at)->format('MY') == Carbon\Carbon::now()->format('MY'))
       {{-- amount field for new tenant --}}
       ₱ <input form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.001"  min="0" value="{{ $prorated_monthly_rent }}"  required>
      @else
      {{-- amount field for old tenant --}}
      ₱ <input form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.001"  min="0" value="{{ $item->contract_rent }}" required>
      @endif
    </td>
    @endif

    {{-- fields for water bill only --}}
    @if($particular->particular_id == 2)
      {{-- water rate field --}}
      <input form="add_billings" type="hidden" name="rate" step="0.01"  id="rate" min="0" value="{{ $property_bill->rate }}" required readonly>
      {{-- previous water consumption --}}
      <th> <input class="" type="number" form="add_billings" step="0.001" min="0" name="previous_reading{{ $previous_reading++ }}" id="id_previous_reading{{ $id_previous_reading++ }}" value={{ $item->initial_water }}></th>
      {{-- current water consumption --}}
      <th> <input class="" type="number" form="add_billings"step="0.001"  min="0" name="current_reading{{ $current_reading++ }}" id="id_current_reading{{ $id_current_reading++ }}" oninput="autoCompute({{ $ctr_current_reading++ }})" ></th>
       {{-- actual water consumption --}}
      <th> <input class="" type="number" form="add_billings" step="0.001" min="0"  name="consumption{{ $consumption++ }}" id="id_consumption{{ $id_consumption++ }}"  value="0.00" required readonly></th>
      {{-- amount field --}}
      <th>₱ <input form="add_billings" type="number" step="0.001" min="0"name="amount{{ $amt_ctr++ }}" id="id_amt{{ $id_amt++ }}" oninput="this.value = Math.abs(this.value)" value="0.00" required readonly></th>
    @endif

    {{-- electric rate for electric  --}}
    @if($particular->particular_id == 3)
      {{-- electric rate field --}}
     <input form="add_billings" type="hidden" name="rate" step="0.01"  id="rate" value="{{ $property_bill->rate }}" oninput="this.value = Math.abs(this.value)" required>
      {{-- previous electric consumption --}}
      <th>  <input class="" type="number" form="add_billings" step="0.001" name="previous_reading{{ $previous_reading++ }}" id="id_previous_reading{{ $id_previous_reading++ }}" value={{ $item->initial_electric }}></th>
      {{-- current electric consumption --}}
      <th>  <input class="" type="number" form="add_billings"step="0.001"  name="current_reading{{ $current_reading++ }}" id="id_current_reading{{ $id_current_reading++ }}" oninput="autoCompute({{ $ctr_current_reading++ }})" ></th>
         {{-- electric water consumption --}}
    <th> <input class="" type="number" form="add_billings" step="0.001" name="consumption{{ $consumption++ }}" id="id_consumption{{ $id_consumption++ }}"  value="0.00" required readonly></th>
      {{-- amount field --}}
      <th>₱ <input form="add_billings" type="number" step="0.001" name="amount{{ $amt_ctr++ }}" id="id_amt{{ $id_amt++ }}" oninput="this.value = Math.abs(this.value)" value="0.00" required readonly></th>
    @endif
       
    @if($particular->particular_id != 1 && $particular->particular_id != 2 && $particular->particular_id != 3)
    <th>₱ <input form="add_billings" type="number" step="0.001" name="amount{{ $amt_ctr++ }}" id="id_amt{{ $id_amt++ }}" oninput="this.value = Math.abs(this.value)" value="0.00" required></th>
    @endif
   </tr>
   @endforeach
  </table>
  </div>
  <br>

  {{-- option modal --}}
  <div class="modal fade" id="editPeriodCovered" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="modal">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Options</h5>
    
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
     <div class="modal-body">
      <form id="periodCoveredForm" action="/property/{{Session::get('property_id')}}/bill/{{ $particular->particular_id }}/update" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" form="periodCoveredForm" value="true" name="options">
        <input type="hidden" form="periodCoveredForm" value="{{ $property_bill->property_bill_id }}" name="particular_id">
      <div class="row">
        <div class="col">
        <label for="">Start of the billing period</label>
        <input class="form-control" form="periodCoveredForm" type="date" name="start" value="{{ $updated_start? $updated_start: Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
      </div>
      </div>
      <br>
      <div class="row">
        <div class="col">
        <label for="">End of the billing period</label>
        <input class="form-control" form="periodCoveredForm" type="date" name="end" value="{{ $updated_end? $updated_end: Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" required>
      </div>
      </div>
      <br>
      {{-- Water --}}
      @if($particular->particular_id == 2)
      <div class="row">
        <div class="col">
        <label for="">Rate/CuM</label>
        <input class="form-control" form="periodCoveredForm" type="number" name="water_rate" step="0.001" min="0" value="{{ $property_bill->rate }}" required>
      </div>
      </div>
      {{-- Electric --}}
      @elseif($particular->particular_id == 3)
      <label for="">Rate/KW</label>
      <input class="form-control" form="periodCoveredForm" type="number" name="electric_rate" step="0.001" min="0" value="{{ $property_bill->rate }}" required>
      @endif


    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Dismiss</button>
     <button form="periodCoveredForm"  type="submit" id="addBillsButton" class="btn btn-primary"><i class="fas fa-check"></i> Update</button>
    </form>
    </div> 
    </div>
    </div>
    
    </div>

@endsection

{{-- scripts --}}
@section('scripts')
<script>
  function autoCompute(val) {
    var previous_reading = 'id_previous_reading'+val;
    var current_reading = 'id_current_reading'+val;
    var consumption = 'id_consumption'+val;
    var amt = 'id_amt'+val;

    var rate = parseFloat(document.getElementById('rate').value);
 
    var actual_consumption = document.getElementById(current_reading).value - document.getElementById(previous_reading).value;
    
    document.getElementById(consumption).value = parseFloat(actual_consumption,2);
    document.getElementById(amt).value = parseFloat(actual_consumption) * rate;
   
  }
</script> 

<script type="text/javascript">
  $(window).on('load',function(){
    $("#editPeriodCovered").modal({
            backdrop: 'static',
            keyboard: false
        });
  });
</script>
@endsection



