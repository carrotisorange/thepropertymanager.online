@extends('layouts.argon.main')

@section('title', $owner->name)

@section('upper-content')
{{-- <div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $owner->name }}</h6>
    
  </div>

</div> --}}
<br>
<div class="row">
  <div class="col-md-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-owner-tab" data-toggle="tab" href="#owner" role="tab" aria-controls="nav-owner" aria-selected="true"> <i class="fas fa-user-tie text-teal"></i> Profile</a>
          @if($access->count() <=0  )
          <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="false"> <i class="fas fa-user-circle text-green"></i> Access <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="false"> <i class="fas fa-user-circle text-green"></i> Access </a>
          @endif
          <a class="nav-item nav-link" id="nav-bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="nav-bank" aria-selected="false"><i class="fas fa-money-check text-yellow"></i> Banks <span class="badge badge-primary"></span></a>
          <a class="nav-item nav-link" id="nav-certificates-tab" data-toggle="tab" href="#certificates" role="tab" aria-controls="nav-certificates" aria-selected="false"><i class="fas fa-home text-indigo"></i> 
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            Certificates
            @else
            Rooms
            @endif
            <span class="badge badge-success">{{ $rooms->count() }}</span>
          </a>

          {{-- <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-signature fa-sm text-primary-50"></i> Bills <span class="badge badge-primary badge-counter">{{ $bills->count() }}</span></a> --}}
        </div>
      </nav>
        
    </div>
 
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="owner" role="tabpanel" aria-labelledby="nav-owner-tab">
        <div class="row">
          <div class="col-md-8">
            <a href="/property/{{ Session::get('property_id') }}/owners"  class="btn btn-primary btn-sm"><i class="fas fa-arrow-left fa-sm text-dark-50"></i> Back</a>
            <a href="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/edit" class="btn btn-primary btn-sm" ><i class="fas fa-edit fa-sm text-dark-50"></i> Edit</a>
            {{-- @if(Auth::user()->user_type === 'manager')
            <form action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}/delete" method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
            </form>
            @endif --}}
            <br><br>
  
               <div class="table-responsive text-nowrap">
                 <table class="table table-hover" >
                   <thead>
                    <tr>
                      <th>Name</th>
                      <td>{{ $owner->name }}</td>
                  </tr>
                   </thead>
                    <thead>
                      <tr>
                        <th>Email</th>
                        <td>{{ $owner->email }}</td>
                    </tr>
                    </thead>
                 <thead>
                  <tr>
                    <th>Mobile</th>
                    <td>{{ $owner->mobile }}</td>
                </tr>
                 </thead>
               
              <thead>
                <tr>
                  <th>Address</th>
                  <td>{{ $owner->address }}</td>
                </tr>
              </thead>
              <thead>
                <tr>
                  <th>Representative</th>
                  <td>{{ $owner->representative }}</td>
              </tr>
              </thead>
                 </table>
               </div>
         
           
          </div>
          <div class="col-md-4">
         
           <img  src="{{ $owner->img? asset('/storage/img/owners/'.$owner->img): asset('/arsha/assets/img/no-image.png') }}" alt="..." class="img-thumbnail">
          
           <form id="uploadImageForm" action="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/upload/img" method="POST" enctype="multipart/form-data">
             @method('put')
             @csrf
           </form>
         <br>
       
           <input type="file" form="uploadImageForm" name="img" class="form-control @error('img') is-invalid @enderror">
           @error('img')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
         @enderror
           <br>
          
           <button class="btn btn-primary btn-user btn-block" form="uploadImageForm"><i class="fas fa-upload fa-sm text-white-50"></i> Upload Image </button>
       
         </div> 
        </div>
      </div>

      <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="nav-user-tab">
        @if($access->count() <=0  )
        <button  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userAccess" data-whatever="@mdo"><i class="fas fa-plus"></i> New</button>
        <br><br>
        @endif
     
        
        <div class="col-md-12 mx-auto">
          <div class="table-responsive">
            <div class="table-responsive text-nowrap">
             @if($access->count() <= 0)
              <p class="text-center text-danger">No credentials found!</p>

             @else
             @foreach ($access as $item)
       
             <table class="table table-hover">
               <thead>
                <tr>
                  <th>Email</th>
                  <td>{{ $item->user_email }}</td>
                </tr>
               </thead>
                <thead>
                  <tr>
                    <th>Password</th>
                    <td>{{ $item->mobile }} or <b>12345678</b></td>
                  </tr>
                </thead>
              <thead>
                
                <tr>
                  <th>Created at</th>
                  <td>{{ $item->created_at? $item->created_at: null }}</td>
                </tr>
              </thead>

              <thead>
                <tr>
                  <th>Verified at</th>
                  <td>{{ $item->updated_at? $item->updated_at: null }}</td>
                </tr>
              </thead>
             </table>
             @endforeach


             @endif
            </div>
          </div>
        </div>
      </div>
      
      <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="nav-certificates-tab">
        <a href="#/"  data-toggle="modal" data-target="#addCertificateModal" data-whatever="@mdo" type="button" class="btn btn-primary btn-sm">
          <i class="fas fa-plus fa-sm text-white-50"></i> New
        </a>
        <br><br>
        <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <?php $ctr = 1; ?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Enrollment Date</th>
                  <th>Building</th>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  <th>Unit</th>
                  @else
                  <th>Room</th>
                  @endif
                  <th>Type</th>
                  
                  <th>Status</th>
                  <th>Rent</th>
                  <th>Occupancy</th>
                </tr>
              </thead>
             @foreach ($rooms as $item)
             <tbody>
              <tr>
                <th>{{ $ctr++ }}</th>
                <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                <td>{{ $item->building }}</td>
                <th>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  <a href="/property/{{ Session::get('property_id') }}/unit/{{ $item->unit_id }}">{{ $item->unit_no }}</a>
                  @else
                  <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}">{{ $item->unit_no }}</a>
                  @endif
                 
                </th>
       
                <td>{{ $item->type }}</td>
              
                <td>{{ $item->status }}</td>
                <td>{{ number_format($item->rent, 2) }}</td>
                <td>{{ $item->occupancy? $item->occupancy: 0 }} pax</td>
              </tr>
            </tbody>
             @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
      
      </div>
      <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="nav-bank-tab">
      
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" >
        <thead>
          <tr>
            <th>Bank</th>
            <td>{{ $owner->bank_name }}</td>
          </tr>
        </thead>
      <thead>
        <tr>
          <th>Account name</th>
          <td>{{ $owner->account_name }}</td>
        </tr>
      </thead>
     <thead>
      <tr>
        <th>Account number</th>
        <td>{{ $owner->account_number }}</td>
      </tr>
     </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addCertificateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"> Certificate Information</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
      
     <form id="certificateForm" action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}/certificate/store" method="POST">
    @csrf
    </form>
    <div class="row">
     <div class="col-md-12">
       <label for="">Purchase date</label>
       <input form="certificateForm" class="form-control" type="date" name="date_purchased" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
     </select>
     </div>
   </div>
   <br>
   <div class="row">
     <div class="col-md-12">
       <label for="">Select a room</label>
       <select form="certificateForm" class="form-control" name="unit_id" id="" required>
        <option value="">Please select one</option>
        @foreach ($all_units as $item)
            <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>
        @endforeach
       <option value=""></option>
     </select>
     </div>
   </div>
   <br>
   <div class="row">
    <div class="col-md-12">
      <label for="">Select a payment type</label>
      <select name="payment_type" id=""  form="certificateForm" class="form-control" >
        <option value="">Please select one</option>
        <option value="Full Cash">Full Cash</option>
        <option value="Full Downpayment">Full Downpayment</option>
        <option value="Installment">Installment</option>
    </select>
    </select>
    </div>
  </div>
  <br>
   <div class="row">
    <div class="col-md-12">
      <label for="">Purchase amount</label>
      <input form="certificateForm" class="form-control" type="number" min="1" step="0.01" name="price">
    </select>
    </div>
  </div>
     
 
   </div>
  <div class="modal-footer">

    <button type="submit" form="certificateForm" class="btn btn-primary"> Add Certificate</button> 
  </div> 
  </div>
  </div>
  
  </div>


<div class="modal fade" id="userAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"><i class="fas fa-user-lock"></i>Credential Information</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
      
     <form id="userForm" action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}/user/create" method="POST">
    @csrf
    </form>
     <table class="table table-borderless">
      <tr>
        <th>Name</th>
        <td><input type="text" name="name" form="userForm" class="form-control form-control-user @error('name') is-invalid @enderror" value="{{ $owner->name }}" required>
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
         <td><input type="email" name="email" form="userForm"  class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ $owner->email? $owner->email: Str::random(8).' @thepropertymanager.online' }}" required>
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
         <td><input type="text" name="password" form="userForm"  class="form-control form-control-user @error('password') is-invalid @enderror" value="{{ $owner->mobile? $owner->mobile: '12345678' }}" required>
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

    <button type="submit" form="userForm" class="btn btn-primary"> Add Credential</button> 
  </div> 
  </div>
  </div>
  
  </div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



