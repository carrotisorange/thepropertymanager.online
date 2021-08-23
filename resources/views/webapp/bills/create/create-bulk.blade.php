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
    <a href="/property/{{Session::get('property_id')}}/bills" class="btn btn-primary"><i class="fas fa-arrow-left"></i>
      Back </a>
    <a href="#" data-toggle="modal" data-target="#editPeriodCovered" class="btn btn-primary"><i class="fas fa-edit"></i>
      Options</a>

    <button type="submit" form="add_billings" class="btn btn-primary"
      onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i
        class="fas fa-check"></i> Save</button>

  </div>
</div>
{{-- body of the page --}}
<div row style="overflow-y:scroll;overflow-x:scroll;height:500px;">
  <table class="table table-responsinve">
    <thead>
      <th>#</th>
      <th>Tenant</th>
      <th>Room</th>
      <th>Amount</th>
      <th></th>
    </thead>
    <tbody>
      <?php $ctr = 1; ?>
      @foreach ($bills as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
        <td>{{ $item->first_name.' '.$item->last_name }}</td>
        <td>{{ $item->building.' '.$item->unit_no }}</td>
        <td>{{ $item->amount }}</td>
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