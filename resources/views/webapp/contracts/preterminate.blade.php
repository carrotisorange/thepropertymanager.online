@extends('layouts.argon.main')

@section('title', 'Preterminate')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/#contracts">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/">Contract ID: {{ $contract->contract_id }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Terminate</li>
      </ol>
    </nav>
    
    
  </div>
</div>
<div class="row">
    <form id="preterminateContractForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign}}/contract/{{$contract->contract_id}}/preterminate_post" method="POST">
        @csrf
        @method('PUT')
      </form>
</div>
      <div class="row">
        <div class="col-md-12">
           <label>Reason for termination</label>
            <select class="form-control" form="preterminateContractForm" name="moveout_reason" id="moveout_reason" required>
              <option value="" selected>Please select one</option>
              <option value="End of contract">End of contract</option>
              <option value="Delinquent">Delinquent</option>
              <option value="Force majeure">Force majeure</option>
              <option value="Graduated">Graduated</option>
              <option value="Run away">Run away</option>
              <option value="Unruly">Unruly</option>
              <option value="Unsatisfied with the service">Unsatisfied with the service</option>
            </select>
        </div>
    </div>
    <br>

    <div class="row">
      <div class="col-md-12">
          <label>Actual moveout date</label>
          <input type="date" form="preterminateContractForm" class="form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="actual_moveout_at" required >
      </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <h6 class="h2 text-dark d-inline-block mb-0">Moveout charges <small class="text-danger">(Optional)</small></h6>
            </div>
            <div class="col-md-7">
                <p class="text-right">
                    <span id='delete_row' class="btn btn-danger btn-sm"><i class="fas fa-minus fa-sm text-white-50"></i> Remove the current row</span>
                  <span id="add_row" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add more charges </span>     
                  </p>
            </div>
        </div>
     
        <div class="table-responsive text-nowrap">
        <table class = "table" id="tab_logic">
          <thead>
            <tr>
              <th>#</th>
              <th>Item</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Amount</th>
              
          </tr>
          </thead>
                <input form="preterminateContractForm" type="hidden" id="no_of_charges" name="no_of_charges" >
            <tr id='addr1'></tr>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
      <div class="col-md-12">
       <p class="text-right">
        
        
        <button type="submit" form="preterminateContractForm" class="btn btn-primary btn-user btn-block btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Terminate</button>
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
          var i=1;
      $("#add_row").click(function(){
          $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='preterminateContractForm' name='particular"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='preterminateContractForm'    oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='preterminateContractForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='preterminateContractForm' name='amount"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
       $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
       i++;
       document.getElementById('no_of_charges').value = i;
      });
      $("#delete_row").click(function(){
          if(i>1){
          $("#addr"+(i-1)).html('');
          i--;
          document.getElementById('no_of_charges').value = i;
          }
      });
          var j=1;
      $("#add_charges").click(function(){
        $('#row'+j).html("<th>"+ (j) +"</th><td><select class='form-control' name='particular"+j+"' form='extendTenantForm' id='particular"+j+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='extendTenantForm' name='start"+j+"' id='start"+j+"' type='date' value='{{ $contract->moveout_at }}' required></td> <td><input class='form-control' form='extendTenantForm' name='end"+j+"' id='end"+j+"' type='date' required></td> <td><input class='form-control' form='extendTenantForm'   name='amount"+j+"' id='amount"+j+"' type='number' min='1' step='0.01' required></td>");
       $('#extend_table').append('<tr id="row'+(j+1)+'"></tr>');
       j++;
       
          document.getElementById('no_of_items').value = j;
   });
      $("#remove_charges").click(function(){
          if(j>1){
          $("#row"+(j-1)).html('');
          j--;
          
          document.getElementById('no_of_items').value = j;
          }
      });
      var k=1;
      $("#add_bill").click(function(){
        $('#bill'+k).html("<th>"+ (k) +"</th><td><select class='form-control' name='particular"+k+"' form='addBillForm' id='particular"+k+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='addBillForm' name='start"+k+"' id='start"+k+"' type='date' value='{{ $contract->movein_at }}' required></td> <td><input class='form-control' form='addBillForm' name='end"+k+"' id='end"+k+"' type='date' value='{{ $contract->actual_moveout_at }}' required></td> <td><input class='form-control' form='addBillForm' name='amount"+k+"' id='amount"+k+"' type='number' min='1' step='0.01' required></td>");
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
  
  <script>
    function autoCompute(val) {
      price = document.getElementById('price'+val).value;
      qty = document.getElementById('qty'+val).value;
      
      amt = document.getElementById('amt'+val).value =  parseFloat(price) *  parseFloat(qty);
     
    }
  </script>
@endsection



