@extends('layouts.argon.main')

@section('title', 'Create Bill')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Create Bill</h6>
    </div>
</div>

  <div class="row">
    <div class="col-md-11 py-3 mx-auto">
      <div class="card">
        <div class="card-body">

            <form id="createBillForm" action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/store/bill" method="POST">
                @csrf
            </form>

      <div class="form-row">
        <table class="table table-borderless table-responsive" >
            <thead>
                <th>#</th>
                <th>Bill no</th>
                <th>Particular</th>
                <th>Start</th>
                <th>End</th>
                <th>Amount</th>
                <th>Action</th>
            </thead>
            <tr>
                
               <td></td>
               <td></td>
                <td>
                    <select class="form-control" form="createBillForm" name="particular_id_foreign" id="">
                        <option value="{{ old('particular_id_foreign')? old('particular_id_foreign'): ''}}" selected>{{ old('particular_id_foreign')? old('particular_id_foreign'): 'Please select one' }}</option>
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
                    <input class="form-control" form="createBillForm" type="date" value="{{ old('start') }}" name="start" id="start" class="">
                    @error('start')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                    @enderror
                </td>
                <td>
                    <input class="form-control" form="createBillForm" type="date" value="{{ old('end') }}" name="end" id="end" class="">
                    @error('end')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                  @enderror
                </td>
                <td>
                    <input class="form-control" form="createBillForm" type="number" min="1" value="{{ old('amount') }}" step="0.001" name="amount" id="amount" class="">
                    @error('amount')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                  @enderror
                </td>
                <td> <button form="createBillForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Save</button></td>
                </tr>   
          </table>
      </div>

      <div class="form-row">
          <table class="table">
              <?php $ctr = 1; ?>
           
              @foreach ($bills as $item)
              <tbody>
              <tr>
                <th>{{ $ctr++ }}</th>
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
  
      
      </div>
      {{-- <div class="form-group">
       <div class="col text-center">
        <a href="#/" id="add_bill" ><i class="fas fa-plus"></i> Add</a>
       </div>
       
    </div> --}}
    
    <br>
    <div class="form-group col-md-11 mx-auto">
        <a class="btn btn-primary btn-block" href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#bills"> Finish</a>
       <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#bills">Cancel</a>
        </p> 
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





