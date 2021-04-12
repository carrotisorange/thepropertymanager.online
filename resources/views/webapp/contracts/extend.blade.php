@extends('layouts.argon.main')

@section('title', 'Extend')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/#contracts"">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/">Contract ID: {{ $contract->contract_id }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Extend</li>
      </ol>
    </nav>
    
    
  </div>
</div>
<div class="row">
    <form id="extendContractForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign}}/contract/{{$contract->contract_id}}/extend" method="POST">
        @csrf
      </form>
</div>
      <div class="row">
        <div class="col-md-12">
           <label>New movein date</label>
           <input class="form-control" type="date" form="extendContractForm" name="movein_at" value="{{ Carbon\Carbon::parse($contract->moveout_at)->format('Y-m-d') }}" required>
        </div>
    </div>
    <br>

    <div class="row">
      <div class="col-md-12">
          <label>Extend contract  <span class="text-danger"><small>(In months)</small></span> </label>
          <input type="number" form="extendContractForm" class="form-control" value="1" min="1" name="moveout_at" required >
      </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <label>Moveout charges <span class="text-danger"><small>(Optional)</small></span></label>
            </div>
            <div class="col-md-6">
                <p class="text-right">
                    <span id='delete_row' class="btn btn-danger btn-sm"><i class="fas fa-minus"></i> Remove current row</span>
                  <span id="add_row" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add more charges</span>     
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
                <input form="extendContractForm" type="hidden" id="no_of_charges" name="no_of_charges" >
            <tr id='addr1'></tr>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
      <div class="col-md-12">
       <p class="text-right">
        
        
        <button type="submit" form="extendContractForm" class="btn btn-success btn-user btn-block btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Extend</button>
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
          $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='extendContractForm' name='particular"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='extendContractForm'    oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='extendContractForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='extendContractForm' name='amount"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
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



