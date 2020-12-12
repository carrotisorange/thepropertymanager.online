@extends('templates.webapp-new.template')

@section('title', $tenant->first_name.' '.$tenant->last_name)


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
            @if(Session::get('property_type') === 'Condominium Corporation')
            <li class="nav-item">
                <a class="nav-link active" href="/property/{{$property->property_id }}/occupants">
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
<?php   $diffInDays =  number_format(Carbon\Carbon::now()->DiffInDays(Carbon\Carbon::parse($tenant->moveout_date), false)) ?>
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6>
    {{-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"></li>
      </ol>
    </nav> --}}
  </div>

</div>
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
        @if($tenant->email_address === null || $tenant->contact_no === null)
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user"></i> Profile <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i></span></a>
        @else
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user"></i> Profile</a>
        @endif

        @if($access->count() <=0  )
        <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="true"><i class="fas fa-user-lock"></i> Access <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i></span>  </a>
        @else
        <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="nav-user" aria-selected="true"><i class="fas fa-user-lock"></i> Access </a>
        @endif
       
    
         @if($balance->count() <= 0)
         <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="true"><i class="fas fa-file-invoice-dollar"></i> Bills </a>
         @else
         <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="true"><i class="fas fa-file-invoice-dollar"></i> Bills <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> {{ $balance->count() }}</span></a>
         @endif

         
         <a class="nav-item nav-link" id="nav-payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="nav-payments" aria-selected="true"><i class="fas fa-money-bill"></i> Payments </a>


        <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concern" aria-selected="false"><i class="fas fa-tools"></i> Concerns</a>
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

    {{-- <a href="/asa/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}"  class="btn btn-primary"><i class="fas fa-user"></i> Change property </a> --}}


    @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
    <a href="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/edit"  class="btn btn-primary"><i class="fas fa-user-edit"></i> Edit</a>  
    @endif

     <br><br>
     @if($tenant->email_address === null || $tenant->contact_no === null)
    <p class="text-danger">Email address or mobile is missing!</p>
     @endif
      <div class="table-responsive text-nowrap">
        <table class="table" >
            
              <tr>
                  <th>Name</th>
                  <td>{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }} 
                     
                  </td>
              </tr>
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
          
              <tr>
                  <th>Mobile</th>
                  <td>{{ $tenant->contact_no }}</td>
              </tr>
              <tr>
                  <th>Email</th>
                  <td>{{ $tenant->email_address }}</td>
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
        <a  href="#" class="btn btn-primary " data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus"></i> Add</a>  
        <br><br>
        <div class="row" >
          <div class="col-md-12 mx-auto" >
        <div class="table-responsive text-nowrap">
         <table class="table">
           <?php $ctr = 1; ?>
           <thead>
             <tr>
               <th>#</th>
               
                 <th>Date Reported</th>
                
                 <th>Room</th>
                 <th>Type</th>
                 <th>Description</th>
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
            
               <td>{{ Carbon\Carbon::parse($item->date_reported)->format('M d Y') }}</td>
                 
                 <td>{{ $item->building.' '.$item->unit_no }}</td>
                 <td>
                   
                     {{ $item->concern_type }}
                     
                 </td>
                 <td ><a href="/property/{{ $property->property_id }}/concern/{{ $item->concern_id }}">{{ $item->concern_item }}</a></td>
                 <td>
                     @if($item->concern_urgency === 'urgent')
                     <span class="badge badge-danger">{{ $item->concern_urgency }}</span>
                     @elseif($item->concern_urgency === 'major')
                     <span class="badge badge-warning">{{ $item->concern_urgency }}</span>
                     @else
                     <span class="badge badge-primary">{{ $item->concern_urgency }}</span>
                     @endif
                 </td>
                 <td>
                     @if($item->concern_status === 'pending')
                     <span class="badge badge-warning">{{ $item->concern_status }}</span>
                     @elseif($item->concern_status === 'active')
                     <span class="badge badge-primary">{{ $item->concern_status }}</span>
                     @else
                     <span class="badge badge-success">{{ $item->concern_status }}</span>
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
             <div class="row">
              <div class="col">
               
                <div class="alert alert-success alert-dismissable custom-success-box">
                  
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fas fa-check"></i>  By default, the password would be the mobile number of the occupant. If the password is not letting you in, try using 12345678 as the password instead. <br> Please ask the occupant to immediately change the password.</strong>
                      
                    
                </div>
            
              </div>
            </div>
             <table class="table">
               
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

      <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
        <a href="#" data-toggle="modal" data-target="#addBill" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a> 
        @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
          <a href="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/bills/edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
          @endif
          @if($balance->count() > 0)
          <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/download" class="btn btn-primary"><i class="fas fa-download"></i> Export</span></a>
          {{-- @if($tenant->email_address !== null)
          <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/send" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</span></a>
          @endif --}}
          @endif
        
      

    <br>
    <br>
    <div class="col-md-12 mx-auto">
    <div class="table-responsive">
      <div class="table-responsive text-nowrap">
        <table class="table">
          <?php $ctr=1; ?>
        <thead>
          <tr>
            <th class="text-center">#</th>
             <th>Date posted</th>
               <th>Bill no</th>
               
               <th>Particular</th>
               <th>Period covered</th>
               <th class="text-right" >Bill amount</th>
               <th class="text-right" >Amount paid</th>
               <th class="text-right" >Balance</th>
               {{-- <th></th> --}}
             </tr>
        </thead>
          @foreach ($bills as $item)
          <tr>
         <th class="text-center">{{ $ctr++ }}</th>
            <td>
              {{Carbon\Carbon::parse($item->billing_date)->format('M d Y')}}
            </td>   

              <td>{{ $item->billing_no }}</td>
      
              <td>{{ $item->billing_desc }}</td>
              <td>
                {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
              </td>
              <td class="text-right"  >{{ number_format($item->billing_amt,2) }}</td>
              <td class="text-right"  >{{ number_format($item->amt_paid,2) }}</td>
              <td class="text-right" >
                @if($item->balance > 0)
                <span class="text-danger">{{ number_format($item->balance,2) }}</span>
                @else
                <span >{{ number_format($item->balance,2) }}</span>
                @endif
              </td>
              {{-- <td class="text-center">
                @if(Auth::user()->user_type === 'manager')
                <form action="/property/{{ $property->property_id }}/tenant/{{ $item->billing_tenant_id }}/bill/{{ $item->billing_id }}" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
                </form>
                @endif
              </td> --}}
                     </tr>
                     
          @endforeach
          <tr>
            <th>Total </th>
            <th class="text-right" colspan="5">{{ number_format($bills->sum('billing_amt'),2) }} </th>
            <th class="text-right" colspan="">{{ number_format($bills->sum('amt_paid'),2) }} </th>
            <th class="text-right text-danger" colspan="">
              @if($bills->sum('balance') > 0)
              <span class="text-danger">{{ number_format($bills->sum('balance'),2) }}</span>
              @else
              <span >{{ number_format($bills->sum('balance'),2) }}</span>
              @endif
         
             </th>
           </tr>
        
      </table>

    </div>
    </div>
    
      </div>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              {!! Auth::user()->note !!}
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="nav-payments-tab">
        @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
        <a href="#" data-toggle="modal" data-target="#acceptPayment" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
        @endif 
        <br><br>
        <div class="col-md-12 mx-auto">
        <div class="table-responsive text-nowrap">
          <table class="table">
            @foreach ($payments as $day => $collection_list)
             <thead>
                <tr>
                    <th colspan="10">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $collection_list->count() }})</th>
                    
                </tr>
                <tr>
                  <?php $ctr = 1; ?>
                    <th class="text-center">#</th>
                    <th>AR No</th>
                    <th>Bill No</th>
                    {{-- <th>Room</th>   --}}
                    <th>Particular</th>
                    <th colspan="2">Period Covered</th>
                    <th>Form</th>
                    <th class="text-right">Amount</th>
                   
                   {{-- <th colspan="2">Action</th> --}}
                     {{-- <th></th> --}}
                    </tr>
              </tr>
             </thead>
              @foreach ($collection_list as $item)
             
              <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                      <td>{{ $item->ar_no }}</td>
                      <td>{{ $item->payment_billing_no }}</td>
                        {{-- <td>{{ $item->building.' '.$item->unit_no }}</td>  --}}
                       <td>{{ $item->billing_desc }}</td> 
                       <td colspan="2">
                        {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                        {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
                      </td>
                      <td>{{ $item->form_of_payment }}</td>
                      <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
                       
                       {{-- <td class="text-center">
                       <a title="export" target="_blank" href="/units/tenants/{{ $item->payment_tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
                        {{--  <a target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a> 
                        
                      </td>  --}}
                       <td class="text-center">
                       @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
                        <form action="/property/{{$property->property_id}}/tenant/{{ $tenant->tenant_id }}/payment/{{ $item->payment_id }}" method="POST">
                          @csrf
                          @method('delete')
                          <button title="delete" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                        </form>
                        @endif
                      </td>    
                     
                  </tr>
              @endforeach
                  <tr>
                    <th>Total</th>
                    <th colspan="7" class="text-right">{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
                  </tr>
                  
            @endforeach
        </table>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>


@include('webapp.tenants.show_includes.tenants.upload-img')

@include('webapp.tenants.show_includes.bills.create')

@include('webapp.tenants.show_includes.payments.create')

@include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')

@include('webapp.tenants.show_includes.concerns.create')



         {{-- Modal for warning message --}}
         <div class="modal fade" id="sendNotice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  
                    <form action="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/alert/contract">
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

<div class="modal fade" id="userAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title text-primary" id="exampleModalLabel"><i class="fas fa-user-lock"></i> Tenant Credentials</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
     <p class="text-danger"><i class="fas fa-exclamation-triangle"></i>  Tenant needs to verify email before can access the system. 
      <br> Please make sure that the email is valid before creating credentials. </p>
      
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
    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"><i class="fas fa-times fa-sm text-white-50"></i> Close </button>
    <button type="submit" form="userForm" class="btn btn-primary"><i class="fas fa-check"></i> Create</button> 
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
        $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='requestMoveoutForm' name='billing_desc"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='requestMoveoutForm'    oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm' name='billing_amt"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
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
      $('#row'+j).html("<th>"+ (j) +"</th><td><select class='form-control' name='billing_desc"+j+"' form='extendTenantForm' id='billing_desc"+j+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='extendTenantForm' name='billing_start"+j+"' id='billing_start"+j+"' type='date' value='{{ $tenant->moveout_date }}' required></td> <td><input class='form-control' form='extendTenantForm' name='billing_end"+j+"' id='billing_end"+j+"' type='date' required></td> <td><input class='form-control' form='extendTenantForm'   name='billing_amt"+j+"' id='billing_amt"+j+"' type='number' min='1' step='0.01' required></td>");
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
      $('#bill'+k).html("<th>"+ (k) +"</th><td><select class='form-control' name='billing_desc"+k+"' form='addBillForm' id='billing_desc"+k+"'><option value='' selected>Please select one</option><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Surcharge'>Surcharge</option><option value='Water'>Water</option></select> <td><input class='form-control' form='addBillForm' name='billing_start"+k+"' id='billing_start"+k+"' type='date' value='{{ $tenant->movein_date }}' required></td> <td><input class='form-control' form='addBillForm' name='billing_end"+k+"' id='billing_end"+k+"' type='date' value='{{ $tenant->moveout_date }}' required></td> <td><input class='form-control' form='addBillForm' name='billing_amt"+k+"' id='billing_amt"+k+"' type='number' min='1' step='0.01' required></td>");
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
        $('#payment'+j).html("<th>"+ (j) +"</th><td><select class='form-control' form='acceptPaymentForm' name='billing_no"+j+"' id='billing_no"+j+"' required><option >Please select bill</option> @foreach ($balance as $item)<option value='{{ $item->billing_no.'-'.$item->bill_id }}'> Bill No {{ $item->billing_no }} | {{ $item->billing_desc }} | {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} - {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }} | {{ number_format($item->balance,2) }} </option> @endforeach </select></td><td><input class='form-control'  form='acceptPaymentForm' name='amt_paid"+j+"' id='amt_paid"+j+"' type='number' step='0.01' required></td><td><select class='form-control'  form='acceptPaymentForm' name='form_of_payment"+j+"' required><option value='Cash'>Cash</option><option value='Bank Deposit'>Bank Deposit</option><option value='Cheque'>Cheque</option></select></td><td>  <input class='form-control'  form='acceptPaymentForm' type='text' name='bank_name"+j+"'></td><td><input class='form-control'  form='acceptPaymentForm' type='text' name='cheque_no"+j+"'></td>");
  
  
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



