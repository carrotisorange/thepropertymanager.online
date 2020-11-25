@extends('templates.webapp-new.template')

@section('title', $owner->unit_owner)

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
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/calendar">
                <i class="fas fa-calendar-alt text-red"></i>
                <span class="nav-link-text">Calendar</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{$property->property_id }}/owners">
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
              <a class="nav-link" href="/property/{{$property->property_id }}}/personnels">
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
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Owner Information</h6>
    
  </div>

</div>
<div class="row">
  <form id="editInvestorForm" action="/property/{{ $property->property_id }}/owner/{{ $owner->unit_owner_id }}" method="POST">
    @method('put')
    @csrf
</form>

                <div class="col">
                    <small>Name</small>
                    <input form="editInvestorForm" class="form-control" type="text" name="unit_owner" value="{{ $owner->unit_owner }}" >
                </div>
               
              <div class="col">
                <small>Mobile</small>
                <input form="editInvestorForm" class="form-control" type="text" name="investor_contact_no" value="{{ $owner->investor_contact_no }}" >
            </div>
            <div class="col">
              <small>Email</small>
              <input form="editInvestorForm" class="form-control" type="emailf" name="investor_email_address" value="{{ $owner->investor_email_address }}" >
          </div>  
            
            </div>
            <br>
            <div class="row">
              
          <div class="col">
            <small>Address</small>
            <input form="editInvestorForm" class="form-control" type="text" name="investor_address" value="{{ $owner->investor_address }}" >
        </div>  
             
          </div>
<br>
          <div class="row">
              
            <div class="col">
              <small>Authorized Representative</small>
              <input form="editInvestorForm" class="form-control" type="text" name="investor_representative" value="{{ $owner->investor_representative }}" >
          </div>  
               
            </div>

            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-dark d-inline-block mb-0">Bank Information</h6>
                
              </div>
            
            </div>

            <div class="row">
              <div class="col">
                <small>Bank Name</small>
                <input form="editInvestorForm" class="form-control" type="text" name="bank_name" >
            </div>

            <div class="col">
              <small>Account Name</small>
              <input form="editInvestorForm" class="form-control" type="text" name="account_name" value="{{ $owner->account_name? $owner->account_name: $owner->unit_owner }}">
          </div>

            <div class="col">
              <small>Account Number</small>
              <input form="editInvestorForm" class="form-control" type="text" name="account_number" >
            </div>
            </div>
          
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-dark d-inline-block mb-0">Room Information</h6>
                
              </div>
            
            </div>

            <div class="row">
              
              <div class="col">
                <small>Date Purchased</small>
                <input form="editInvestorForm" class="form-control" type="date" name="date_purchased" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
            </div>  
            
             <div class="col">
                <small>Purchase Amount</small>
                <input form="editInvestorForm" class="form-control" type="number" min="1" step="0.01" name="price"  >
            </div>  

            <div class="col">
              <small>Payment type</small>
              <select name="payment_type" id=""  form="editInvestorForm" class="form-control" >
                  <option value="">Please select one</option>
                  <option value="Full Cash">Full Cash</option>
                  <option value="Full Downpayment">Full Downpayment</option>
                  <option value="Installment">Installment</option>
              </select>
          </div>  
                 
              </div>
     <br>
         <div class="row">
         <div class="col">
          <p class="text-right">   
            <a href="/property/{{ $property->property_id}}/owner/{{ $owner->unit_owner_id }}" class="btn btn-secondary"><i class="fas fa-times fa-sm text-dark-50"></i> Cancel</a>
            <button type="submit" form="editInvestorForm" class="btn btn-primary" ><i class="fas fa-check fa-sm text-white-50"></i> Save Changes</button>
        </p>   
         </div>
        </div>  
  



</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



