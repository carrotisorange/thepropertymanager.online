@extends('layouts.argon.main')

@section('title', $home->building.' '.$home->unit_no)

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
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/rooms">
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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
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
                <span class="nav-link-text">Bulk Billing</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Daily Collection Report</span>
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
                <span class="nav-link-text">User History</span>
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
             <li class="nav-item">
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
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/rooms/">{{ Session::get('property_name') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $home->building.' '.$home->unit_no }}</li>
      </ol>
    </nav>
    
    
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="nav-room" aria-selected="true"><i class="fas fa-home fa-sm text-primary-50"></i> Room</a>
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users fa-sm text-primary-50"></i> Tenants <span class="badge badge-primary badge-counter">{{ $tenants->count() }}</a>
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie fa-sm text-primary-50"></i> Owners <span class="badge badge-primary badge-counter">{{ $owners->count() }}</a>
          <a class="nav-item nav-link" id="nav-remittances-tab" data-toggle="tab" href="#remittances" role="tab" aria-controls="nav-remittances" aria-selected="false"><i class="fas fa-hand-holding-usd fa-sm text-primary-50"></i> Remittances <span class="badge badge-primary badge-counter">{{ $remittances->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="nav-expenses" aria-selected="false"><i class="fas fa-file-export fa-sm text-primary-50"></i> Expenses <span class="badge badge-primary badge-counter">{{ $expenses->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-primary-50"></i> Concerns <span class="badge badge-primary badge-counter">{{ $concerns->count() }}</span></a>
        </div>
      </nav>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content" id="nav-tabContent">
     
        <div class="tab-pane fade show active" id="room" role="tabpanel" aria-labelledby="nav-room-tab">
    
          <p class="text-left">
            <button type="button" title="edit room" class="btn btn-primary" data-toggle="modal" data-target="#editUnit" data-whatever="@mdo"><i class="fas fa-edit"></i> Edit Room</button> 
            <button type="button" title="edit room" class="btn btn-primary" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button> 
          </p>
          <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                Room Information
              </div>
              <div class="card-body">
                
                <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
                <div class="table-responsive text-left">
              <table class="table">
                 <thead>
                  <tr>
                    <th>Room</th>
                    <td>{{ $home->unit_no }}</td>
               </tr>
               <tr>
                <th>Size</th>
                <td>{{ $home->size }} <b>sqm</b></td>
           </tr>
                 </thead>
                  <thead>
                    <tr>
                      <th>Building</th>
                      <td>{{ $home->building }}</td>
                 </tr>
                  </thead>
                   <thead>
                    <tr>
                      <th>Floor</th>
               
                      <td>
                        @if($home->floor <= 0)
                        {{ $numberFormatter->format($home->floor * -1) }} basement
                        @else
                        {{ $numberFormatter->format($home->floor) }} floor
                        @endif
                        
                      </td>
                 </tr>
                   </thead>
                  <thead>
                    <tr>
                      <th>Type</th>
                      <td>{{ $home->type }}</td>
                 </tr>
                  </thead>
                  <thead>
                    <tr>
                      <th>Occupancy</th>
                      <td>{{ $home->occupancy? $home->occupancy: 0 }} <b>pax</b></td>
                    </tr>
                  </thead>
                 <thead>
                  <tr>
                    <th>Status</th>
                    <td>{{ $home->status }}</td>
                </tr>
                 </thead>
                   <thead>
                    <tr>
                      <th>Rent</th> 
                      <td>{{ number_format($home->rent,2) }}/month</td>
                  </tr>
                   </thead>
                
               </table>
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>
       
        </div>

        
        <div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="nav-expenses-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <?php $exp_ctr=1; ?>
              <thead>
                <tr>
                  <th>#</th>
              
                  <th>Remittance ID</th>
  
             
            
                <th>Particular</th>
              
    
              
                <th class="text-right">Amount</th>
                
                </tr>
            </thead>
            <tbody>
              @foreach ($expenses as $item)
                <tr>
                  <th>{{ $exp_ctr++ }}</th>
                  
         
                  <td>{{ $item->remittance_id_foreign }}</td>
               
                  <td>{{ $item->expense_particular }}</td>
              
                  <td class="text-right">{{ number_format($item->expense_amt,2) }}</td>
                </tr>    
              @endforeach
              <tr>
                <th>TOTAL</th>
                <th colspan="5" class="text-right">{{  number_format($expenses->sum('expense_amt'),2) }}</th>
              </tr>
            </tbody>
            </table>
        
            </div>
        </div>
        </div>


        <div class="tab-pane fade" id="remittances" role="tabpanel" aria-labelledby="nav-remittances-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <?php $rem_ctr=1; ?>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Remittance ID</th>
                  <th>Date Remitted</th>
                  <th>Status</th>
                <th>Period Covered</th>
                <th>Particular</th>
              
    
              
                <th class="text-right">Amount</th>
                
                </tr>
            </thead>
            <tbody>
              @foreach ($remittances as $item)
                <tr>
                  <th>{{ $rem_ctr++ }}</th>
                  <td>{{ $item->remittance_id }}</td>
                  <td>
                    @if($item->isRemitted === 'pending')
                    NA
                    @else
                    {{ Carbon\Carbon::parse($item->dateRemitted)->format('M d, Y') }}
                    @endif
                  </td>
                  <td>
                    @if($item->isRemitted === 'pending')
                    <span class="badge badge-danger">{{ $item->isRemitted }}</span>
                    @else
                    <span class="badge badge-success">{{ $item->isRemitted }}</span>
                    @endif
                   
                  </td>
                 
                  <td>{{ Carbon\Carbon::parse($item->start)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end)->format('M d, Y') }}</td>
                  <td>{{ $item->particular }}</td>
 
              
                  <th class="text-right"><a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/remittance/{{ $item->remittance_id }}">{{ number_format($item->amt_remitted,2) }}</a></th>
                </tr>    
              @endforeach
              <tr>
                <th>TOTAL</th>
                <th colspan="6" class="text-right">{{  number_format($remittances->sum('amt_remitted'),2) }}</th>
              </tr>
            </tbody>
            </table>
        
           
            </div>
        </div>
        </div>


  
        <div class="tab-pane fade" id="tenants" role="tabpanel" aria-labelledby="nav-tenants-tab">
          @if ($tenant_active->count() < $home->occupancy)
          <a href="/property/{{Session::get('property_id')}}/room/{{ $home->unit_id }}/tenant" title="{{ $home->occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." type="button" class="btn  btn-primary">
              <i class="fas fa-user-plus"></i> Add Tenant</a>
    
          @else
          <a href="#/" title="{{ $home->occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." data-toggle="modal" data-target="#warningTenant" data-whatever="@mdo" type="button" class="btn  btn-primary">
              <i class="fas fa-user-plus"></i> Add Tenant
            </a>
          @endif
          <br><br>
          <div class="col-md-12 mx-auto">
     
       
  
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-user-check fa-sm text-50"></i> Active  <span class="badge badge-primary">{{ $tenant_active->count() }}</span></a>
              <a class="nav-item nav-link"  data-toggle="tab" href="#reserved" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-user-clock fa-sm text-50"></i> Reserved <span class="badge badge-primary">{{ $tenant_reserved->count() }}</a>
                <a class="nav-item nav-link"  data-toggle="tab" href="#movingout" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-user-clock fa-sm text-50"></i> Moving Out <span class="badge badge-primary">{{ $tenant_movingout->count() }}</a>
              <a class="nav-item nav-link"  data-toggle="tab" href="#inactive" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-user-times fa-sm text-50"></i> Inactive <span class="badge badge-primary">{{ $tenant_inactive->count() }}</a>
            </div>
          </nav>
          <br>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="table-responsive text-nowrap">
              <table class="table">
                @if($tenant_active->count() <= 0)
                <tr>
                    <br><br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Movein</th>   
                    <th>Moveout</th>
                    <th>Term</th>
                    <th>Rent</th>
                    <th>Source</th>
                </tr>
              </thead>
                <?php $ctr = 1; ?>   
            @foreach ($tenant_active as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
                    <td>{{ $item->contract_term }}</td>
                    {{-- <td title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->moveout_date), false) }} days left">{{ Carbon\Carbon::parse($item->movein_at)->format('M d Y').'-'.Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</> --}}
                      <td>{{ number_format($item->contract_rent, 2) }}</td>
                      <td>{{ $item->form_of_interaction }}</td>
                    </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="reserved" role="tabpanel" aria-labelledby="nav-tenant-tab">
              <div class="table-responsive text-nowrap">
              <table class="table">
                @if($tenant_reserved->count() <= 0)
                <tr>
                    <br><br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Reserved Via</th>
                    <th>Source</th>
                    <th>Reserved</th>
                    <th>Days before for forfeiture</th>   
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_reserved as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    @if($item->type_of_tenant === 'online')
                    <td><a class="badge badge-success">{{ $item->type_of_tenant }}</td>
                    @else
                    <td><a class="badge badge-warning">{{ $item->type_of_tenant }}</td>
                    @endif
                    <td>{{ $item->form_of_interaction }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    <td>{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->created_at)->addDays(7), false) }}</td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="movingout" role="tabpanel" aria-labelledby="nav-tenant-tab">
              <div class="table-responsive text-nowrap">
              <table class="table">
                @if($tenant_movingout->count() <= 0)
                <tr>
                    <br><br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Moveout</th>
                     
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_movingout as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    <td>{{Carbon\Carbon::parse($item->moveout_at)->format('M d Y')}} <span class="text-danger">({{ Carbon\Carbon::parse($item->moveout_at)->diffForHumans() }})</span></td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="inactive" role="tabpanel" aria-labelledby="nav-contact-tab">
              <div class="table-responsive text-nowrap">
              <table class="table">
                @if($tenant_inactive->count() <= 0)
                <tr>
                    <br><br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    
                    <th>Inactive since</th>   
                    <th>Reason for moving out</th>
                    <th></th>
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_inactive as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    
                    <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d Y') }}</td>
                    <td>{{ $item->moveout_reason }}</td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
          </div>
        </div>
        </div>
  
        <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">
          <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add Concern</a>  
          <br><br>
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
  
            <table class="table" >
            <thead>
            <tr>
              <?php $ctr=1; ?>
               <th>#</th>
               
                 <th>Date Reported</th>
                
               
    
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
                
  
               
                <th><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></th>
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
                  @if($item->concern_status === 'pending')
                  <i class="fas fa-clock text-warning"></i> {{ $item->concern_status }}
                  @elseif($item->concern_status === 'active')
                  <i class="fas fa-snowboarding text-primary"></i> {{ $item->concern_status }}
                  @else
                  <i class="fas fa-check-circle text-success"></i> {{ $item->concern_status }}
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
        
        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
        
     <a  data-toggle="modal" data-target="#addInvestor" data-whatever="@mdo" type="button" class="btn btn-primary text-white">
      <i class="fas fa-user-plus text-white-50"></i> Add Owner
    </a>   
  <br>
     <br>
        <div class="col-md-12 mx-auto">

          <div class="table-responsive text-nowrap">
            <table class="table">
              <?php $ctr=1;?>
              <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Representative</th>
              
                  </tr>
                </thead>
                  @foreach ($owners as $item)
                  <tr>
                    <th>{{ $ctr++ }}</th>
                     <th><a href="/property/{{Session::get('property_id')}}/owner/{{ $item->owner_id }}">{{ $item->name }} </a></thf>
              
                    <td>{{ $item-> email}}</td>
                    <td>{{ $item->mobile }}</td>
                    <td>{{ $item->representative }}</td>
                    
                  </tr>
                  @endforeach
                
            </table>
    
           
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Room Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="editUnitForm" action="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id}}/update" method="POST">
            @method('put')
            @csrf
        </form>
        <div class="modal-body">
            <div class="form-group">
            <label>Room</label>
            <input form="editUnitForm" type="text" value="{{ $home->unit_no }}" name="unit_no" class="form-control" id="unit_no" >
            </div>
            <div class="form-group">
              <label>Size <small>(sqm)</small></label>
              <input form="editUnitForm" type="text" value="{{ $home->size }}" name="size" class="form-control" id="size" >
              </div>
            
            <div class="form-group">
            <label>Floor</label>
            <select form="editUnitForm" id="floor" name="floor" class="form-control">
                <option value="{{ $home->floor }}" readonly selected class="bg-primary">{{ $home->floor }}</option>
                <option value="-5">5th basement</option>
                <option value="-4">4th basement</option>
                <option value="-3">3rd basement</option>
                <option value="-2">2nd basement</option>
                <option value="-1">1st basement</option>
                
                <option value="1">1st floor</option>
                <option value="2">2nd floor</option>
                <option value="3">3rd floor</option>
                <option value="4">4th floor</option>
                <option value="5">5th floor</option>
                <option value="6">6th floor</option>
                <option value="7">7th floor</option>
                <option value="8">8th floor</option>
                <option value="9">9th floor</option>
            </select>
            </div>
            <div class="form-group">
                <label>Building <small>(Optional)</small></label>
                <input form="editUnitForm" type="text" value="{{ $home->building }}" name="building" class="form-control"> 
              </div>
            <div class="form-group">
            <label>Type</label>
            <select form="editUnitForm" id="type" name="type" class="form-control">
                <option value="{{ $home->type }}" readonly selected class="bg-primary">{{ $home->type }}</option>
                <option value="commercial">commercial</option>
                <option value="residential">residential</option>
            </select>
            </div>
            <input  form="editUnitForm"  type="hidden" name="property_id" value="{{Session::get('property_id')}}">
            <div class="form-group">
              <label>Occupancy <small>(Numner of tenants allowed)</small></label>
              <input  oninput="this.value = Math.abs(this.value)" form="editUnitForm" type="number" value="{{ $home->occupancy? $home->occupancy: 0 }}" name="occupancy" class="form-control"> 
            </div>
            <div class="form-group">
            <label>Status</label>
            <select form="editUnitForm" id="status" name="status" class="form-control">
                <option value="{{ $home->status }}" readonly selected class="bg-primary">{{ $home->status }}</option>
                <option value="dirty">dirty</option>
                <option value="occupied">occupied</option>
                <option value="reserved">reserved</option>
                <option value="vacant">vacant</option>
            </select>
            </div>
            <div class="form-group">
                <label>Rent <small>(/month)</small></label>
                <input form="editUnitForm"  oninput="this.value = Math.abs(this.value)" step="0.01" type="number" value="{{ $home->rent? $home->rent: 0 }}" name="rent" class="form-control">
                </div>
      
        </div>
        <div class="modal-footer">
        <button type="submit" form="editUnitForm" class="btn btn-primary" this.disabled = true;> Update</button>  
        </div>
    </div>
    </div>
  </div>

                     {{-- Modal for renewing tenant --}}
                     <div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                      <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Concern Information</h5>
                  
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                          <div class="modal-body">
                              <form id="concernForm" action="/property/{{Session::get('property_id')}}/home/{{ $home->unit_id }}/concern" method="POST">
                                  @csrf
                              </form>
    
                              <div class="row">
                                <div class="col">
                                    <label>Date Reported</label>
                                    <input type="date" form="concernForm" class="form-control" name="reported_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
                                </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col">
                                  <label>Title</label>
                                
                                  <input type="text" form="concernForm" class="form-control" name="title" required >
                              </div>
                            </div>  
                            <br>
                            
                            <div class="row">
                              <div class="col">
                                  <label>Reported By</label>
                                  <select class="form-control" form="concernForm" name="reported_by" id="" required>
                                    <option value="">Please select one</option>
                                    @foreach ($reported_by as $item)
                                    <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} (tenant)</option>
                                    @endforeach
                                   
                                  </select>
                              </div>
                          </div>
                          <br>
                              <div class="row">
                                  <div class="col">
                                     <label>Category</label>
                                      <select class="form-control" form="concernForm" name="category" id="" required>
                                        <option value="" selected>Please select one</option>
                                        <option value="billing">billing</option>
                                        <option value="employee">employee</option>
                                        <option value="internet">internet</option>
                                        <option value="neighbour">neighbour</option>
                                        <option value="noise">noise</option>
                                        <option value="odours">odours</option>
                                        <option value="parking">parking</option>
                                        <option value="pets">pets</option>
                                        <option value="repair">repair</option>
                                        <option value="others">others</option>
                                      </select>
                                  </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col">
                                   <label>Urgency</label>
                                    <select class="form-control" form="concernForm" name="urgency" id="" required>
                                      <option value="" selected>Please select one</option>
                                      <option value="minor and not urgent">minor and not urgent</option>
                                      <option value="minor but urgent">minor but urgent</option>
                                      <option value="major but not urgent">major but not urgent</option>
                                      <option value="major and urgent">major and urgent</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                           
                        
                          
                           <div class="row">
                                <div class="col">
                                    <label>Details</label>
                                    
                                    <textarea form="concernForm" rows="7" class="form-control" name="details" required></textarea>
                                </div>
                            </div>
                            <br>
                           <div class="row">
                              <div class="col">
                                  <label for="movein_date">Assign concern to</label>
                                  <select class="form-control" form="concernForm" name="concern_user_id" required>
                                    <option value="" selected>Please select one</option>
                                    @foreach($users as $item)
                                        <option value="{{ $item->id }}"> {{ $item->user_type }}</option>
                                    @endforeach   
                                  </select>
                              </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            
                              <button type="submit" form="concernForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add Concern</button>
                          </div>
                      </div>
                      </div>
                  </div>

                  <div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form  method="POST" id="uploadImagesForm" action="/property/{{Session::get('property_id')}}/room/{{ $home->unit_id }}/upload" enctype="multipart/form-data">
                            @csrf
                        </form>
                        <div class="modal-body">
                          <input form="uploadImagesForm" class="form-control" type="file" name="file[]" accept="image/*" multiple required/>
                          <br><br>
                          <div class="progress">
                            <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                0%
                            </div>
                          </div>
                          <br><br>
                          <div id="success" class="row">

                          </div>

                        </div>
                        <div class="modal-footer">
                        <button type="submit" form="uploadImagesForm" class="btn btn-primary" this.disabled = true;> Upload</button>  
                        </div>
                    </div>
                    </div>
                  </div>
  @include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')
  @include('webapp.tenants.show_includes.owners.create')
@endsection



@section('scripts')
<script>
  $(document).ready(function(){
      $('form').ajaxForm({
          beforeSend:function(){
              $('#success').empty();
              $('.progress-bar').text('0%');
              $('.progress-bar').css('width', '0%');
          },
          uploadProgress:function(event, position, total, percentComplete){
              $('.progress-bar').text(percentComplete + '0%');
              $('.progress-bar').css('width', percentComplete + '0%');
          },
          success:function(data)
          {
              if(data.success)
              {
                  $('#success').html('<div class="text-success text-center"><b>'+data.success+'</b></div><br /><br />');
                  $('#success').append(data.image);
                  $('.progress-bar').text('Uploaded');
                  $('.progress-bar').css('width', '100%');
              }
          }
      });
  });
  </script>  
@endsection



