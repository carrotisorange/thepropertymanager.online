@extends('templates.webapp.template')

@section('title', $unit->building.' '.$unit->unit_no)

@section('sidebar')
   
      
           <!-- Heading -->
      
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
                <a class="nav-link" href="/board">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
              </li>
      
            <hr class="sidebar-divider">
      
            <div class="sidebar-heading">
              Interface
            </div>  
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item active">
            <a class="nav-link" href="/home">
              <i class="fas fa-home"></i>
              <span>Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/calendar">
              <i class="fas fa-calendar-alt"></i>
              <span>Calendar</span></a>
          </li>
          @endif
        
          @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link" href="/tenants">
                <i class="fas fa-users fa-chart-area"></i>
                <span>Tenants</span></a>
            </li>
            @endif
      
       @if((Auth::user()->user_type === 'admin' && Auth::user()->property_ownership === 'Multiple Owners') || (Auth::user()->user_type === 'manager' && Auth::user()->property_ownership === 'Multiple Owners'))
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/owners">
            <i class="fas fa-user-tie"></i>
            <span>Owners</span></a>
        </li>
         @endif
      
         <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/concerns">
          <i class="far fa-comment-dots"></i>
              <span>Concerns</span></a>
        </li>
    
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
        <li class="nav-item">
            <a class="nav-link" href="/joborders">
              <i class="fas fa-tools fa-table"></i>
              <span>Job Orders</span></a>
        </li>
        @endif
      
             <!-- Nav Item - Tables -->
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link collapsed" href="/personnels" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-user-cog"></i>
                <span>Personnels</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="/housekeeping">Housekeeping</a>
                  <a class="collapse-item" href="/maintenance">Maintenance</a>
                </div>
              </div>
            </li>
        @endif
      
           @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <!-- Nav Item - Tables -->
            <li class="nav-item">
              <a class="nav-link" href="/bills">
                <i class="fas fa-file-invoice-dollar fa-table"></i>
                <span>Bills</span></a>
            </li>
           @endif
      
           @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/collections">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Collections</span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/financials">
                <i class="fas fa-coins"></i>
                <span>Financials</span></a>
            </li>
            @endif
      
               @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
            <a class="nav-link" href="/payables">
            <i class="fas fa-hand-holding-usd"></i>
              <span>Payables</span></a>
          </li>
          @endif
      
          @if(Auth::user()->user_type === 'manager')
           <!-- Nav Item - Tables -->
           <li class="nav-item">
            <a class="nav-link" href="/users">
              <i class="fas fa-user-circle"></i>
              <span>Users</span></a>
          </li>
          @endif
          
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
      
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
    
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">{{ $unit->building.' '.$unit->unit_no }}</h1>
</div>
<div class="row">
  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="nav-room" aria-selected="true"><i class="fas fa-home fa-sm text-primary-50"></i> Room</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-users fa-sm text-primary-50"></i> Tenants</a>
        <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie fa-sm text-primary-50"></i> Owners</a>
        <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-signature fa-sm text-primary-50"></i> Bills <span class="badge badge-primary badge-counter">{{ $bills->count() }}</span></a>
        <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-comment-dots fa-sm text-primary-50"></i> Concerns <span class="badge badge-primary badge-counter">{{ $concerns->count() }}</span></a>
      </div>
    </nav>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
   
      <div class="tab-pane fade show active" id="room" role="tabpanel" aria-labelledby="nav-room-tab">
        @if(Auth::user()->user_type === 'manager' )
        <button type="button" title="edit room" class="btn btn-primary" data-toggle="modal" data-target="#editUnit" data-whatever="@mdo"><i class="fas fa-edit fa-sm text-white-50"></i> Edit</button> 
      @endif 
        <div class="col-md-11 mx-auto">
         
        <br>
          <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
          <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
             <tr>
                  <td>Room</td>
                  <td>{{ $unit->unit_no }}</td>
             </tr>
              <tr>
                  <td>Building</td>
                  <td>{{ $unit->building }}</td>
             </tr>
             <tr>
                  <td>Floor No</td>
           
                  <td>
                    @if($unit->floor_no <= 0)
                    {{ $numberFormatter->format($unit->floor_no) }} basement
                    @else
                    {{ $numberFormatter->format($unit->floor_no) }} floor
                    @endif
                    
                  </td>
             </tr>
             <tr>
                  <td>Room Type</td>
                  <td>{{ $unit->type_of_units }}</td>
             </tr>
           
             
             <tr>
              <td>Max Occupancy</td>
              <td>{{ $unit->max_occupancy }} pax</td>
            </tr>
            <tr>
                  <td>Status</td>
                  <td>
                        @if($unit->status === 'occupied')
                        <span class="badge badge-primary">{{ $unit->status }}</span>
                        @elseif($unit->status === 'reserved')
                            <span class="badge badge-warning">{{ $unit->status}} </span>
                        @else
                            <span class="badge badge-secondary">{{ $unit->status }}</span>
                        @endif
                  </td>
              </tr>
              <tr>
                  <td>Monthly Rent <small>(excluding utilities)</small></td> 
                  <td>{{ number_format($unit->monthly_rent,2) }}</td>
  
                  <?php 
                      session([Auth::user()->id.'tenant_monthly_rent'=> $unit->monthly_rent]);
                      session([Auth::user()->id.'unit_id'=> $unit->unit_id]);
                      session([Auth::user()->id.'unit_no'=> $unit->unit_no]);
                      session([Auth::user()->id.'building'=> $unit->building]);
                  ?>
              </tr>
          
         </table>
        </div>
        </div>
      </div>

      <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
        <div class="col-md-11 mx-auto">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <?php $ctr=1; ?>
          <tr>
            <th>#</th>
            <th>Date Billed</th>
            <th>Bill No</th>
            <th>Tenant</th>
            <th>Description</th>
            <th colspan="2">Period Covered</th>
            <th>Amount</th>
          
          </tr>
          @foreach ($bills as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <td>
              {{Carbon\Carbon::parse($item->billing_date)->format('M d Y')}}
            </td>   
              <td>{{ $item->billing_no }}</td>
              <td> <a href="/units/{{ $unit->unit_id }}/tenants/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a></td>
              <td>{{ $item->billing_desc }}</td>
              <td colspan="2">
                {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
              </td>
              <td> <a href="/units/{{ $unit->unit_id }}/tenants/{{ $item->tenant_id }}/billings">{{ number_format($item->billing_amt,2) }}</a></td>
          

          </tr>
          @endforeach
          
          
          </table>
          <table class="table">
            <tr>
             <th>Total</th>
             <th class="text-right">{{ number_format($bills->sum('balance'),2) }} </th>
            </tr>
           
          </table>
          
         
          </div>
      </div>
      </div>

      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        @if ($tenant_active->count() < $unit->max_occupancy)
        <a href="/units/{{ $unit->unit_id }}/tenants-create" title="{{ $unit->max_occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." type="button" class="btn btn-primary">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Add <span class="badge badge-light">{{  $tenant_active->count() }}/{{ $unit->max_occupancy }} </a>
  
        @else
        <a href="#/" title="{{ $unit->max_occupancy - $tenant_active->count() }} remaining tenant/s to be fully occupied." data-toggle="modal" data-target="#warningTenant" data-whatever="@mdo" type="button" class="btn btn-primary">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Add <span class="badge badge-light">{{  $tenant_active->count() }}/{{ $unit->max_occupancy }} 
          </a>
        @endif
        <br><br>
        <div class="col-md-11 mx-auto">
   
     

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-user-check fa-sm text-50"></i> Active  <span class="badge badge-primary">{{ $tenant_active->count() }}</span></a>
            <a class="nav-item nav-link"  data-toggle="tab" href="#reserved" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-user-clock fa-sm text-50"></i> Reserved <span class="badge badge-primary">{{ $tenant_reservations->count() }}</a>
            <a class="nav-item nav-link"  data-toggle="tab" href="#inactive" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-user-times fa-sm text-50"></i> Inactive <span class="badge badge-primary">{{ $tenant_inactive->count() }}</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
              @if($tenant_active->count() <= 0)
              <tr>
                  <br><br><br>
                  <p class="text-center">No tenants found!</p>
              </tr>
              @else
              <tr>
                  <th class="text-center">#</th>
                  <th>Tenant</th>
                  <th>Contract Period</th>   
                  <th>Monthly Rent</th>
              </tr>
              <?php $ctr = 1; ?>   
          @foreach ($tenant_active as $item)
              <tr>
                  <th class="text-center">{{ $ctr++ }}</th>
                  <td><a href="{{ route('show',['unit_id'=> $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
                  <td title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->moveout_date), false) }} days left">{{ Carbon\Carbon::parse($item->movein_date)->format('M d Y').'-'.Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</>
                    <td>{{ number_format($item->tenant_monthly_rent, 2) }}</td>
                  </tr>
          @endforeach
              @endif                        
          </table>
            </div>
          </div>
          <div class="tab-pane fade" id="reserved" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
              @if($tenant_reservations->count() <= 0)
              <tr>
                  <br><br><br>
                  <p class="text-center">No tenants found!</p>
              </tr>
              @else
              <tr>
                  <th class="text-center">#</th>
                  <th>Tenant</th>
                  <th>Reserved Via</th>
                  <th>Reserved On</th>   
                           
                  <th></th>
              </tr>
              <?php
                  $ctr = 1;
              ?>   
          @foreach ($tenant_reservations as $item)
              <tr>
                  <th class="text-center">{{ $ctr++ }}</th>
                  <td><a href="{{ route('show',['unit_id'=> $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
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
            <table class="table table-bordered">
              @if($tenant_inactive->count() <= 0)
              <tr>
                  <br><br><br>
                  <p class="text-center">No tenants found!</p>
              </tr>
              @else
              <tr>
                  <th class="text-center">#</th>
                  <th>Tenant</th>
                  
                  <th>Inactive since</th>   
                  <th>Reason for moving out</th>
                  <th></th>
              </tr>
              <?php
                  $ctr = 1;
              ?>   
          @foreach ($tenant_inactive as $item)
              <tr>
                  <th class="text-center">{{ $ctr++ }}</th>
                  <td><a href="{{ route('show',['unit_id'=> $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }} </a></td>
                  
                  <td>{{ Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</td>
                  <td>{{ $item->reason_for_moving_out }}</td>
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
        <div class="col-md-11 mx-auto">
        <div class="table-responsive text-nowrap">

          <table class="table table-bordered" >
          <thead>
           <tr>
               <th>#</th>
               <th>Date Reported</th>
              <th>Reported By</th>
          
               <th>Type of Concern</th>
               <th>Description</th>
               <th>Urgency</th>
               <th>Status</th>
              
          </tr>
          </thead>
          <tbody>
           @foreach ($concerns as $item)
           <tr>
           <td>{{ $item->concern_id }}</td>
             <td>{{ Carbon\Carbon::parse($item->date_reported)->format('M d Y') }}</td>
             <td>
                    <a href="{{ route('show',['unit_id'=> $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }}</a>
                </td>
              
               <td>
                 
                   {{ $item->concern_type }}
                   
               </td>
               <td ><a title="{{ $item->concern_desc }}" href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/concerns/{{ $item->concern_id }}">{{ $item->concern_item }}</a></td>
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
                   <span class="badge badge-secondary">{{ $item->concern_status }}</span>
                   @endif
               </td>
             
           </tr>
           @endforeach
          </tbody>
          </table>
          

          </div>
      </div>
      </div>
      
      <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
        
      <a href="#/" data-toggle="modal" data-target="#addInvestor" data-whatever="@mdo" type="button" class="btn btn-primary">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Add
      </a>   
      <div class="col-md-11 mx-auto">

    <br>
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <?php $ctr=1;?>
          <tr>
            <th>#</th>
            <th>Owner</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Representative</th>
            <th>Date Purchased</th>
            <th>Date Accepted</th>
            
                </tr>
                @foreach ($unit_owner as $item)
                <tr>
                  <th>{{ $ctr++ }}</th>
                   <td><a href="{{ route('show-investor',['unit_id'=> $item->unit_id_foreign, 'unit_owner_id'=>$item->unit_owner_id]) }}">{{ $item->unit_owner }} </a></td>
            
                  <td>{{ $item-> investor_email_address}}</td>
                  <td>{{ $item->investor_contact_no }}</td>
                  <TD>{{ $item->investor_representative }}</TD>
                  <td>{{ $item->date_invested? Carbon\Carbon::parse($item->date_invested)->format('M d Y'): null}}</td> 
                  <td>{{ $item->date_accepted? Carbon\Carbon::parse($item->date_accepted)->format('M d Y'): null}}</td> 
                  
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
      <h5 class="modal-title" id="exampleModalLabel">Edit Room</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <form id="editUnitForm" action="/units/{{$unit->unit_id }}" method="POST">
          @method('put')
          {{ csrf_field() }}
      </form>
      <div class="modal-body">
      <form>
          <div class="form-group">
          <small>Room No</small>
          <input form="editUnitForm" type="text" value="{{ $unit->unit_no }}" name="unit_no" class="form-control" id="unit_no" >
          </div>
          <div class="form-group">
          <small>Floor no</small>
          <select form="editUnitForm" id="floor_no" name="floor_no" class="form-control">
              <option value="{{ $unit->floor_no }}" readonly selected class="bg-primary">{{ $unit->floor_no }}</option>
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
              <input form="editUnitForm" type="text" value="{{ $unit->building }}" name="building" class="form-control"> 
            </div>
          <div class="form-group">
          <small>Room Type</small>
          <select form="editUnitForm" id="type_of_units" name="type_of_units" class="form-control">
              <option value="{{ $unit->type_of_units }}" readonly selected class="bg-primary">{{ $unit->type_of_units }}</option>
              <option value="commercial">commercial</option>
              <option value="residential">residential</option>
          </select>
          </div>
      
          <div class="form-group">
            <small>Max Occupancy</small>
            <input  oninput="this.value = Math.abs(this.value)" form="editUnitForm" type="number" value="{{ $unit->max_occupancy }}" name="max_occupancy" class="form-control"> 
          </div>
          <div class="form-group">
          <small> Status</small>
          <select form="editUnitForm" id="status" name="status" class="form-control">
              <option value="{{ $unit->status }}" readonly selected class="bg-primary">{{ $unit->status }}</option>
              <option value="vacant">vacant</option>
              <option value="occupied">occupied</option>
              
              <option value="reserved">reserved</option>
          </select>
          </div>
          <div class="form-group">
              <small>Monthly Rent</small>
              <input form="editUnitForm"  oninput="this.value = Math.abs(this.value)" step="0.01" type="number" value="{{ $unit->monthly_rent }}" name="monthly_rent" class="form-control">
              </div>
     
      </form>
      </div>
      <div class="modal-footer">
     
      <button type="submit" form="editUnitForm" class="btn btn-primary" this.disabled = true;><i class="fas fa-check fa-sm text-white-50"></i> Save Changes</button>  
      </div>
  </div>
  </div>
</div>

{{-- Modal to add investor --}}
<div class="modal fade" id="addInvestor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Owner</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <form id="addInvestorForm" action="/units" method="POST">
          {{ csrf_field() }}
      </form>
      <div class="modal-body">
          <input form="addInvestorForm" type="hidden" value="{{ $unit->unit_id }}" name="unit_id">
        

          <div class="form-group">
          <small>Name</small>
          <input form="addInvestorForm" type="text"  value="{{ $unit->unit_owner }}" class="form-control" name="unit_owner" id="unit_owner" required>
          </div>
          <div class="form-group">
              <small>Email</small>
              <input form="addInvestorForm" type="email" class="form-control" name="investor_email_address" id="investor_email_address" required>
          </div>
          <div class="form-group">
              <small>Mobile</small>
              <input form="addInvestorForm" type="text" class="form-control" name="investor_contact_no" id="contact_no">
          </div>            
      </div>
      <div class="modal-footer">
      {{-- <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button> --}}
      <button type="submit" form="addInvestorForm" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>  
      </div>
  </div>
  </div>
</div>

{{-- Modal to enroll leasing to unit owner --}}
<div class="modal fade" id="enrollLeasing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Enter Leasing Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <form id="enrollLeasingForm" action="/units/{{$unit->unit_id }}" method="POST">
      @method('put')
      {{ csrf_field() }}

      <input form="enrollLeasingForm" type="hidden" value="enroll_leasing" name="action">
  </form>
    <div class="modal-body">
      <div class="form-group">
        <small>Date of Enrollment Starts</small>
        <input form="enrollLeasingForm" type="date"  class="form-control" name="date_enrolled" required>
        </div>
        <div class="form-group">
        <small>Contract Starts</small>
        <input form="enrollLeasingForm" type="date"  class="form-control" name="contract_start" required>
        </div>
        <div class="form-group">
            <small>Contract Ends</small>
            <input form="enrollLeasingForm" type="date" class="form-control" name="contract_end" required>
        </div>
        <div class="form-group">
          <small>Occupancy</small>
          <input form="enrollLeasingForm" type="number" class="form-control" name="max_occupancy" required >
      </div>   
        <div class="form-group">
            <small>Monthly Rent</small>
            <input form="enrollLeasingForm" type="number" step="0.01" class="form-control" name="monthly_rent" required >
        </div>            
    </div>
    <div class="modal-footer">
    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button>
    <button type="submit" form="enrollLeasingForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Enroll Now</button>  
    </div>
</div>
</div>
</div>


         {{-- Modal for warning message --}}
         <div class="modal fade" id="warningTenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body">
                 <p class="text-center">
                      You can't add tenant. The room is fully occupied.
                      <br>
                      <small class="text-danger">
                        You may increase the number of max occupancy to allow more tenants.
                      </small>
                 </p>
              </div>
              
          </div>
          </div>
</div>

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
          <form id="concernForm" action="/concerns" method="POST">
              {{ csrf_field() }}
          </form>

          {{-- <input type="hidden" form="concernForm" id="tenant_id" name="tenant_id" value="{{ $tenant->tenant_id }}"required> --}}
          <input type="hidden" form="concernForm" id="unit_tenant_id" name="unit_tenant_id" value="{{ $unit->unit_id }}"required>

          <div class="row">
            <div class="col">
                <small>Date Reported</small>
                <input type="date" form="concernForm" class="form-control" name="date_reported" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
            </div>
        </div>
        <br>
          <div class="row">
            <div class="col">
                <small>Reported By</small>
                <select class="form-control" form="concernForm" name="reported_by" id="" required>
                  <option value="">Please select one</option>
                  @foreach ($tenant_active as $item)
                  <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} (tenant)</option>
                  @endforeach
                 
                </select>
            </div>
        </div>
        <br>
          <div class="row">
              <div class="col">
                 <small>Type of Concern</small>
                  <select class="form-control" form="concernForm" name="concern_type" id="" required>
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
               <small>Urgency</small>
                <select class="form-control" form="concernForm" name="concern_urgency" id="" required>
                  <option value="" selected>Please select one</option>
                  <option value="minor">minor</option>
                  <option value="major">major</option>
                  <option value="urgent">urgent</option>
                </select>
            </div>
        </div>
        <br>
       
      <div class="row">
        <div class="col">
            <small>Short Description</small>
            <small class="text-danger">(What is your concern all about?)</small>
            <input type="text" form="concernForm" class="form-control" name="concern_item" required >
        </div>
      </div>  
      <br>
      
       <div class="row">
            <div class="col">
                <small>Details of the concern</small>
                
                <textarea form="concernForm" rows="7" class="form-control" name="concern_desc" required></textarea>
            </div>
        </div>
        <br>
        
      </div>
      <div class="modal-footer">

          <button type="submit" form="concernForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
      </div>
  </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection



