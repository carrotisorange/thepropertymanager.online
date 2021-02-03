@extends('layouts.argon.main')

@section('title', 'Remittance')

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
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
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
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            @if(Session::get('property_type') === 'Apartment Rentals')
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/remittances">
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



