@extends('layouts.argon.main')

@section('title', $home->building.' '.$home->unit_no)

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
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left"> 
      <h6 class="h2 text-dark d-inline-block mb-0"> {{ $home->building.' '.$home->unit_no }}</h6>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="nav-room" aria-selected="true"><i class="fas fa-home text-indigo"></i> Room</a>
          @if($tenants->count()<=0)
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users text-green"></i> Tenants <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users text-green"></i> Tenants <span class="badge badge-success badge-counter">{{ $tenants->count() }}</span></a>
          @endif
         
          @if($owners->count()<=0)
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie text-teal"></i> Owners <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie text-teal"></i> Owners <span class="badge badge-success badge-counter">{{ $owners->count() }}</span></a>
          @endif

          @if($remittances->count()<=0)
          <a class="nav-item nav-link" id="nav-remittances-tab" data-toggle="tab" href="#remittances" role="tab" aria-controls="nav-remittances" aria-selected="false"><i class="fas fa-hand-holding-usd text-teal"></i> Remittances <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-remittances-tab" data-toggle="tab" href="#remittances" role="tab" aria-controls="nav-remittances" aria-selected="false"><i class="fas fa-hand-holding-usd text-teal"></i> Remittances <span class="badge badge-success badge-counter">{{ $remittances->count() }}</span></a>
          @endif

          @if($expenses->count()<=0)
          <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="nav-expenses" aria-selected="false"><i class="fas fa-file-export text-danger"></i> Expenses <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="nav-expenses" aria-selected="false"><i class="fas fa-file-export text-danger"></i> Expenses <span class="badge badge-success badge-counter">{{ $expenses->count() }}</span></a>
          @endif

          @if($pending_concerns->count()>0)
          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-cyan"></i> Concerns <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-cyan"></i> Concerns <span class="badge badge-success badge-counter">{{ $concerns->count() }}</span></a>
          @endif
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
            <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a> 
            {{-- <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button>  --}}
          </p>
          <div class="row">
          <div class="col-md-6 mx-auto">
            <div class="card">
              {{-- <div class="card-header">
                Room Information
              </div> --}}
              <div class="card-body">
                
                <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
                <div class="table-responsive text-left">
              <table class="table table-hover table-borderless">
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
                      <td>{{ number_format($home->rent,2) }}/mo</td>
                  </tr>
                   </thead>
                   <thead>
                    <tr>
                      <th>Created on</th> 
                      <td>{{ Carbon\Carbon::parse($home->created_at)->format('M d, Y') }} </td>
                  </tr>
                   </thead>
                   <thead>
                    <tr>
                      <th>Last updated on</th> 
                      <td>{{ Carbon\Carbon::parse($home->updated_at)->format('M d, Y') }} </td>
                  </tr>
                   </thead>
                
               </table>
              </div>
              </div>
            </div>
          </div>
          {{-- <div class="col-md-6">

          </div> --}}
        </div>
       
        </div>
        <div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="nav-expenses-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            @if($expenses->count() <=0)
            <br>
            <p class="text-danger text-center">No expenses found!</p>
            @else
            <p>Total expenses deducted to remittance: {{ number_format($expenses->sum('expense_amt'), 2) }}</p>
            <table class="table table-hover">
              <thead>
                  <?php $ctr=1;?>
                  <tr>
                      <th>#</th>
                      <th>Date deducted</th>
                      {{-- <th>Period Covered</th> --}}
                      <th>Particular</th>
                      <th>Amount</th>
                  </tr>    
              </thead>
              <tbody>
                  @foreach ($expenses as $item)
                  <tr>
                      <th>{{ $ctr++ }}</th>     
                      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                      {{-- <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td> --}}
                      <td>{{ $item->expense_particular }}</td>
                      <th>{{ number_format($item->expense_amt,2) }}</th>
                     
                  </tr>   
                  @endforeach
                
              </tbody>
          </table>
          @endif
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="remittances" role="tabpanel" aria-labelledby="nav-remittances-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            @if($remittances->count() <=0)
            <br>
            <p class="text-danger text-center">No remittances found!</p>
            @else
            <p>Total remitted amount: {{ number_format($remittances->sum('amt_remitted'), 2) }}</p>
            <table class="table table-hover">
              <thead>
                  <?php $ctr=1;?>
                  <tr>
                      <th>#</th>
                      <th>Date Prepared</th>
                      <th>Period Covered</th>
                      <th>Particular</th>
                      <th>CV</th>
                      <th>Check #</th>
                   
                      <th>Status</th>
                      <th>Amount</th>
          
                  </tr>    
              </thead>
              <tbody>
                  @foreach ($remittances as $item)
                  <tr>
                      <th>{{ $ctr++ }}</th>     
                      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                      
                      <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td>
                      <td>{{ $item->particular }}</td>
                      <td>{{ $item->cv_number }}</td>
                      <td>{{ $item->check_number }}</td>
                      
                     <td>
                      @if($item->remitted_at === NULL)
                      <span class="badge badge-danger">pending</span>
                      @else
                      <span class="badge badge-success">remitted</span>
                      @endif
                     </td>
                      <th><a href="/property/{{ Session::get('property_id') }}/remittance/{{ $item->remittance_id }}/expenses">{{ number_format($item->amt_remitted,2) }}</a></th>
                  </tr>   
                  @endforeach
              </tbody>
          </table>
          @endif
           
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="tenants" role="tabpanel" aria-labelledby="nav-tenants-tab">
          @if($tenants->count() > 0)
            <p class="text-left">
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/tenant" class="btn btn-primary"><i class="fas fa-plus"></i> New</a> 
              {{-- <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button>  --}}
            </p>
            @endif
            <div class="table-responsive text-nowrap">
              <table class="table table-hover">
                @if($tenants->count() <= 0)
                <tr>
                    <br><br>
                    <p class="text-center">
                      <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/tenant" class="btn btn-primary"><i class="fas fa-plus"></i> Add a tenant</a> 
                    </p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Movein</th>   
                    <th>Moveout</th>
                    <th>Room</th>
                    <th>Term</th>
                    <th>Status</th>
                    <th>Rent</th>
                    <th>Source</th>
                </tr>
              </thead>
                <?php $ctr = 1; ?>   
            @foreach ($tenants as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
                    <td>{{ $item->unit_no }}</td>
                    <td>{{ $item->contract_term }}</td>
                    <td>{{ $item->contract_status }}</td>
                    {{-- <td title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->moveout_date), false) }} days left">{{ Carbon\Carbon::parse($item->movein_at)->format('M d Y').'-'.Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</> --}}
                      <td>{{ number_format($item->contract_rent, 2) }}</td>
                      <td>{{ $item->form_of_interaction }}</td>
                    </tr>
            @endforeach
                @endif                        
            </table>
              </div>
       
        </div>
  
        <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">
          @if($concerns->count() > 0)
          <p class="text-left">
            <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/concern" class="btn btn-primary"><i class="fas fa-plus"></i> New</a> 
            {{-- <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button>  --}}
          </p>
          @endif
          {{-- <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus"></i> New</a>  
          <br><br> --}}
          <div class="col-md-12 mx-auto">
          <div class="table-responsive">
        
            @if($concerns->count()<=-0)
            <br><br>
            <p class="text-center">
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/concern" class="btn btn-primary"><i class="fas fa-plus"></i> Report a concern</a>   
            </p>
          
            @else
            <table class="table table-hover" >
            <thead>
            <tr>
              <?php $ctr=1; ?>
               <th>#</th>
               
                 <th>Date Reported</th>
                
               
    
            
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
            @endif
  
            </div>
        </div>
        </div>
        
        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
          @if($owners->count() > 0)
          <p class="text-left">
            <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/owner" class="btn btn-primary"><i class="fas fa-plus"></i> New</a> 
            {{-- <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button>  --}}
          </p>
          @endif
    
  

          @if($owners->count()<=-0)
          <br><br>
          <p class="text-center">
            <a href="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id }}/create/owner" class="btn btn-primary"><i class="fas fa-plus"></i> Add an owner</a>   
          </p>
          @else
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
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
          @endif
         
        
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Room</h5>
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
              <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
            <div class="form-group">
            <label>Floor</label>
            <select form="editUnitForm" id="floor" name="floor" class="form-control">
              <option value="{{ $home->unit_floor_id_foreign }}">{{ $numberFormatter->format($home->unit_floor_id_foreign) }} floor</option>
                @foreach ($room_floors as $item)
                @if($item->unit_floor>=0)
                  <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format($item->unit_floor) }} floor</option>
                @else
                  <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format(intval($item->unit_floor)*-1) }} basement</option>
                @endif
              @endforeach  
            </select>
            </div>
            <div class="form-group">
                <label>Building <small>(Optional)</small></label>
                <input form="editUnitForm" type="text" value="{{ $home->building }}" name="building" class="form-control"> 
              </div>
            <div class="form-group">
            <label>Type</label>
            <select form="editUnitForm" id="type" name="type" class="form-control">
                <option value="{{ $home->unit_type_id_foreign }}" readonly selected class="bg-primary">{{ $home->unit_type_id_foreign }}</option>
                @foreach ($room_types as $item)
                <option value="{{ $item->unit_type_id }}">{{ $item->unit_type }}</option>
                  @endforeach
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
            <div class="form-group">
                <label>Enrollment Date</label>
                <input form="editUnitForm" type="date" value="{{ Carbon\Carbon::parse($home->created_at)->format('Y-m-d') }}" name="created_at" class="form-control">
            </div>
      
        </div>
        <div class="modal-footer">
        <button type="submit" form="editUnitForm" class="btn btn-primary btn-sm" this.disabled = true;><i class="fas fa-check"></i> Update</button>  
        </div>
    </div>
    </div>
  </div>

                     {{-- Modal for renewing tenant --}}
                     <div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
                      <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">New Concern</h5>
                  
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
                                  <label>Summary</label>
                                
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
                                        <option value="{{ $item->id }}"> {{ $item->role_id_foreign }}</option>
                                    @endforeach   
                                  </select>
                              </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            
                              <button type="submit" form="concernForm" class="btn btn-primary btn" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
                          </div>
                      </div>
                      </div>
                  </div>

                  <div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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


   
@endsection



