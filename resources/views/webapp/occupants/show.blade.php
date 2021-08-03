@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('css')
 <style>
/*This will work on every browser*/
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>   
@endsection

@section('upper-content')
<?php   $diffInDays =  number_format(Carbon\Carbon::now()->DiffInDays(Carbon\Carbon::parse($tenant->moveout_date), false)) ?>
{{-- <div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6>
    {{-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"></li>
      </ol>
    </nav> 
  </div>

</div> --}}
<br>
<div class="row">
  <div class="col">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissable custom-danger-box">
      
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            @foreach ($errors->all() as $error)
            <strong><i class="fas fa-exclamation-triangle"></i>  {{ $error }}</strong>
            @endforeach
        
    </div>
@endif
  </div>
</div>
<div class="row">
 
  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @if($tenant->contact_no === null)
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user text-green"></i> Profile <i class="fas fa-exclamation-triangle text-danger"></i></a>
        @else
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user text-green"></i> Profile</a>
        @endif

        @if($access->count() <=0  )
        <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="false"><i class="fas fa-user-circle text-dan"></i> Access <i class="fas fa-exclamation-triangle text-danger"></i></a>
        @else
        <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="false"><i class="fas fa-user-circle text-dark"></i> Access </a>
        @endif

        <a class="nav-item nav-link" id="nav-contracts-tab" data-toggle="tab" href="#contracts" role="tab" aria-controls="nav-contracts" aria-selected="false"><i class="fas fa-home text-indigo"></i> 
          @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
        Units
        @else
        Rooms
        @endif
        </a>
    
        <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concern" aria-selected="false"><i class="fas fa-tools text-cyan"></i> Concerns</a>
      </div>
    </nav>
    
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        
<div class="row">
  <div class="col-md-8">

    {{-- <a href="/asa/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}"  class="btn btn-primary"><i class="fas fa-user"></i> Change property </a> --}}


    @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
    <a href="/property/{{Session::get('property_id')}}/occupant/{{ $tenant->tenant_id }}/edit"  class="btn btn-primary btn-sm"><i class="fas fa-user-edit"></i> Edit</a>  
    @endif

 <br><br>
     @if($tenant->contact_no === null)
    <small class="text-danger">Email address or mobile is missing!</small>
     @endif
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered table-hover" >
            
              <tr>
                  <th>Name</th>
                  <td>{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }} 
                     
                  </td>
              </tr>
                  <tr>
                  <th>Mobile</th>
                  <td>{{ $tenant->contact_no }}</td>
              </tr>
              {{-- <tr>
                  <th>Email</th>
                  <td>{{ $tenant->email_address }}</td>
              </tr> --}}
             
              <tr>
                  <th>Gender</th>
                  <td>{{ $tenant->gender }}</td>
              </tr>
              <tr>
                  <th>Birthdate</th>
                  <td>{{ Carbon\Carbon::parse($tenant->birthdate)->format('M d Y') }}</td>
              </tr>
              <tr>
                  <th>Civil Status</th>
                  <td>{{ $tenant->civil_status }}</td>
              </tr>
              <tr>
                  <th>ID/ID Number</th>
                  <td>{{ $tenant->id_number }}</td>
              </tr>
              <tr>
                  <th>Address</th>
                  <td>{{ $tenant->barangay.', '.$tenant->city.', '.$tenant->province.', '.$tenant->country.', '.$tenant->zip_code }}</td>
              </tr>
          
          
  
              

          </table>
        </div>
  </div>
  <div class="col-md-4">
  
    <img  src="{{ $tenant->tenant_img? asset('../storage/img/tenants/'.$tenant->tenant_img): asset('/arsha/assets/img/no-image.png') }}" alt="image of the tenant" class="img-thumbnail">
   
    <form id="uploadImageForm" action="/property/{{ $property->property_id}}/tenant/{{ $tenant->tenant_id }}/upload/img" method="POST" enctype="multipart/form-data">
      @method('put')
      @csrf
    </form>
  <br>

    <input type="file" form="uploadImageForm" name="tenant_img" class="form-control @error('tenant_img') is-invalid @enderror">
    @error('tenant_img')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
  @enderror
    <br>
   
    <button class="btn btn-primary shadow-sm btn-user btn-block" form="uploadImageForm"><i class="fas fa-upload fa-sm text-white-50"></i> Upload Image </button>

  </div>

</div>
      </div>

      <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">
        
        <div class="row" >
          <div class="col-md-12" >
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
            <table class="table table-hover table-bordered">
           <?php $ctr = 1; ?>
           <thead>
             <tr>
               <th>#</th>
               
                 <th>Date Reported</th>
                
                 <th>Category</th>
                 <th>Title</th>
                 <th>Urgency</th>
                 <th>Status</th>
                 <th>Assigned to</th>
                 <th>Rating</th>
                 <th>Feedback</th>
            </tr>
           </thead>
           <tbody>
             @foreach ($concerns as $item)
             <tr>
               <th>{{ $ctr++ }}</th>
            
               <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                 
                
                 <td>
                   
                     {{ $item->category }}
                     
                 </td>
                 <td ><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></td>
                 <td>
                     @if($item->urgency === 'urgent')
                     <span class="badge badge-danger">{{ $item->urgency }}</span>
                     @elseif($item->urgency === 'major')
                     <span class="badge badge-warning">{{ $item->urgency }}</span>
                     @else
                     <span class="badge badge-primary">{{ $item->urgency }}</span>
                     @endif
                 </td>
                 <td>
                     @if($item->status === 'pending')
                     <span class="badge badge-warning">{{ $item->status }}</span>
                     @elseif($item->status === 'active')
                     <span class="badge badge-primary">{{ $item->status }}</span>
                     @else
                     <span class="badge badge-success">{{ $item->status }}</span>
                     @endif
                 </td>
                 <td>{{ $item->name }}</td>
                 <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
                 <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td>
             </tr>
             @endforeach
           </tbody>
         </table>
        
       </div>
                
                
          </div>
      </div>
      </div>

      <div class="tab-pane fade" id="contracts" role="tabpanel" aria-labelledby="nav-contracts-tab">

       
       
       <div style="display:none" id="showSelectedContract" class="col-md-6 p-0 m-0 mx-auto text-center">
       <div class="alert alert-success alert-dismissable custom-success-box">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <strong id="showNumberOfSelectedContract"></strong>
        </div>
     </div>
         <div class="row">
           <form action="" method="POST">
             @csrf
             @method('put')
           </form>
           <div class="col-md-12" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
            <table class="table table-hover table-bordered">
               <thead>
                 <?php $ctr = 1; ?>
                 <tr>
                   {{-- <th><div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" id="selectAll" onclick="selectAll()" value="option1">
                   </div> --}}
                 </th>
                   <th>#</th>
                   <th>Building</th>
                   @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
                    <th>Unit</th>
                    @else
                    <th>Room</th>
                    @endif
                 
                   <th>Movein</th>
                   <th>Last electric consumption</th>
                   <th>Last water consumption</th>
                  
             <th></th>
 
                   
                 </tr>
               </thead>
               <tbody>
                @foreach ($contracts as $item)
                <tr>
                  {{-- <th>
                    <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" onclick="selectOne()" id="checkbox{{$item->contract_id}}" value="{{$item->contract_id}}">
                   </div>
                 </th> --}}
                 <th>{{ $ctr++ }}</th>
                 <td>{{ $item->building }}</td>
                 <td><a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id_foreign }}">{{ $item->unit_no }}</a></td>
                 
                 <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                 <td>{{ $item->initial_electric }}</td>
               <td>{{ $item->initial_water }}</td>
                
  
          
               </tr>
                @endforeach
               </tbody>
             </table>
 
           </div>
         </div>
       </div>
      
      <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="nav-user-tab">
        @if($access->count() <=0  )
        <button  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userAccess" data-whatever="@mdo"><i class="fas fa-plus"></i> Create access to the system</button>
        <br><br>
        @endif
     
        
        <div class="col-md-12 mx-auto">

            <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
             @if($access->count() <= 0)
              <p class="text-center text-danger">No credentials found!</p>

             @else
             @foreach ($access as $item)
        
             <table class="table table-hover table-bordered">
               
                 <tr>  
                   <th>Name</th>
                   <td>{{ $item->name }}</td>
                 </tr>
               
                 <tr>
                   <th>Email</th>
                   <td>{{ $item->email }}</td>
                 </tr>
               
             </table>
             @endforeach


             @endif
            </div>
       
        </div>
      </div>

    </div>
  </div>
</div>


@include('webapp.tenants.show_includes.tenants.upload-img')

@include('webapp.tenants.show_includes.payments.create')

@include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')

@include('webapp.tenants.show_includes.concerns.create')



         {{-- Modal for warning message --}}
         <div class="modal fade" id="sendNotice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Send Notice</h5>
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body">
                  <span class="text-justify">
                      <h5>Hello, {{ $tenant->first_name }}!</h5>
                  
                      <p>Your contract in <b></b> is set to expire on <b>{{ Carbon\Carbon::parse($tenant->moveout_date)->format('M d Y') }}</b>, exactly <b>{{ $diffInDays }} days </b> from now. 
                          
                      Would you like to extend your contract?If yes, for how long? </p>
                  
                      <p><b>This is a system generated message, and we do not receive emails from this account. Please let us know your response atleast a week before your moveout date through this email {{ Auth::user()->email }} instead. </b></p>
                  
                      Sincerely,
                      <br>
                      {{ Auth::user()->property }}
                    </span>
                    <hr>
                  
                    <form action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/alert/contract">
                      @csrf
                    <span>
                      <p class="text-right">
                      <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Close</button>
                      <button class="btn btn-primary btn btn-primary" title="for manager and admin access only" type="submit" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-paper-plane fa-sm text-white-50"></i> Send</button>
                      </p>
                    </form>
                  </p>
              </div>
              
          </div>
          </div>
</div>

<div class="modal fade" id="userAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"><i class="fas fa-user-lock"></i> Add Credentials</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
   
      
     <form id="userForm" action="/property/{{$property->property_id}}/tenant/{{ $tenant->tenant_id }}/user/create" method="POST">
    @csrf
    </form>
     <table class="table table-borderless">
      <tr>
        <th>Name</th>
        <td><input type="text" name="name" form="userForm" class="form-control form-control-user @error('name') is-invalid @enderror" value="{{ $tenant->first_name.' '.$tenant->last_name }}" required>
        <br>
        @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
      </td>
      
      </tr>
       <tr>
         <th>Email</th>
         <td><input type="email" name="email" form="userForm"  class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ $tenant->tenant_unique_id.'@thepropertymanager.online' }}" required>
        <br>
        @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </td>
       
       </tr>
       <tr>
         <th>Password</th>
         <td><input type="text" name="password" form="userForm"  class="form-control form-control-user @error('password') is-invalid @enderror" value="{{ $tenant->password }}" required>
        <br>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
      </td>
         
       </tr>
    
     </table>
   </div>
  <div class="modal-footer">
    <button type="submit" form="userForm" class="btn btn-primary"> Add</button> 
  </div> 
  </div>
  </div>
  
  </div>

  
  <div class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="modal">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Bill</h5>
    
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
     <div class="modal-body">
      <form id="addBillForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/create" method="POST">
         @csrf
      </form>

      
      <div class="row">
        <div class="col">
            <label>Date</label>
            {{-- <input type="date" form="addBillForm" class="form-control" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required > --}}
            <input type="date" class="form-control" form="addBillForm" class="" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
        </div>
      </div>
     
      <br>
      <div class="row">
        <div class="col">
       
          <p class="text-right">
            <span id='delete_bill' class="btn btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove</span>
          <span id="add_bill" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</span>     
          </p>
            <div class="table-responsive text-nowrap">
            <table class = "table" id="table_bill">
               <thead>
                <tr>
                  <th>#</th>
                  <th>Particular</th>
                  <th colspan="2">Period Covered</th>
                  <th>Amount</th>
                  
              </tr>
               </thead>
                    <input form="addBillForm" type="hidden" id="no_of_bills" name="no_of_bills" >
                <tr id='bill1'></tr>
            </table>
          </div>
        </div>
      </div>
     
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-sm text-dark-50"></i> Cancel </button>
     <button form="addBillForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
    </div> 
    </div>
    </div>
    
    </div>
@endsection



@section('scripts')
<script type="text/javascript">
  //adding moveout charges upon moveout
    $(document).ready(function(){
        var i=1;
    $("#add_row").click(function(){
        $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='requestMoveoutForm' name='particular"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='requestMoveoutForm'   oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm' name='amount"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
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
      $('#row'+j).html("<th>"+ (j) +"</th><td><select class='form-control' name='particular"+j+"' form='extendTenantForm' id='particular"+j+"'><option value='Condo Dues'>Condo Dues</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='extendTenantForm' name='start"+j+"' id='start"+j+"' type='date' value='{{ $tenant->moveout_date }}' required></td> <td><input class='form-control' form='extendTenantForm' name='end"+j+"' id='end"+j+"' type='date' required></td> <td><input class='form-control' form='extendTenantForm'   name='amount"+j+"' id='amount"+j+"' type='number' min='1' step='0.01' required></td>");
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
      $('#bill'+k).html("<th>"+ (k) +"</th><td><select name='particular"+k+"' form='addBillForm' id='particular"+k+"' required><option value='' selected>Please select one</option><option value='Condo Dues'>Condo Dues</option><option value='Electric'>Electric</option><option value='Surcharge'>Surcharge</option><option value='Water'>Water</option></select> <td><input form='addBillForm' name='start"+k+"' id='start"+k+"' type='date' required></td> <td><input form='addBillForm' name='end"+k+"' id='end"+k+"' type='date' value='' required></td> <td><input form='addBillForm' name='amount"+k+"' id='amount"+k+"' type='number' min='1' step='0.01' required></td>");
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

<script type="text/javascript">

  //adding moveout charges upon moveout
    $(document).ready(function(){
    var j=1;
    $("#add_payment").click(function(){
        $('#payment'+j).html("<th>"+ (j) +"</th><td><select form='acceptPaymentForm' name='bill_no"+j+"' id='bill_no"+j+"' required><option >Please select bill</option> @foreach ($balance as $item)<option value='{{ $item->bill_no.'-'.$item->bill_id }}'> Bill No {{ $item->bill_no }} | {{ $item->particular }} | {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }} | {{ number_format($item->balance,2) }} </option> @endforeach </select></td><td><input  form='acceptPaymentForm' name='amt_paid"+j+"' id='amt_paid"+j+"' type='number' step='0.01' required></td><td><select form='acceptPaymentForm' name='form"+j+"' required><option value='Cash'>Cash</option><option value='Bank Deposit'>Bank Deposit</option><option value='Cheque'>Cheque</option></select></td><td>  <input  form='acceptPaymentForm' type='text' name='bank_name"+j+"'></td><td><input form='acceptPaymentForm' type='text' name='cheque_no"+j+"'></td>");
  
  
     $('#payment').append('<tr id="payment'+(j+1)+'"></tr>');
     j++;
     document.getElementById('no_of_payments').value = j;
  
    });
  
    $("#delete_payment").click(function(){
        if(j>1){
        $("#payment"+(j-1)).html('');
        j--;
        document.getElementById('no_of_payments').value = j;
        }
    });
  });
</script>

<script>

  function autoFill(){
    var moveout_date = document.getElementById('moveout_date').value;
    var movein_date = document.getElementById('movein_date').value;
    var rent = document.getElementById('rent').value;
    

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
  function selectAll(){

    var x = document.getElementById("selectAll").checked;

    if(x == true){     
      $("#showSelectedContract").show();  
      var checkboxes = $('input:checkbox').length;
      $(':checkbox').each(function() {
        this.checked = true;   
         document.getElementById('showNumberOfSelectedContract').innerHTML =  'You have selected ' + parseInt(checkboxes-1) + ' contracts';                
    });
    }else{ 
      $("#showSelectedContract").hide();  
      $(':checkbox').each(function() {
        this.checked = false;                        
    });
    }
    
   
  }
</script>

<script>
  function selectOne(){
    $("#showSelectedContract").show();  
    var checkboxes = $('input:checkbox:checked').length;
      document.getElementById('showNumberOfSelectedContract').innerHTML =  'You have selected ' + parseInt(checkboxes-1) + ' contracts';   
  }
</script>

@endsection



