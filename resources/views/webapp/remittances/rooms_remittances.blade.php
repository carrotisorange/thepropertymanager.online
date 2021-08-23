@extends('layouts.argon.main')

@section('title', 'Rooms Remittances')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-9">
    <h6 class="h2 text-dark d-inline-block mb-0">Rooms Remittances</h6>

  </div>
  <div class="col-md-3 text-right">
    {{-- <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addRemittance" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a> --}}
  </div>

</div>

<div class="row">

  <!-- Content Column -->
  <div class="col-lg-12 mb-4">
    <div class="table">
      <form id="editUnitsForm" action="/property/{{Session::get('property_id')}}/rooms/update" method="POST">
        @csrf
        @method('PUT')
      </form>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Building</th>
            <th>Room</th>
            <th>Size</th>
            <th>Condo Dues <small>(/sqm)</small></th>
            <th>Condo Dues <small>(/month)</small></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
                      $ctr = 1;
                      $unit_id = 1;
                      $unit_no = 1;
                     
                      $building =1;
                      $condodues_sqm =1;
                      $condodues_mo =1;
                      $size = 1;
             
                  ?>
          @foreach ($units as $item)

          <tr>
            <th> {{ $ctr++ }}</th>
            <td>{{ $item->building }}</td>
            <td>
              {{ $item->unit_no }}
              <input form="editUnitsForm" type="hidden" name="unit_id{{ $unit_id++  }}" id=""
                value="{{ $item->unit_id }}">
            </td>
            <td>{{ $item->size }} <b>sqm</b></td>
            <td><input form="editUnitsForm" type="number" step="0.001" name="condodues_sqm{{ $condodues_sqm++  }}" id=""
                value="{{ $item->size }}"></td>
            <td><input form="editUnitsForm" type="number" step="0.001" name="condodues_mo{{ $condodues_mo++  }}" id=""
                value="{{ $item->size }}" readonly></td>

          </tr>

          @endforeach
        </tbody>

      </table>
    </div>
    <br>
    @if($units->count() <=0 ) @else <p class="text-right">
      <button type="submit" form="editUnitsForm" class="btn btn-primary"
        onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Update</button>
      </p>
      @endif

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