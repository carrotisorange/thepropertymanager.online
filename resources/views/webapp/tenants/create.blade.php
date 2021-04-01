@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no )

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/room/{{ $unit->unit_id }}/#tenants">{{ $unit->building.' '.$unit->unit_no }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tenant Information Sheet</li>
      </ol>
    </nav>
    
    
  </div>
  
  <div class="col-lg-3">
    <small class="">Refferer <span class="text-danger">*</span></small>
    <select class="form-control" form="addTenantForm1" name="referrer_id" id="referrer_id">
     <option value="">Please select one</option>
     @foreach ($users as $item)
       <option value="{{ $item->id }}">{{ $item->name }}</option>
     @endforeach
    </select>
 
  
   </div>

   <div class="col-lg-3">
    <small class="">Source <span class="text-danger">*</span></small>
    <select class="form-control" form="addTenantForm1" name="form_of_interaction" id="form_of_interaction" required>
      <option value="{{ old('form_of_interaction')? old('form_of_interaction'): '' }}" selected>{{ old('form_of_interaction')? old('form_of_interaction'): 'Please select one' }} </option>
       <option value="Facebook">Facebook</option>
       <option value="Flyers">Flyers</option>
       <option value="In house">In house</option>
       <option value="Instagram">Instagram</option>
       <option value="Website">Website</option>
       <option value="Walk in">Walk in</option>
       <option value="Word of mouth">Word of mouth</option>
    </select>

    @error('form_of_interaction')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>

  
  
</div>


<form id="addTenantForm1" action="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/tenant/" method="POST">
  {{ csrf_field() }}
  </form>
  
  <h2>Tenant Details</h2>
  <div class="row">

      <div class="col">
          <small class="">First Name <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" name="first_name" id="first_name"  value="{{ old('first_name') }}">
             @error('first_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      <div class="col">
          <small class="">Middle Name</small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('middle_name') is-invalid @enderror" name="middle_name" id="middle_name"  value="{{ old('middle_name') }}">
          @error('middle_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="col">
          <small class="">Last Name  <span class="text-danger">*</span></small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" name="last_name" id="last_name"  value="{{ old('last_name') }}">
  
          @error('last_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      </div>
      <br>
  <div class="row">
      <div class="col">
          <small class="">Birthdate <span class="text-danger">*</span></small></small>
          <input form="addTenantForm1" type="date" class="form-control form-control-user @error('birthdate') is-invalid @enderror" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" >
  
          @error('birthdate')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">Gender <span class="text-danger">*</span></small></small>
          <select form="addTenantForm1"  id="gender" name="gender" class="form-control" required>        
              <option value="{{ old('gender')? old('gender'): '' }}" selected>{{ old('gender')? old('gender'): 'Please select one' }} </option>
              <option value="male">male</option>
              <option value="female">female</option>
          </select>
  
          @error('gender')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">Civil Status <span class="text-danger">*</span></small></small>
          <select form="addTenantForm1"  id="civil_status" name="civil_status" class="form-control" required>
            <option value="{{ old('civil_status')? old('civil_status'): '' }}" selected>{{ old('civil_status')? old('civil_status'): 'Please select one' }} </option>
              <option value="single">single</option>
              <option value="married">married</option>
          </select>

          @error('civil_status')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
      <div class="col">
          <small class="">ID/ID Number</small>
          <input form="addTenantForm1" type="text" class="form-control form-control-user @error('id_number') is-invalid @enderror" name="id_number" id="id_number" value={{ old('id_number') }}>

          @error('id_number')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
  </div>

  <input type="hidden" form="addTenantForm1" value="{{Session::get('property_id')}}" name="property_id">
  <br>
  <div class="row">
    <div class="col">
      <small class="">Type of tenant <span class="text-danger">*</span></small></small>
      <select form="addTenantForm1"  id="type_of_tenant" name="type_of_tenant" class="form-control" required>
        <option value="{{ old('type_of_tenant')? old('type_of_tenant'): '' }}" selected>{{ old('type_of_tenant')? old('type_of_tenant'): 'Please select one' }} </option>
          <option value="studying">studying</option>
          <option value="working">working</option>
      </select>

      @error('type_of_tenant')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
  </div>
      <div class="col">
          <small class="">Mobile <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="number" class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no" id="contact_no"  value="{{ old('contact_no') }}">
  
        @error('contact_no')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="col">
          <small class="">Email <span class="text-danger">*</span></small>
        <input form="addTenantForm1" type="email" class="form-control form-control-user @error('email_address') is-invalid @enderror" name="email_address" id="email_address" onchange='autoFillEmail()' value="{{ old('email_address') }}">
        <input form="addTenantForm1" type="hidden" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" id="email" >
  
        {{-- @error('email_address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror --}}

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
  </div>
  <hr>
 
  <h2>Contract Details</h2>
  <div class="row">
      <div class="col">
        <small>Movein  <span class="text-danger">*</span></small>
        
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
  <small>Discount </small>
  <input form="addTenantForm1" type="number" class="form-control form-control-user @error('discount') is-invalid @enderror" name="discount" min="0" id="discount" step="0.001" value="{{ old('discount') }}" >

 
  @error('discount')
  <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>
  <div class="col">
    <small>Rent (per month) <span class="text-danger">*</span></small>
    <input form="addTenantForm1" type="number" step="0.001" class="form-control form-control-user @error('rent') is-invalid @enderror" name="rent" id="rent" value="{{ $unit->rent }}" required>
    <input form="addTenantForm1" type="hidden" class="form-control" name="original" min="1" id="original" value="{{ $unit->rent }}" required>
 
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
     
        <h2>Movein charges <small>(Optional)</span>
          <p class="text-right">
            <a href="#/" id='delete_row' class="btn btn-danger"> Remove</a>
            <a href="#/" id="add_row" class="btn btn-primary"> Add</a>    
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
    
      {{-- <a href="/property/{{Session::get('property_id')}}/home/{{ $unit->unit_id }}/tenant" class="btn btn-danger">Reset</a> --}}
      <button type="submit" form="addTenantForm1" class="btn btn-success btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Proceed to movein</button>

  

@endsection

@section('main-content')

@endsection

@section('scripts')
  

<script type="text/javascript">

  //adding moveout charges upon moveout
    $(document).ready(function(){
        var i=1;
       
    $("#add_row").click(function(){
        $('#addr'+i).html("<th>"+ i +"</th><td><select class='form-control' name='particular"+i+"' form='addTenantForm1' id='particular"+i+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='addTenantForm1' name='amount"+i+"' id='amount"+i+"' type='number' min='1' step='0.01' value='{{ session(Auth::user()->id.'tenant_monthly_rent') }}'' required></td>");


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
<script>
 function changeUnit(val){
  alert(val);
 }

</script>
@endsection



