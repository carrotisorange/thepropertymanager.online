@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no )

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-3">
    <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}"><i class="fas fa-home"></i> Home</a>
    {{-- <h6 class="h2 text-dark d-inline-block mb-0">iBack</h6> --}}
    
  </div>
  <div class="col-lg-3">
    <form id="contractForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id}}/contract/add" method="POST">
      @csrf
    </form>
    <small class="">Room <span class="text-danger">*</span></small>
   <select class="form-control" form="addTenantForm1" name="unit_id" id="unit_id" required readonly>
    <option value="{{ $unit->unit_id }}" selected>{{ $unit->building.' '.$unit->unit_no }}</option>
    {{-- @foreach ($units as $item)
      <option value="{{ $item->id }}">{{ $item->building.' '.$item->unit_no }}</option>
    @endforeach --}}
   </select>

 
  </div>
  <div class="col-lg-3">
    <small class="">Refferer <span class="text-danger">*</span></small>
    <select class="form-control" form="addTenantForm1" name="referrer_id" id="referrer_id" required readonly>
     {{-- @foreach ($users as $item) --}}
       <option value="{{ $tenant->user_id_foreign }}" selected>{{ $tenant->first_name.' '.$tenant->last_name }}</option>
     {{-- @endforeach
       <option value="1">None</option> --}}
    </select>
 
  
   </div>

   <div class="col-lg-3">
    <small class="">Source <span class="text-danger">*</span></small>
    <input class="form-control" form="addTenantForm1" name="form_of_interaction" id="form_of_interaction" value="Renewal"required readonly>
     {{-- <option value="">Please select one</option>
       <option value="Facebook">Facebook</option>
       <option value="Flyers">Flyers</option>
       <option value="In house">In house</option>
       <option value="Instagram">Instagram</option>
       <option value="layouts.arsha">layouts.arsha</option>
       <option value="Walk in">Walk in</option>
       <option value="Word of mouth">Word of mouth</option> --}}

   </div>

  

</div>
<div class="row">
  <div class="col">
   
    <div class="alert alert-success alert-dismissable custom-success-box">
      
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           
            <strong> You're about to add another contract for {{ $tenant->first_name.' '.$tenant->last_name}}. Please complete the contract details below...</strong>
          
        
    </div>

  </div>
</div>
<hr>
<form id="addTenantForm1" action="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/tenant/{{ $tenant->tenant_id }}/contract/add" method="POST">
  @csrf
  </form>
  
  <h2>Tenant Details</h2>
  <div class="row">

      <div class="col">
          <small class="">First Name <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control" name="first_name" name="first_name" id="first_name" value="{{ $tenant->first_name }}" required readonly>
            {{-- @error('first_name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror --}}
        </div>
      <div class="col">
          <small class="">Middle Name</small>
          <input form="addTenantForm1" type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $tenant->middle_name }}" required readonly>
      </div>
      <div class="col">
          <small class="">Last Name  <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control" name="last_name" id="last_name" value="{{ $tenant->last_name }}" required readonly>
  
          {{-- @error('last_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror --}}
      </div>
      </div>
  
  <input type="hidden" form="addTenantForm1" value="{{Session::get('property_id')}}" name="property_id">
  <hr>

  <h2>Contract Details</h2>
  <div class="row">
    <div class="col">
      <small>Movein <span class="text-danger">*</span></small>
      
      <input form="addTenantForm1" type="date" class="form-control form-control-user @error('movein_at') is-invalid @enderror" name="movein_at" id="movein_at" onchange='autoFill()' value="{{ old('movein_at') }}" required>
    
      @error('movein_at')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror

    </div>
    <div class="col">
      <small>Moveout <span class="text-danger">*</span></small>
      <input form="addTenantForm1" type="date" class="form-control form-control-user @error('moveout_at') is-invalid @enderror" name="moveout_at" id="moveout_at" onchange='autoFill()' value="{{ old('moveout_at') }}" required>
    
      @error('moveout_at')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
      

    </div>
  

    <div class="col">
      <small>Length of stay <span class="text-danger">*</span></small>
      <input form="addTenantForm1" type="text" class="form-control form-control-user @error('number_of_months') is-invalid @enderror" name="number_of_months" id="number_of_months" value="{{ old('number_of_months') }}" required readonly>
      
      @error('number_of_months')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
      <span class="text-danger" role="alert">
        <strong id="invalid-date"></strong>
    </span>
</div>
 
  </div>
    <br>
    <div class="row">
      <div class="col">
        <small>Term <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="text" class="form-control form-control-user @error('term') is-invalid @enderror" name="term" id="term" value="{{ old('term') }}" required readonly>
    
        @error('term')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    <div class="col">
      <small>Discount <span class="text-danger">*</span></small>
      <input form="addTenantForm1" type="number" class="form-control form-control-user @error('discount') is-invalid @enderror" name="discount" min="0" id="discount" step="0.001" value="{{ old('discount') }}" required  >
    
     
      @error('discount')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
      <div class="col">
        <small>Rent (per month) <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="number" step="0.001" class="form-control form-control-user @error('rent') is-invalid @enderror" name="rent" id="rent" value="{{ $unit->monthly_rent }}" required>
        <input form="addTenantForm1" type="hidden" class="form-control" name="original" min="1" id="original" value="{{ $unit->monthly_rent }}" required>
     
        @error('rent')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    
    </div>
    <hr>
            
    <div class="row">
      <div class="col">
     
        <h2>Bills and movein charges <span class="text-danger"><small>(Optional)</small></span>
          <p class="text-right">
            <a href="#/" id='delete_row' class="btn btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove</a>
            <a href="#/" id="add_row" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>    
          </p>
        </h2>
          <div class="table-responsive text-nowrap">
          <table class = "table" id="tab_logic">
             <thead>
              <tr>
                <th>#</th>
                <th>Particular</th>
                <th>Amount</th>
               
            </tr>
             </thead>
                  <input form="addTenantForm1" type="hidden" id="no_of_items" name="no_of_items" >
              <tr id='addr1'></tr>
          </table>
        </div>
      </div>
    </div>
  
  <br>
  <p class="text-right">   
     
      {{-- <a href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/tenant" class="btn btn-danger">Reset</a> --}}
      <button type="submit" form="addTenantForm1" class="btn btn-success btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Submit</button>
  </p>
  

@endsection

@section('main-content')

@endsection

@section('scripts')
  

<script type="text/javascript">

  //adding moveout charges upon moveout
    $(document).ready(function(){
        var i=1;
    $("#add_row").click(function(){
        $('#addr'+i).html("<th>"+ i +"</th><td><select class='form-control' name='particular"+i+"' form='addTenantForm1' id='particular"+i+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='addTenantForm1' name='amount"+i+"' id='amount"+i+"' type='number' min='1' step='0.01' value='{{ $unit->monthly_rent }}'' required></td>");


     $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
     i++;
     document.getElementById('no_of_items').value = i;

    });

    $("#delete_row").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        document.getElementById('no_of_items').value = i;
        }
    });

});
</script>
<script>

  function autoFill(){
    var moveout_date = document.getElementById('moveout_at').value;
    var movein_date = document.getElementById('movein_at').value;
    var rent = document.getElementById('rent').value;
    

    date1 = new Date(movein_date);
    date2 = new Date(moveout_date);

    let diff = date2-date1; 

    let months = 1000 * 60 * 60 * 24 * 28;

    var dateInMonths = Math.floor(diff/months);

    document.getElementById('number_of_months').value = dateInMonths +' month/s';

    if(dateInMonths <=0 ){
      document.getElementById('invalid-date').innerText = 'Invalid movein or moveout date!';
    }else{
      document.getElementById('invalid-date').innerText = ' ';
      if(dateInMonths <5 ){
        document.getElementById('term').value = 'Short Term';
        document.getElementById('discount').value = 0;
        document.getElementById('rent').value = document.getElementById('original').value;
      }else{
        document.getElementById('term').value = 'Long Term';
        document.getElementById('discount').value = (document.getElementById('original').value * .1);
        document.getElementById('rent').value = document.getElementById('original').value - (document.getElementById('original').value * .1) ;
      }
     
     
    }
  }
</script>
@endsection



