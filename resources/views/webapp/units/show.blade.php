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
{{-- <div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{  $home->building.' '.$home->unit_no }}</h6>
    
  </div>
</div> --}}
<br>
  <div class="row">
    <div class="col-md-12">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-unit-tab" data-toggle="tab" href="#unit" role="tab" aria-controls="nav-unit" aria-selected="true"><i class="fas fa-home text-indigo"></i>  Unit</a>
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#occupants" role="tab" aria-controls="nav-occupants" aria-selected="false"><i class="fas fa-users text-green"></i> Occupants</a>
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie text-teal"></i> Owners</a>
          @if($bills->count() <= 0)
         <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-invoice-dollar text-pink"></i> Bills </a>
         @else
         <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-invoice-dollar text-pink"></i> Bills <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> {{ $bills->count() }}</span></a>
         @endif

         <a class="nav-item nav-link" id="nav-payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="nav-payments" aria-selected="false"><i class="fas fa-coins text-yellow"></i> Payments </a>

          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-cyan"></i> Concerns </a>
        </div>
      </nav>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content" id="nav-tabContent">
     
        <div class="tab-pane fade show active" id="unit" role="tabpanel" aria-labelledby="nav-unit-tab">
    
          <button type="button" title="edit unit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUnit" data-whatever="@mdo"><i class="fas fa-edit"></i> Edit</button> 
    
          <div class="col-md-12 mx-auto">
           
          <br>
            <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
            <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover">
           <tr>
                    <th>Building</th>
                    <td>{{ $home->building }}</td>
               </tr>
               <tr>
                    <th>Unit</th>
                    <td>{{ $home->unit_no }}</td>
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
             
               
              </tr>
              <tr>
                    <th>Status</th>
                    <td>
                          @if($home->status === 'occupied')
                          <span class="badge badge-primary">{{ $home->status }}</span>
                          @elseif($home->status === 'reserved')
                              <span class="badge badge-warning">{{ $home->status}} </span>
                          @else
                              <span class="badge badge-success">{{ $home->status }}</span>
                          @endif
                    </td>
                </tr>
                
            
           </table>
          </div>
          </div>
        </div>
  
        <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
          <a href="#" data-toggle="modal" data-target="#addBill" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New</a> 
          @if(Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/bills/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
            @endif
            @if($bills->count() > 0)
            <a  target="_blank" href="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/bills/export" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> Export</span></a>
            {{-- @if($tenant->email_address !== null)
            <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/send" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</span></a>
            @endif --}}
            @endif
          
        
  
      <br>
      <br>
      <div class="col-md-12 mx-auto">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
          <table class="table table-hover table-bordered">  
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
                {{Carbon\Carbon::parse($item->date_posted)->format('M d Y')}}
              </td>   
               
  
                <td>{{ $item->bill_no }}</td>
        
                <td>{{ $item->particular }}</td>
              
                <td>
                  {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                  {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                </td>
                <td class="text-right"  >{{ number_format($item->amount,2) }}</td>
                <td class="text-right"  >{{ number_format($item->amt_paid,2) }}</td>
                <td class="text-right" >
                  @if($item->bills > 0)
                  <span class="text-danger">{{ number_format($item->balance,2) }}</span>
                  @else
                  <span >{{ number_format($item->balance,2) }}</span>
                  @endif
                </td>
                {{-- <td class="text-center">
                  @if(Auth::user()->role_id_foreign === 4)
                  <form action="/property/{{Session::get('property_id')}}/tenant/{{ $item->bill_tenant_id }}/bill/{{ $item->billing_id }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
                  </form>
                  @endif
                </td> --}}
                       </tr>
                       
            @endforeach
            <tr>
              <th>TOTAL </th>
              
              <th class="text-right" colspan="5">{{ number_format($bills->sum('amount'),2) }} </th>
              <th class="text-right" colspan="">{{ number_format($bills->sum('amt_paid'),2) }} </th>
              <th class="text-right text-danger" colspan="">
                @if($bills->sum('bills') > 0)
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
        <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="nav-payments-tab">
          @if(Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
          <a href="#" data-toggle="modal" data-target="#acceptPayment" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New</a>
          @endif 
          <br><br>
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            <table class="table table-hover">
              {{-- @foreach ($payments as $day => $collection_list) --}}
               <thead>
                  {{-- <tr>
                      <th colspan="10">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $collection_list->count() }})</th>
                      
                  </tr> --}}
                  <tr>
                    <?php $ctr = 1; ?>
                      <th class="text-center">#</th>
                      <th>AR No</th>
                      <th>Bill No</th>
                      <th>Occupant</th>  
                      <th>Particular</th>
                      <th colspan="2">Period Covered</th>
                      <th>Form</th>
                      <th class="text-right">Amount</th>
                     <th></th>
                     {{-- <th colspan="2">Action</th> --}}
                       {{-- <th></th> --}}
                      </tr>
                </tr>
               </thead>
                @foreach ($payments as $item)
               
                <tr>
                      <th class="text-center">{{ $ctr++ }}</th>
                        <td>{{ $item->ar_no }}</td>
                        <td>{{ $item->payment_bill_no }}</td>
                          <td>{{ $item->first_name.' '.$item->last_name }}</td> 
                         <td>{{ $item->particular }}</td> 
                         <td colspan="2">
                          {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                          {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                        </td>
                        <td>{{ $item->form }}</td>
                        <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
                        {{-- <td class="text-center">
                          @if(Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4)
                           <form action="/property/{{$property->property_id}}/home/{{ $item->unit_id }}/payment/{{ $item->payment_id }}" method="POST">
                             @csrf
                             @method('delete')
                             <button title="delete" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                           </form>
                           @endif
                         </td>   
                         <td class="text-center">
                           <a title="export" target="_blank" href="/property/{{Session::get('property_id')}}/home/{{ $item->bill_unit_id }}/payment/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a>
  
         
       </td>    --}}
       <td>
        <a title="export" target="_blank" href="/property/{{ Session::get('property_id') }}/unit/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/payment/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export_unit_bills" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a>
       </td>
                       
                    {{-- </tr>
                @endforeach
                    <tr>
                      <th>TOTAL</th>
                      <th colspan="7" class="text-right">{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
                    </tr> --}}
                    
              @endforeach
          </table>
          </div>
        </div>
        </div>
  
        <div class="tab-pane fade" id="occupants" role="tabpanel" aria-labelledby="nav-occupants-tab">

          @if(Session::get('property_ownership') === 'Multiple Owners'))
            @if($owners->count() <= 0)
            <a href="#" data-toggle="modal" data-target="#modalToAddOwner" class="btn btn-primary btn-sm"> <i class="fas fa-user-plus"></i> New </a>
            @else
            <a href="#" data-toggle="modal" data-target="#addOccupant" class="btn btn-primary btn-sm"> <i class="fas fa-user-plus"></i> New</a>   
            @endif
          @else
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/occupant/add"  type="button" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> New</a>   
          @endif


          
 
          <br><br>
          <div class="col-md-12 mx-auto">
             <div class="table-responsive" style="overflow-y:scroll;overflow-x:scroll;">
              <table class="table table-table-bordered table-hover">
                <?php $occupanct_ctr=1;?>
                 <thead>
                   <tr>
                     <th>#</th>
                     <th>Name</th>
                     <th>Mobile</th>
                     {{-- <th>Email</th> --}}
                     <th>Resided on</th>
           
                   </tr>
                 </thead>
                 <tbody>
               
                  @foreach ($occupants as $item)
                  <tr>
                  <th>{{ $occupanct_ctr++ }}</th>
                  <th><a href="/property/{{ Session::get('property_id') }}/occupant/{{ $item->tenant_id }}/">{{ $item->first_name.' '.$item->middle_name.' '.$item->last_name }}</a></th>
                  <td>{{ $item->contact_no }}</td>
                  {{-- <td>{{ $item->email_address }}</td> --}}
                   <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>

                  </tr>
              @endforeach
                
                 </tbody>
               </table>
             </div>
       
  
        </div>
        </div>
        <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">
          <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> New</a>  
          <br><br>
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
  
            <table class="table table-table-bordered table-hover">
            <thead>
              <?php $concern_ctr = 1; ?>
            <tr>
               <th>#</th>
               
                 <th>Date Reported</th>
                
                      
                 @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
                 <th>Unit</th>
                 @else
                 <th>Room</th>
                 @endif
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
              <th>{{ $concern_ctr++ }}</th>
           
              <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                
                <td>{{ $item->unit_no }}</td>
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
                    @if($item->concern_status === 'pending')
                    <span class="badge badge-warning">{{ $item->concern_status }}</span>
                    @elseif($item->status === 'active')
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
        
        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
        
     <a  data-toggle="modal" data-target="#addInvestor" data-whatever="@mdo" type="button" class="btn btn-primary btn-sm text-white">
      <i class="fas fa-user-plus text-white-50"></i> New
    </a>   
  <br>
     <br>
        <div class="col-md-12 mx-auto">

          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            <table class="table table-table-bordered table-hover">
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
                     <td><a href="/property/{{Session::get('property_id')}}/owner/{{ $item->owner_id }}">{{ $item->name }} </a></td>
              
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
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="editUnitForm" action="/property/{{ Session::get('property_id') }}/unit/{{ $home->unit_id }}" method="POST">
            @method('put')
            @csrf
        </form>
        <div class="modal-body">
        <form>
            <div class="form-group">
            <label>Unit</label>
            <input form="editUnitForm" type="text" value="{{ $home->unit_no }}" name="unit_no" class="form-control" id="unit_no" >
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
                <label>Building</label>
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
              <label>Occupancy</label>
              <input  oninput="this.value = Math.abs(this.value)" form="editUnitForm" type="number" value="{{ $home->occupancy }}" name="occupancy" class="form-control"> 
            </div>
            <div class="form-group">
            <label> Status</label>
            <select form="editUnitForm" id="status" name="status" class="form-control">
                <option value="{{ $home->status }}" readonly selected class="bg-primary">{{ $home->status }}</option>
                <option value="vacant">vacant</option>
                <option value="occupied">occupied</option>
                <option value="reserved">reserved</option>
            </select>
            </div>
       
        </form>
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
                                  <small>Reported By</small>
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
                                <label>Summary</label>
                              
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
                                  <select class="form-control" form="concernForm" name="concern_user_id">
                                    <option value="" selected>Please select one</option>
                                    @foreach($users as $item)
                                        <option value="{{ $item->id }}"> {{ $item->role_id_foreign }}</option>
                                    @endforeach   
                                  </select>
                              </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                              
                              <button type="submit" form="concernForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add</button>
                          </div>
                      </div>
                      </div>
                  </div>
  @include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')
  @include('webapp.tenants.show_includes.owners.create')

  <div class="modal fade" id="addOccupant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select your option</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
           <p class="text-center">
               Would you like to add the owner as the occupant?
                <br>
           </p>
        </div>
         <div class="modal-footer">
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/occupant"  type="button" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i>  No</a>
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/occupant/prefilled"  type="button" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Yes</a>
          </div>
        
    </div>
    </div>
</div>

<div class="modal fade" id="modalToAddOwner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel"> Warning </h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
         <p class="text-center">
             An owner is required before an occupant can be added.
              <br>
         </p>
      </div>
       <div class="modal-footer">
        
        <a  data-toggle="modal" data-target="#addInvestor" id="addOwnerForm" data-whatever="@mdo" type="button" class="btn btn-primary text-white">Add Now</a>
        </div>
      
  </div>
  </div>
</div>


<div class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="modal">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">New Bill</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
    <form id="addBillForm" action="/property/{{Session::get('property_id')}}/unit/{{ $home->unit_id }}/bills/create" method="POST">
       @csrf
    </form>

    
    <div class="row">
      <div class="col-md-3">
         <label>Date</label> 
          {{-- <input type="date" form="addBillForm" class="form-control" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required > --}}
          <input class="form-control" type="date" form="addBillForm" class="" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
      </div>
      <div class="col">
        <p class="text-right">
          <span id='delete_bill' class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Remove</span>
        <span id="add_bill" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New</span>     
        </p>
      </div>
    </div>
   
    <br>
    <div class="row">
      <div class="col">
  
          <div class="table-responsive text-nowrap">
          <table class = "table table-hover" id="table_bill">
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
   <button form="addBillForm" type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check"></i> Submit</button>
  </div> 
  </div>
  </div>
  
  </div>

  
<div class="modal fade" id="acceptPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="acceptPaymentForm" action="/property/{{Session::get('property_id')}}/home/{{ $home->unit_id }}/collection" method="POST">
          @csrf
          </form>
          
          <div class="row">
              <div class="col-md-3">
                  <label for="">Date</label>
              {{-- <input form="acceptPaymentForm" type="date" class="form-control" name="payment_created" value={{date('Y-m-d')}} required> --}}
              <input type="date" form="acceptPaymentForm" class="form-control" name="payment_created" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
              </div>
              <div class="col">
                  <p class="text-right">
                      <a href="#/" id='delete_payment' class="btn btn-danger btn-sm"><i class="fas fa-minus"></i> Remove</a>
                    <a href="#/" id="add_payment" class="btn btn-primary btn-sm" ><i class="fas fa-plus"></i>  New</a>     
                    </p>
              </div>
              
            
          </div>
        
  <br>
          <div class="row">
            <div class="col">
                <div class="table-responsive text-nowrap">
                <table class = "table table-hover" id="payment">
                   <thead>
                      <tr>
                          <th>#</th>
                          <th>Bill</th>
                          
                          <th>Mode of payment</th>
                          <th>Amount</th>
                          <th>Bank Name</th>
                          <th>Cheque No</th>
                      </tr>
                   </thead>
                        <input form="acceptPaymentForm" type="hidden" id="no_of_payments" name="no_of_payments" >
                    <tr id='payment1'></tr>
                </table>
              </div>
            </div>
          </div>        
        
      </div>
      <div class="modal-footer">
          <button form="acceptPaymentForm" id ="addPaymentButton" type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check"></i> Submit</button>
      </div>
  
  </div>
  </div>
  
  
  </div>
@endsection

@section('scripts')
  <script>
    $("#addOwnerForm").on("click", function(){
    $("#modalToAddOwner").modal("hide");
    $("#modalToAddOwner").on("hidden.bs.modal",function(){
    $("#addInvestor").modal("show");
    });
});
  </script>

  <script>
  //adding moveout charges upon moveout
    $(document).ready(function(){
    var k=1;
    $("#add_bill").click(function(){
      $('#bill'+k).html("<th>"+ (k) +"</th><td><select class='form-control' name='particular"+k+"' form='addBillForm' id='particular"+k+"' required><option value='' selected>Please select one</option>@foreach($property_bills as $item)<option value='{{$item->particular_id}}'>{{ $item->particular }}</option>@endforeach</select> <td><input class='form-control' form='addBillForm' name='start"+k+"' id='start"+k+"' type='date' required></td><td><input class='form-control' form='addBillForm' name='end"+k+"' id='end"+k+"' type='date' required></td> <td><input class='form-control' form='addBillForm' name='amount"+k+"' id='amount"+k+"' type='number' min='1' step='0.01' required></td>");
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
<script type="text/javascript">

  //adding moveout charges upon moveout
    $(document).ready(function(){
    var j=1;
    $("#add_payment").click(function(){
        $('#payment'+j).html("<th>"+ (j) +"</th><td><select class='form-control' form='acceptPaymentForm' name='bill_no"+j+"' id='bill_no"+j+"' required><option >Please select bill</option> @foreach ($bills as $item)<option value='{{ $item->bill_no.'-'.$item->bill_id }}'> Bill No {{ $item->bill_no }} | {{ $item->particular }} | {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }} | {{ number_format($item->balance,2) }} </option> @endforeach </select></td><td><select class='form-control' form='acceptPaymentForm' name='form"+j+"' required><option value='Cash'>Cash</option><option value='Bank Deposit'>Bank Deposit</option><option value='Cheque'>Cheque</option><option value='Credit memo'>Credit memo</option></select></td><td><input class='form-control' form='acceptPaymentForm' name='amt_paid"+j+"' id='amt_paid"+j+"' type='number' step='0.01' required></td><td>  <input class='form-control' form='acceptPaymentForm' type='text' name='bank_name"+j+"'></td><td><input class='form-control' form='acceptPaymentForm' type='text' name='cheque_no"+j+"'></td>");
  
  
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
@endsection



