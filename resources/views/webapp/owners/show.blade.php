@extends('layouts.argon.main')

@section('title', $owner->name)

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
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                 <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/owners">
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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
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
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $owner->name }}</h6>
    
  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-owner-tab" data-toggle="tab" href="#owner" role="tab" aria-controls="nav-owner" aria-selected="true"><i class="fas fa-user-tie fa-sm text-primary-50"></i> Profile</a>
          @if($access->count() <=0  )
          <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="true"><i class="fas fa-user-lock"></i> Access <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i></span>  </a>
          @else
          <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="true"><i class="fas fa-user-lock"></i> Access </a>
          @endif
          <a class="nav-item nav-link" id="nav-bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="nav-bank" aria-selected="false"><i class="fas fa-money-check fa-sm text-primary-50"></i> Banks <span class="badge badge-primary"></span></a>
          <a class="nav-item nav-link" id="nav-certificates-tab" data-toggle="tab" href="#certificates" role="tab" aria-controls="nav-certificates" aria-selected="false"><i class="fas fa-home fa-sm text-primary-50"></i> 
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            Certificates
            @else
            Rooms
            @endif
            <span class="badge badge-primary">{{ $rooms->count() }}</span>
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
            <a href="/property/{{ Session::get('property_id') }}/owners"  class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
            <a href="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/edit" class="btn btn-primary" ><i class="fas fa-edit fa-sm text-white-50"></i> Edit</a>
            {{-- @if(Auth::user()->user_type === 'manager')
            <form action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}/delete" method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
            </form>
            @endif --}}
            <br><br>
  
               <div class="table-responsive text-nowrap">
                 <table class="table" >
                    <tr>
                        <th>Name</th>
                        <td>{{ $owner->name }}</td>
                    </tr>
                    <tr>
                     <th>Email</th>
                     <td>{{ $owner->email }}</td>
                 </tr>
                  <tr>
                     <th>Mobile</th>
                     <td>{{ $owner->mobile }}</td>
                 </tr>
               
               <tr>
                 <th>Address</th>
                 <td>{{ $owner->address }}</td>
               </tr>
               <tr>
                <th>Representative</th>
                <td>{{ $owner->representative }}</td>
            </tr>
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
        <button  href="#" class="btn btn-primary" data-toggle="modal" data-target="#userAccess" data-whatever="@mdo"><i class="fas fa-plus"></i> Add</button>
        <br><br>
        @endif
     
        
        <div class="col-md-12 mx-auto">
          <div class="table-responsive">
            <div class="table-responsive text-nowrap">
             @if($access->count() <= 0)
              <p class="text-center text-danger">No credentials found!</p>

             @else
             @foreach ($access as $item)
       
             <table class="table">
                 <tr>
                   <th>Email</th>
                   <td>{{ $item->user_email }}</td>
                 </tr>
                 <tr>
                  <th>Password</th>
                  <td>{{ $item->mobile }} or <b>12345678</b></td>
                </tr>
              
                 <tr>
                  <th>Created at</th>
                  <td>{{ $item->created_at? $item->created_at: null }}</td>
                </tr>

                <tr>
                  <th>Verified at</th>
                  <td>{{ $item->updated_at? $item->updated_at: null }}</td>
                </tr>
             </table>
             @endforeach


             @endif
            </div>
          </div>
        </div>
      </div>
      
      <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="nav-certificates-tab">
        <a href="#/"  data-toggle="modal" data-target="#addCertificateModal" data-whatever="@mdo" type="button" class="btn btn-primary">
          <i class="fas fa-plus fa-sm text-white-50"></i> Add 
        </a>
        <br><br>
        <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <?php $ctr = 1; ?>
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
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
                <td>{{ $item->building }}</td>
                <td>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  <a href="/property/{{ Session::get('property_id') }}/unit/{{ $item->unit_id }}">{{ $item->unit_no }}</a>
                  @else
                  <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}">{{ $item->unit_no }}</a>
                  @endif
                 
                </td>
       
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
          <table class="table" >
         <th>Bank</th>
         <td>{{ $owner->bank_name }}</td>
       </tr>
       <tr>
         <th>Account name</th>
         <td>{{ $owner->account_name }}</td>
       </tr>
       <tr>
         <th>Account number</th>
         <td>{{ $owner->account_number }}</td>
       </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addCertificateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"> Add Certificate</h5>
  
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

    <button type="submit" form="certificateForm" class="btn btn-primary"> Add</button> 
  </div> 
  </div>
  </div>
  
  </div>


<div class="modal fade" id="userAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"><i class="fas fa-user-lock"></i> Add Credential</h5>
  
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
         <td><input type="email" name="email" form="userForm"  class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ Str::random(8) }}@thepropertymanager.online" required>
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
         <td><input type="text" name="password" form="userForm"  class="form-control form-control-user @error('password') is-invalid @enderror" value="12345678" required>
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

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



