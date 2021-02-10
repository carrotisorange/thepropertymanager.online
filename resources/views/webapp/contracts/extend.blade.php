@extends('layouts.argon.main')

@section('title', 'Extend')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{Session::get('property_name')}}
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
           <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Rooms</span>
              </a>
              @endif
            
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bulk Billing</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Daily Collection Report</span>
              </a>
            </li>
            @if(Session::get('property_type') === 'Apartment Rentals')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/remittances">
                <i class="fas fa-hand-holding-usd text-teal"></i>
                <span class="nav-link-text">Remittances</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">User History</span>
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
                    <span id='delete_row' class="btn btn-danger"> Remove</span>
                  <span id="add_row" class="btn btn-primary"> Add </span>     
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
        
        
        <button type="submit" form="extendContractForm" class="btn btn-success btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Extend</button>
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



