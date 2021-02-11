@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/#contracts"">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/">Contract ID: {{ $contract->contract_id }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
    </nav>
    
    
  </div>
</div>

<div class="row">
    <form id="editContractForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/update" method="POST">
    @csrf
    @method('PUT')
    </form>
    <div class="col-md-11 mx-auto">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
               {{-- <tr>
                   <th>Tenant</th>
                   <td><select form="editContractForm" class="form-control" name="tenant_id_foreign" id="tenant_id_foreign">
                       <option value="{{ $contract->tenant_id_foreign }}" selected>{{ $contract->tenant_id_foreign }}</option>
                       @foreach ($tenants as $item)
                        <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</option>
                       @endforeach
                       </select>
                    </td>
               </tr> --}}
              <thead>
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
              </thead>
            <thead>
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
            </thead>
            <thead>
              <tr>
                <th>Source</th>
                <td>
                    <select form="editContractForm"  class="form-control" name="form_of_interaction" id="form_of_interaction">
                    <option value="{{ $contract->form_of_interaction }}">{{ $contract->form_of_interaction }}</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Flyers">Flyers</option>
                    <option value="In house">In house</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Website">Website</option>
                    <option value="Walk in">Walk in</option>
                    <option value="Word of mouth">Word of mouth</option>
                    </select>
                </td>
            </tr>
            </thead>
            <thead>
              <tr>
                <th>Rent</th>
                <td><input form="editContractForm" type="number" step="0.001" name="rent" id="rent" class="form-control" value="{{ $contract->rent }}"></td>
            </tr>
            </thead>
            <thead>
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
            </thead>
           <thead>
            <tr>
              <th>Movein</th>
              <td><input form="editContractForm" type="date"  name="movein_at" id="movein_at" onkeyup='autoFill()' class="form-control" value="{{ Carbon\Carbon::parse($contract->movein_at)->format('Y-m-d') }}"></td>
          </tr>
           </thead>
            <thead>
              <tr>
                <th>Moveout</th>
                <td><input form="editContractForm" type="date" name="moveout_at" id="moveout_at" onkeyup='autoFill()' class="form-control" value="{{ Carbon\Carbon::parse($contract->moveout_at)->format('Y-m-d') }}"></td>
            </tr>
            </thead>
           <thead>
            <tr>
              <th>Length of stay</th>
              <td><input form="editContractForm" type="text" class="form-control" name="number_of_months" id="number_of_months" required readonly value="{{ $contract->number_of_months? $contract->number_of_months: 'NULL' }}"></td>
              <small class="text-danger" id="invalid_date"></small>
          </tr>
           </thead>
          <thead>
            <tr>
              <th>Term</th>
              <td><input form="editContractForm" type="text" class="form-control" name="term" id="term" value="{{ $contract->term? $contract->term: 'NULL' }}" required readonly></td>
          </tr>
          </thead>
          <thead>
            <tr>
              <th>Date terminated</th>
              <td><input form="editContractForm" type="date" class="form-control" name="terminated_at" id="terminated_at" value="{{ $contract->terminated_at? Carbon\Carbon::parse($contract->terminated_at)->format('Y-m-d'): 'NA' }}" ></td>
          </tr>
          </thead>
           <thead>
            <tr>
              <th>Actual moveout</th>
              <td><input form="editContractForm" type="date" class="form-control" name="actual_moveout_at" id="actual_moveout_at" value="{{ $contract->actual_moveout_at? Carbon\Carbon::parse($contract->moveout_at)->format('Y-m-d'): 'NA' }}" ></td>
          </tr>
           </thead>
            <thead>
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
            </thead>
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



