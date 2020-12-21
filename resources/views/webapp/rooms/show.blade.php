@extends('templates.webapp-new.template')

@section('title', $home->building.' '.$home->unit_no)

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
             <li class="nav-item">
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
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{  $home->building.' '.$home->unit_no }}</h6>
    
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="nav-room" aria-selected="true"><i class="fas fa-home fa-sm text-primary-50"></i> Room</a>
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users fa-sm text-primary-50"></i> Tenants</a>
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie fa-sm text-primary-50"></i> Owners</a>
          <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-signature fa-sm text-primary-50"></i> Bills <span class="badge badge-primary badge-counter"></span></a>
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
    
          <button type="button" title="edit room" class="btn btn-primary" data-toggle="modal" data-target="#editUnit" data-whatever="@mdo"><i class="fas fa-edit"></i> Edit</button> 
    
          <div class="col-md-12 mx-auto">
           
          <br>
            <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
            <div class="table-responsive text-nowrap">
          <table class="table">
               <tr>
                    <th>Room</th>
                    <td>{{ $home->unit_no }}</td>
               </tr>
                <tr>
                    <th>Building</th>
                    <td>{{ $home->building }}</td>
               </tr>
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
               <tr>
                    <th>Type</th>
                    <td>{{ $home->type }}</td>
               </tr>
             
               
               <tr>
                <th>Occupancy</th>
                <td>{{ $home->occupancy }} pax</td>
              </tr>
              <tr>
                    <th>Status</th>
                    <td>{{ $home->status }}</td>
                </tr>
                <tr>
                    <th>Rent</th> 
                    <td>{{ number_format($home->rent,2) }}</td>
    
                    <?php 
                        session([Auth::user()->id.'tenant_monthly_rent'=> $home->rent]);
                        session([Auth::user()->id.'unit_id'=> $home->unit_id]);
                        session([Auth::user()->id.'unit_no'=> $home->unit_no]);
                        session([Auth::user()->id.'building'=> $home->building]);
                    ?>
                </tr>
            
           </table>
          </div>
          </div>
        </div>
  
        <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <?php $ctr=1; ?>
              <thead>
            <tr>
              <th>#</th>
              <th>Date Billed</th>
              <th>Bill No</th>
              <th>Tenant</th>
              <th>Description</th>
              <th colspan="2">Period Covered</th>
              <th class="text-right">Amount</th>
            
            </tr>
     
            
            </table>
        
           
            </div>
        </div>
        </div>
  
        <div class="tab-pane fade" id="tenants" role="tabpanel" aria-labelledby="nav-tenants-tab">
          @if ($tenant_active->count() < $home->occupancy)
          <a href="/property/{{ $property->property_id }}/home/{{ $home->unit_id }}/tenant" title="{{ $home->occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." type="button" class="btn  btn-primary">
              <i class="fas fa-user-plus"></i> Add </a>
    
          @else
          <a href="#/" title="{{ $home->occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." data-toggle="modal" data-target="#warningTenant" data-whatever="@mdo" type="button" class="btn  btn-primary">
              <i class="fas fa-user-plus"></i> Add 
            </a>
          @endif
          <br><br>
          <div class="col-md-12 mx-auto">
     
       
  
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-user-check fa-sm text-50"></i> Active  <span class="badge badge-primary">{{ $tenant_active->count() }}</span></a>
              <a class="nav-item nav-link"  data-toggle="tab" href="#reserved" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-user-clock fa-sm text-50"></i> Reserved <span class="badge badge-primary">{{ $tenant_reserved->count() }}</a>
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
                    <p class="text-center">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tenant</th>
                    <th>Movein</th>   
                    <th>Moveout</th>
                    <th>Term</th>
                    <th>Rent</th>
                </tr>
              </thead>
                <?php $ctr = 1; ?>   
            @foreach ($tenant_active as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <td><a href="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
                    <td>{{ $item->movein_at }}</td>
                    <td>{{ $item->moveout_at }}</td>
                    <td>{{ $item->term }}</td>
                    {{-- <td title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->moveout_date), false) }} days left">{{ Carbon\Carbon::parse($item->movein_at)->format('M d Y').'-'.Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</> --}}
                      <td>{{ number_format($item->contract_rent, 2) }}</td>
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
                    <p class="text-center">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tenant</th>
                    <th>Reserved Via</th>
                    <th>Reserved On</th>   
                             
                    <th></th>
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_reserved as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <td><a href="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
                    @if($item->type_of_tenant === 'online')
                    <td><a class="badge badge-success">{{ $item->type_of_tenant }}</td>
                    @else
                    <td><a class="badge badge-warning">{{ $item->type_of_tenant }}</td>
                    @endif
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    <th>{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->created_at)->addDays(7), false) }} days before exp</th>
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
                    <p class="text-center">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tenant</th>
                    
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
                    <td><a href="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
                    
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
          <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
          <br><br>
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
  
            <table class="table" >
            <thead>
            <tr>
               <th>#</th>
               
                 <th>Date Reported</th>
                
               
    
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
           
              <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                
  
               
                <td ><a href="/property/{{ $property->property_id }}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></td>
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
        
        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
        
     <a  data-toggle="modal" data-target="#addInvestor" data-whatever="@mdo" type="button" class="btn btn-primary text-white">
      <i class="fas fa-user-plus text-white-50"></i> Add
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
                     <td><a href="/property/{{ $property->property_id }}/owner/{{ $item->owner_id }}">{{ $item->name }} </a></td>
              
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
  
  <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="editUnitForm" action="/units/{{$home->unit_id }}" method="POST">
            @method('put')
            @csrf
        </form>
        <div class="modal-body">
        <form>
            <div class="form-group">
            <small>Room No</small>
            <input form="editUnitForm" type="text" value="{{ $home->unit_no }}" name="unit_no" class="form-control" id="unit_no" >
            </div>
            <div class="form-group">
            <small>Floor</small>
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
                <small>Building</small>
                <input form="editUnitForm" type="text" value="{{ $home->building }}" name="building" class="form-control"> 
              </div>
            <div class="form-group">
            <small>Type</small>
            <select form="editUnitForm" id="type" name="type" class="form-control">
                <option value="{{ $home->type }}" readonly selected class="bg-primary">{{ $home->type }}</option>
                <option value="commercial">commercial</option>
                <option value="residential">residential</option>
            </select>
            </div>
            <input  form="editUnitForm"  type="hidden" name="property_id" value="{{ $property->property_id }}">
            <div class="form-group">
              <small>Occupancy</small>
              <input  oninput="this.value = Math.abs(this.value)" form="editUnitForm" type="number" value="{{ $home->occupancy }}" name="occupancy" class="form-control"> 
            </div>
            <div class="form-group">
            <small>Status</small>
            <select form="editUnitForm" id="status" name="status" class="form-control">
                <option value="{{ $home->status }}" readonly selected class="bg-primary">{{ $home->status }}</option>
                <option value="vacant">vacant</option>
                <option value="occupied">occupied</option>
                
                <option value="reserved">reserved</option>
            </select>
            </div>
            <div class="form-group">
                <small>Rent</small>
                <input form="editUnitForm"  oninput="this.value = Math.abs(this.value)" step="0.01" type="number" value="{{ $home->rent }}" name="rent" class="form-control">
                </div>
       
        </form>
        </div>
        <div class="modal-footer">
       
        <button type="submit" form="editUnitForm" class="btn btn-primary" this.disabled = true;><i class="fas fa-check fa-sm text-white-50"></i> Save Changes</button>  
        </div>
    </div>
    </div>
  </div>

                     {{-- Modal for renewing tenant --}}
                     <div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Concern</h5>
                  
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                          <div class="modal-body">
                              <form id="concernForm" action="/property/{{ $property->property_id }}/home/{{ $home->unit_id }}/concern" method="POST">
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
                                     <label>Type</label>
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
                                <label>Title</label>
                              
                                <input type="text" form="concernForm" class="form-control" name="title" required >
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
                              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-sm text-dark-50"></i> Cancel</button> 
                              <button type="submit" form="concernForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
                          </div>
                      </div>
                      </div>
                  </div>
  @include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')
  @include('webapp.tenants.show_includes.owners.create')
@endsection



@section('scripts')
  
@endsection



