@extends('layouts.argon.main')

@section('title', 'Billing Information Sheet')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Billing Information Sheet</h6>
    </div>
</div>

  <div class="row">
    <div class="col-md-11 py-3 mx-auto">
      <div class="card">
        <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-4">
          <label for="">Room:</label>
          <input form="createBillForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control" type="text" required readonly>
         
        </div>
        <div class="form-group col-md-4">
          <label for="">Beds:</label>
          <input form="createBillForm" value="{{ $room->occupancy }} pax" class="form-control" type="text" required readonly>
        </div>
        <div class="form-group col-md-4">
          <label for="">Rent/mo:</label>
          <input form="createBillForm" value="{{ $contract->rent }}" class="form-control" type="number" required readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="">Tenant:</label>
          <input form="createBillForm" value="{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}" class="form-control" type="text" required readonly>
        
        
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Move in:</label>
          <input name="movein_at" id="movein_at" form="createBillForm" value="{{ Carbon\Carbon::parse($contract->movein_at)->format('M d, Y') }}" class="form-control" type="text" required readonly>
         
        </div>
        <div class="form-group col-md-3">
          <label for="">Move out:</label>
          <input name="moveout_at" id="moveout_at" form="createBillForm" value="{{ Carbon\Carbon::parse($contract->moveout_at)->format('M d, Y') }}" class="form-control" type="text" required readonly>
         
        </div>
        <div class="form-group col-md-3">
          <label for="">Lenght of stay:</label>
          <input name="number_of_months" id="number_of_months" form="createBillForm" value="{{ $contract->number_of_months }}" class="form-control" type="text" required readonly>
          
        <span class="text-danger" role="alert">
          <strong id="invalid-date"></strong>
        </span>
        </div>
        <div class="form-group col-md-3">
          <label for="">Term:</label>
          <input name="term" id="term" form="createBillForm" value="{{ $contract->term }}" class="form-control" type="text" required readonly>
         
        </div>
      </div>
      <h3>Bills</h3>
      <div class="form-row">
          <table class="table">
              <?php $ctr = 1; ?>
              <thead>
                  <th>#</th>
                  <th>Bill no</th>
                  <th>Particular</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Amount</th>
                  <th>Action</th>
              </thead>
              @foreach ($bills as $item)
              <tbody>
              <tr>
                <td>{{ $ctr++ }}</td>
                <td>{{ $item->bill_no }}</td>
                <td>{{ $item->particular }}</td>
                <td>{{ Carbon\Carbon::parse($item->start)->format('M d, Y') }}</td>
                <td>{{ Carbon\Carbon::parse($item->end)->format('M d, Y') }}</td>
                <td>{{ number_format($item->amount , 2) }}</td>
                <td><a class="text-danger" href="/bill/{{ $item->bill_id }}/delete/bill"><i class="fas fa-times"></i> Remove</a></td>
              </tr>
              </tbody>
              
              @endforeach
              <tr>
             <th>Total</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <th>{{ number_format($bills->sum('amount'),2) }}</th>
             <td></td>
             </tr>

          </table>

      </div>
      <form id="createBillForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/store/bill" method="POST">
        @csrf
    </form>
      <h3>Additional bills</h3>
      <div class="form-row">
        <table class="table table-responsive" >
            <tr>
                
                <td>
                    <select class="form-control" form="createBillForm" name="particular_id_foreign" id="">
                        <option value="{{ old('particular_id_foreign') }}" selected>{{ old('particular_id_foreign') }}</option>
                        @foreach ($particulars as $particular)
                        <option value="{{ $particular->particular_id }}">{{ $particular->particular }}</option>
                        @endforeach
                    </select>
                    @error('particular_id_foreign')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                  @enderror
                </td>
                <td>
                    <input form="createBillForm" type="date" value="{{ old('start') }}" name="start" id="start" class="form-control">
                    @error('start')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                    @enderror
                </td>
                <td>
                    <input form="createBillForm" type="date" value="{{ old('end') }}" name="end" id="end" class="form-control">
                    @error('end')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                  @enderror
                </td>
                <td>
                    <input form="createBillForm" type="number" min="1" value="{{ old('amount') }}" step="0.001" name="amount" id="amount" class="form-control">
                    @error('amount')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                  @enderror
                </td>
                <td> <button form="createBillForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Add</button></td>
                </tr>   
          </table>
      </div>
      
      </div>
      {{-- <div class="form-group">
       <div class="col text-center">
        <a href="#/" id="add_bill" ><i class="fas fa-plus"></i> Add</a>
       </div>
       
    </div> --}}
    
    <br>
      <div class="form-group"  >
        <a class="btn btn-primary btn-block" href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}"> Complete</a>
       {{-- <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}">Cancel</a>
        </p>  --}}
    </div>
    </div>
  </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
     //adding moveout charges upon moveout
     $(document).ready(function(){
        var i=1;
    $("#add_bill").click(function(){
        $('#addr'+i).html("<th>"+ i +"</th><td><select class='form-control' name='particular"+i+"' form='createBillForm' id='particular"+i+"'><option>Please select one</option>@foreach($particulars as $particular)<option value='{{ $particular->particular_id }}'>{{ $particular->particular }}</option>@endforeach</select> <td><input class='form-control' form='createBillForm' name='start"+i+"' id='start"+i+"' type='date' required></td> <td><input class='form-control' form='createBillForm' name='end"+i+"' id='end"+i+"' type='date' required></td> <td><input class='form-control' form='createBillForm' name='amount"+i+"' id='amount"+i+"' type='number' min='1' step='0.01' value='' required></td>");


     $('#table_bills').append('<tr id="addr'+(i+1)+'"></tr>');
     i++;
     document.getElementById('no_of_bills').value = i;

    });

    $("#delete_row").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        document.getElementById('no_of_bills').value = i;
        }
    });

});
</script>
@endsection





