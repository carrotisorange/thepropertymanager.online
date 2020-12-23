@extends('layouts.argon.main')

@section('title', 'Edit')

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
  <div class="col-md-8">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6>
    
  </div>
</div>

<div class="row">
    <form id="editContractForm" action="/property/{{ $property->property_id }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/update" method="POST">
    @csrf
    @method('PUT')
    </form>
    <div class="col-md-11 mx-auto">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
               <tr>
                   <th>Tenant</th>
                   <td><select form="editContractForm" class="form-control" name="tenant_id_foreign" id="tenant_id_foreign">
                       <option value="{{ $contract->tenant_id_foreign }}" selected>{{ $contract->tenant_id_foreign }}</option>
                       @foreach ($tenants as $item)
                        <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</option>
                       @endforeach
                       </select>
                    </td>
               </tr>
               <tr>
                <th>Room</th>
              <td>
                <select form="editContractForm" class="form-control" name="unit_id_foreign" id="unit_id_foreign">
                    <option value="{{ $contract->unit_id_foreign }}" selected>{{ $contract->unit_id_foreign }}</option>
                    @foreach ($units as $item)
                     <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>
                    @endforeach
                    </select>
              </td>
            </tr>
            <tr>
                <th>Referrer</th>
               <td>
                <select form="editContractForm" class="form-control" name="referrer_id" id="referrer_id">
                    <option value="{{ $contract->referrer_id? $contract->referrer_id: '36' }}" selected>{{ $contract->referrer_id }}</option>
                    @foreach ($users as $item)
                     <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                    <option value="36">None</option>
                    </select>
               </td>
            </tr>
            <tr>
                <th>Source</th>
                <td>
                    <select form="editContractForm"  class="form-control" name="form_of_interaction" id="form_of_interaction">
                    <option value="{{ $contract->form_of_interaction }}">{{ $contract->form_of_interaction }}</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Flyers">Flyers</option>
                    <option value="In house">In house</option>
                    <option value="Instagram">Instagram</option>
                    <option value="layouts.arsha">layouts.arsha</option>
                    <option value="Walk in">Walk in</option>
                    <option value="Word of mouth">Word of mouth</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Rent</th>
                <td><input form="editContractForm" type="number" step="0.001" name="rent" id="rent" class="form-control" value="{{ $contract->rent }}"></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <select form="editContractForm" class="form-control" form="" name="status" id="status">
                        <option value="{{ $contract->status }}">{{ $contract->status }}</option>
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                        <option value="pending">pending</option>
                    </select>
                </td>
         
            </tr>
            <tr>
                <th>Movein</th>
                <td><input form="editContractForm" type="date"  name="movein_at" id="movein_at" onkeyup='autoFill()' class="form-control" value="{{ Carbon\Carbon::parse($contract->movein_at)->format('Y-m-d') }}"></td>
            </tr>
            <tr>
                <th>Moveout</th>
                <td><input form="editContractForm" type="date" name="moveout_at" id="moveout_at" onkeyup='autoFill()' class="form-control" value="{{ Carbon\Carbon::parse($contract->moveout_at)->format('Y-m-d') }}"></td>
            </tr>
            <tr>
                <th>Length of stay</th>
                <td><input form="editContractForm" type="text" class="form-control" name="number_of_months" id="number_of_months" required readonly value="{{ $contract->number_of_months? $contract->number_of_months: 'NULL' }}"></td>
                <small class="text-danger" id="invalid_date"></small>
            </tr>
            <tr>
                <th>Term</th>
                <td><input form="editContractForm" type="text" class="form-control" name="term" id="term" value="{{ $contract->term? $contract->term: 'NULL' }}" required readonly></td>
            </tr>
            <tr>
                <th>Terminated</th>
                <td><input form="editContractForm" type="date" class="form-control" name="terminated_at" id="terminated_at" value="{{ $contract->terminated_at? $contract->terminated_at: 'NULL' }}" ></td>
            </tr>
            <tr>
                <th>Actual moveout</th>
                <td><input form="editContractForm" type="date" class="form-control" name="actual_moveout_at" id="actual_moveout_at" value="{{ $contract->actual_moveout_at? $contract->actual_moveout_at: 'NULL' }}" ></td>
            </tr>
            <tr>
                <th>Reason for termination</th>
                <td> 
                    <select form="editContractForm" class="form-control" name="moveout_reason" id="moveout_reason">
                    <option value="{{ $contract->moveout_reason }}" selected>{{ $contract->moveout_reason }}</option>
                  
                    <option value="End of contract">End of contract</option>
                    <option value="Delinquent">Delinquent</option>
                    <option value="Force majeure">Force majeure</option>
                    <option value="Graduated">Graduated</option>
                    <option value="Run away">Run away</option>
                    <option value="Unruly">Unruly</option>
                    <option value="Unsatisfied with the service">Unsatisfied with the service</option>
                </select>
            </td>
            </tr>
            </table>
        </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <p class="text-right">
         
            <button form="editContractForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?');"> Update</button>
        </p>
    </div>
</div>

@endsection

@section('scripts')
  

<script>

    function autoFill(){
      var moveout_date = document.getElementById('moveout_at').value;
      var movein_date = document.getElementById('movein_at').value;
     
      
  
      date1 = new Date(movein_date);
      date2 = new Date(moveout_date);
  
      let diff = date2-date1; 
  
      let months = 1000 * 60 * 60 * 24 * 28;
  
      let dateInMonths = Math.floor(diff/months);
  
      document.getElementById('number_of_months').value = dateInMonths +' month/s';
  
      if(dateInMonths <=0 ){
        document.getElementById('invalid_date').innerText = 'Invalid movein or moveout date!';
      }else{
        document.getElementById('invalid_date').innerText = ' ';
        if(dateInMonths <5 ){
          document.getElementById('term').value = 'Short Term';
        
        }else{
          document.getElementById('term').value = 'Long Term';
         
        }
       
       
      }
    }
  </script>
@endsection



