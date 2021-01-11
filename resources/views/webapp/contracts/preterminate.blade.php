@extends('layouts.argon.main')

@section('title', 'Preterminate')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{ $property->name }} 
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{$property->property_id }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/system-updates" target="_blank">
                <i class="fas fa-bug text-red"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>
             {{--  <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Plugins</span>
              </a>
            </li> --}}
            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">You're about to terminate {{ $tenant->first_name }}'s contract.</h6>
    
  </div>

</div>
<div class="row">
    <form id="preterminateContractForm" action="/property/{{ $property->property_id }}/tenant/{{ $contract->tenant_id_foreign}}/contract/{{$contract->contract_id}}/preterminate_post" method="POST">
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
            <div class="col-md-3">
                <h6 class="h2 text-dark d-inline-block mb-0">Moveout charges</h6>
            </div>
            <div class="col-md-9">
                <p class="text-right">
                    <span id='delete_row' class="btn btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove</span>
                  <span id="add_row" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add </span>     
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
        
        
        <button type="submit" form="preterminateContractForm" class="btn btn-danger btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Terminate</button>
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



