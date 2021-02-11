@extends('layouts.argon.main')

@section('title', 'Water Bills')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-9 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">You're about to post water bills of tenants for {{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('M d, Y') }} - {{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('M d, Y') }}...</h6>
  </div>
  
  <div class="col-md-3 text-right">
    <a href="/property/{{Session::get('property_id')}}/bills"  class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back </a> 
    <a href="#" data-toggle="modal" data-target="#editPeriodCovered" class="btn btn-primary"><i class="fas fa-edit"></i> Options</a> 
  </div>
</div>

<div class="row">
  <div class="table-responsive text-nowrap">
  
    <form id="add_billings" action="/property/{{Session::get('property_id')}}/bills/create/" method="POST">
     @csrf
      </form>
      <table class="table">
      <thead>
        <tr>
          <th>#</th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <th>Occupant</th>
          @else
          <th>Tenant</th>
          @endif
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <th>Unit</th>
          @else
          <th>Room</th>
          @endif
          <th colspan="2">Period Covered</th>
    
         
         
          <th>Previous Reading</th>
          <th>Current Reading</th>
          <th>Current Consumption</th>
          <th>total water bill</th>
         
          
      </tr>
      </thead>
     <?php
      $ctr = 1;
      $unit_id = 1;
     $unit_id_ctr = 1;
       $bill_no_ctr = 1;
       $desc_ctr = 1;
       $contract_id = 1;
       $tenant_id = 1;
       $amt_ctr = 1;
       $id_ctr = 1;
       $details_ctr = 1;
       $start = 1;
       $end = 1;
       $previous_reading = 1;
       $current_reading = 1;
       $consumption = 1;
       $id_previous_reading = 1;
       $id_current_reading = 1;
       $id_consumption = 1;
       $ctr_previous_reading = 1;
       $ctr_current_reading = 1;
       $ctr_consumption = 1;
       $id_amt = 1;
     ?>
     @foreach($active_tenants as $item)
     
        
      <input type="hidden" form="add_billings" name="bill_tenant_id{{ $id_ctr++ }}" value="{{ $item->tenant_id }}">

      <input type="hidden" form="add_billings" name="bill_unit_id{{ $unit_id_ctr++ }}" value="{{ $item->unit_id }}" required>
    
      <input type="hidden" form="add_billings" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>

      <input type="hidden" form="add_billings" name="property_id" value="{{Session::get('property_id')}}" required>
    
      <tr>
        <td>{{ $ctr++ }}</td>
        <th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
        <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a>
        @else
        <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a>
        @endif
        </th>
        <th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
          @else
          <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{$item->building.' '.$item->unit_no }}</a>
          @endif
           
        </th>
        <td>
          <input class="form-control" form="add_billings" type="date" name="start{{ $start++  }}" value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
        </td>
      <td> 
          <input class="form-control" form="add_billings" type="date" name="end{{ $end++  }}" value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>
      </td>
      
      <input class="" type="hidden" form="add_billings" name="contract_id{{ $contract_id++ }}" value="{{ $item->contract_id }}" required readonly>

            <input class="" type="hidden" form="add_billings" name="particular{{ $desc_ctr++ }}" value="Water" readonly>
            
            <input class="" type="hidden" form="add_billings" name="tenant_id{{ $tenant_id++ }}" value="{{ $item->tenant_id }}" required readonly>
         
        <td>
          <input class="form-control" class="" type="number" form="add_billings" step="0.001" name="previous_reading{{ $previous_reading++ }}" id="id_previous_reading{{ $id_previous_reading++ }}" value={{ $item->initial_water}}>
        </td>
        <td>
          <input  class="form-control" class="" type="number" form="add_billings"step="0.001"  name="current_reading{{ $current_reading++ }}" id="id_current_reading{{ $id_current_reading++ }}" oninput="autoCompute({{ $ctr_current_reading++ }})">
        </td>
        <td>
          <input class="form-control" class="" type="number" form="add_billings" step="0.001" name="consumption{{ $consumption++ }}" id="id_consumption{{ $id_consumption++ }}"  value="0" required readonly>
        </td>
          <td>
              <input class="form-control" form="add_billings" type="number" step="0.001" name="amount{{ $amt_ctr++ }}" id="id_amt{{ $id_amt++ }}" value="0" required readonly>
          </td>
         
     </tr>
     @endforeach
    </table>
    </div>
</div>

<br>
<p class="text-right">

  <button type="submit" form="add_billings" id="addBillsButton" class="btn btn-primary"  onclick="return confirm('Are you sure you want to perform this action?');"> Post bills</button>
</p>
<div class="modal fade" id="editPeriodCovered" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="modal">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Options</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
    <form id="periodCoveredForm" action="/property/{{Session::get('property_id')}}/bills/water/{{ $updated_start? Carbon\Carbon::parse($updated_start)->format('Y-m-d'): null }}-{{ Carbon\Carbon::parse($updated_end)->format('Y-m-d') }}/" method="POST">
      @csrf
    <div class="row">
      <div class="col">
      <label for="">Start</label>
      <input class="form-control" form="periodCoveredForm" type="date" name="start" value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
    </div>
    </div>
    <br>
    <div class="row">
      <div class="col">
      <label for="">End</label>
      <input class="form-control" form="periodCoveredForm" type="date" name="end" value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>
    </div>
    </div>
<br>
    <div class="row">
      <div class="col">
      <label for="">Water rate (/cum)</label>
      <input class="form-control" form="periodCoveredForm" type="number" name="water_rate_cum" id="water_rate_cum" step="0.001" value="{{ $water_rate_cum? $water_rate_cum : Auth::user()->water_rate_cum }}" required oninput="autoCompute()">
    </div>
    </div>
  

  </div>
  <div class="modal-footer">
   {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal"> Dismiss</button> --}}
   <button form="periodCoveredForm" type="submit" id="addBillsButton" class="btn btn-primary"> Update</button>
  </form>
  </div> 
  </div>
  </div>
  
  </div>

@endsection

@section('main-content')

@endsection

@section('scripts')
<script>
  function autoCompute(val) {
    var previous_reading = 'id_previous_reading'+val;
    var current_reading = 'id_current_reading'+val;
    var consumption = 'id_consumption'+val;
    var amt = 'id_amt'+val;

    var water_rate_cum = parseFloat(document.getElementById('water_rate_cum').value);

    var actual_consumption = document.getElementById(current_reading).value - document.getElementById(previous_reading).value;
    
    document.getElementById(consumption).value = parseFloat(actual_consumption,2);
    document.getElementById(amt).value = parseFloat(actual_consumption) * water_rate_cum;
   
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



