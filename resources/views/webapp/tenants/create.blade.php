@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no )

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
              <a class="nav-link active" href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
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
              <a class="nav-link" href="/property/{{ $property->property_id }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>

            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-3">
    <a class="btn btn-primary" href="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}"><i class="fas fa-home"></i> Home</a>
    {{-- <h6 class="h2 text-dark d-inline-block mb-0">iBack</h6> --}}
    
  </div>
  <div class="col-lg-3">
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
<hr>
<form id="addTenantForm1" action="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}/tenant/" method="POST">
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

  <input type="hidden" form="addTenantForm1" value="{{ $property->property_id }}" name="property_id">
  <br>
  <div class="row">
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
        <input form="addTenantForm1" type="email" class="form-control form-control-user @error('email_address') is-invalid @enderror" name="email_address" id="email_address" value="{{ old('email_address') }}">
  
        @error('email_address')
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
    
      {{-- <a href="/property/{{ $property->property_id }}/home/{{ $unit->unit_id }}/tenant" class="btn btn-danger">Reset</a> --}}
      <button type="submit" form="addTenantForm1" class="btn btn-success btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Submit</button>

  

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



