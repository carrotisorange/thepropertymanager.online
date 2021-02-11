@extends('layouts.argon.main')

@section('title', 'Remittance')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">You're about to add a remittance to the owner. </h6>
    <br>
    <small><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}">Return to {{ $tenant->first_name }}'s profile</a> </small>
  </div>

</div>
    <form id="addRemittanceForm" action="/property/{{ Session::get('property_id') }}/remittances/store" method="POST">
        @csrf
      </form>

      <div class="row">
        <div class="col-md-6">
          <h6 class="h2 text-dark d-inline-block mb-0">Remittance</h6>
          <br><br>
           <label>Room</label>
            <select class="form-control" form="addRemittanceForm" name="unit_id" required>
                <option value="">Please select one</option>
                    @foreach ($rooms as $item)
                    <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>   
                    @endforeach

            </select>
    
    <br>
  
      @foreach ($remittance_info as $item)
      <label>Period covered</label>
      <div class="row">
         
          <div class="col">
              
              <small for="">Start</small>
              <input form="addRemittanceForm" type="date" class="form-control" name="start" value="{{ Carbon\Carbon::parse($item->start)->format('Y-m-d') }}" required>
          </div>
          <div class="col">
              <small>End</small>
              <input form="addRemittanceForm" type="date" class="form-control" name="end" value="{{ Carbon\Carbon::parse($item->end)->format('Y-m-d') }}" required>
          </div>
      </div>    
      <br>
      <div class="row">
          <div class="col">
              <label>Particular</label>
              <select  form="addRemittanceForm" class="form-control" name="particular" id="" required>
                  {{-- <option value="">Please select one</option> --}}
                  <option value="Rent" selected>Rent</option>
              </select>
          </div>
      </div>
     
      
    <br>
    <div class="row">
        <div class="col">
          <label>Net profit</label> <small class="text-danger">(Amount to be remitted to the owner.)</small>
          <input form="addRemittanceForm" type="number" min="1" class="form-control" name="amt" step="0.001" value="{{ $item->amt_paid }}" required readonly>
        </div>
    </div>
    @endforeach
     </div>
     
     <div class="col-md-6">
      <h6 class="h2 text-dark d-inline-block mb-0">Expenses</h6>
      <span id='delete_bill' class="btn btn-sm btn-danger"> Remove</span>
      <span id="add_bill" class="btn btn-sm btn-primary"> Add</span>   
          <br><br>
            <div class="table-responsive text-nowrap">
                <table class = "table" id="table_bill">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Particular</th>
            
                      <th>Amount</th>
                      
                  </tr>
                   </thead>
                        <input form="addRemittanceForm" type="hidden" id="no_of_bills" name="no_of_bills" >
                    <tr id='bill1'></tr>
                </table>
              </div>
  
     </div>
   </div>
  <br>
  
<br>
  <div class="row">
      <div class="col-md-12">
       <p class="text-right">
        
        
        <button type="submit" form="addRemittanceForm" class="btn btn-primary btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Submit</button>
       </p>
      </div>
  </div>
 

@endsection

@section('main-content')

@endsection

@section('scripts')
<script type="text/javascript">
  //adding moveout charges upon moveout
    $(document).ready(function(){
    
    var k=1;
    var total = 0;
    $("#add_bill").click(function(){
      $('#bill'+k).html("<th>"+ (k) +"</th><td><select class='form-control' name='particular"+k+"' form='addRemittanceForm' id='particular"+k+"' required><option value='' selected>Please select one</option><option value='Condo Dues'>Condo Dues</option><option value='Electric'>Electric</option><option value='Environmental Fee'>Environmental Fee</option><option value='Management Fee'>Management Fee</option><option value='Purchase'>Purchase</option><option value='Water'>Water</option><option value='Others'>Others</option></select>  <td><input form='addRemittanceForm' class='form-control'  name='amount"+k+"' id='amount"+k+"' type='number' min='1' step='0.001' required></td>");
     $('#table_bill').append('<tr id="bill'+(k+1)+'"></tr>');
     k++;
    document.getElementById('no_of_bills').value = k;
 });
    $("#delete_bill").click(function(){
        if(k>1){
        $("#bill"+(k-1)).html('');
        k--;
        document.getElementById('no_of_bills').value = k;
        }
    });
});
</script>

@endsection



