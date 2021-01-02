@extends('layouts.argon.main')

@section('title', 'Payables')

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
              <a class="nav-link active" href="/property/{{$property->property_id }}/payables">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Payables</h6>
    
  </div>

  <div class="col text-right">
    @if(auth()->user()->user_type === 'ap' || auth()->user()->user_type === 'manager' )
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addEntry" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Entry</a>
    @endif
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#requestPayable" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Payable</a>
  
  </div>

</div>
<div class="row">
  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-entries-tab" data-toggle="tab" href="#entries" role="tab" aria-controls="nav-entries" aria-selected="true"><i class="fas fa-sticky-note fa-sm text-primary-50"></i> Entries</a>
        <a class="nav-item nav-link" id="nav-payables-tab" data-toggle="tab" href="#payables" role="tab" aria-controls="nav-payables" aria-selected="false"><i class="fas fa-hand-holding-usd fa-sm text-primary-50"></i> Payables</a>
        <a class="nav-item nav-link" id="nav-expense-report-tab" data-toggle="tab" href="#expense-report" role="tab" aria-controls="nav-expense-report" aria-selected="false"><i class="fas fa-chart-bar fa-sm text-primary-50"></i> Expense Report</a>
      </div>
    </nav>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="entries" role="tabpanel" aria-labelledby="nav-home-tab">
     
        
        <div class="col-md-12 mx-auto">
        <br>
          <div class="table-responsive text-nowrap">
            <table class="table table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Created</th>
                  <th class="text-center" colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $ctr = 1; ?>
                @foreach ($entry as $item)
                   <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <td>{{ $item->entry }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    <td class="text-right"> 
                      @if(auth()->user()->user_type === 'ap' || auth()->user()->user_type === 'manager')
                      {{-- <form action="/account-payable/{{ $item->id }}/" method="POST">
                        @csrf
                        @method('delete')
                        <button title="remove this entry" type="submit" class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                      </form> --}}
                      @endif
                     </td>
                     <td class="text-left">
                      {{-- <form action="">
                        @csrf
                        <button class="btn btn-primary" type="submit" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-edit fa-sm text-white-50"></i></button>
                      </form> --}}
                     </td>
                   </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="expense-report" role="tabpanel" aria-labelledby="nav-expense-report-tab">
        <br>
        <div class="table-responsive text-nowrap">
          <table class="table">
            @foreach ($expense_report as $day => $list)
           <thead>
            <tr>
              <th colspan="12">{{ $day }} ({{ $list->count() }})</th>
          </tr>
          <?php $ctr=1;?>
        
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">No</th>
            <th>Entry</th>
            
            <th>Requested</th>
            <th>Requester</th>
            <th>Note</th>
            <th>Released</th>
            <th class="text-right">Amount</th>
            {{-- @if(Auth::user()->user_type === 'manager')
            <th colspan="2" class="text-center">Action</th>
            @endif --}}
          </tr>
           
           </thead>
         
              @foreach ($list as $item)
            
              <tr>
               <th class="text-center">{{ $ctr++ }}</th>
               <td class="text-center">{{ $item->no }}</td>
               <td>{{ $item->entry }}</td>
              
               <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
               <td>{{ $item->name }}</td>
               <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>       
               <td>{{ Carbon\Carbon::parse($item->updated_at)->format('M d Y') }}</td>    
               <td class="text-right">{{ number_format($item->amt, 2) }}</td> 
               {{-- @if(Auth::user()->user_type === 'manager')
               <td class="text-center"> 
                 <form action="/" method="POST">
                 @csrf
                 <button title="release" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check-circle fa-sm text-white-50"></i></button>
               </form>
             @endif --}}
              
              </tr>
           @endforeach
       
                  <tr>
                    <th>Total</th>
                    <th colspan="7" class="text-right">{{ number_format($list->sum('amt'),2) }}</th>
                  </tr>
                
            @endforeach
        </table>
         
          </div>
      </div>

      <div class="tab-pane fade" id="payables" role="tabpanel" aria-labelledby="nav-payables-tab">
      
        <div class="col-md-12 mx-auto">
          <br>
       
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="nav-pending" aria-selected="true"><i class="fas fa-clock fa-sm text-primary-50"></i> Pending <span class="badge badge-primary badge-counter">{{ $pending->count() }}</span></a>
              <a class="nav-item nav-link" id="nav-approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="nav-approved" aria-selected="false"><i class="fas fa-check-circle fa-sm text-primary-50"></i> Approved</a>
              <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#released" role="tab" aria-controls="nav-released" aria-selected="false"><i class="fas fa-clipboard-check fa-sm text-primary-50"></i> Released</a>
              <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#declined" role="tab" aria-controls="nav-declined" aria-selected="false"><i class="fas fa-times-circle fa-sm text-primary-50"></i> Declined</a>
            </div>
          </nav>
          <br>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="nav-pending-tab">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <?php $ctr=1;?>
                  <thead>
                  
                    <tr>
                      <th class="text-center">#</th>
                      <th>No</th>
                      <th>Entry</th>
                      <th>Amount</th>
                      <th>Requested</th>
                      <th>Requester</th>
                      <th>Note</th>
                      @if(Auth::user()->user_type === 'manager')
                      <th colspan="2" class="text-center"></th>
                      @endif
                    
                      {{-- <th colspan="2" class="text-center">Action</th> --}}
                      
                    </tr>
                  </thead>
                  <tbody>
                   
                    @foreach ($pending as $item)
                       <tr>
                         <th class="text-center">{{ $ctr++ }}</th>
                        <td class="text-center">{{ $item->no }}</td>
                        <td>{{ $item->entry }}</td>
                        <td>{{ number_format($item->amt, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>    
                       
                        @if(Auth::user()->user_type === 'manager')
                        <td class="text-right"> 
                          
                          <form action="/property/{{ $property->property_id }}/payable/{{ $item->id }}/decline" method="POST">
                          @csrf
                          <button title="decline" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="this.form.submit(); this.disabled = true;">Decline</button>
                        </form>
                     
 
                      </td> 
                      <td class="text-left">
                        <form action="/property/{{ $property->property_id }}/payable/{{ $item->id }}/approve" method="POST">
                          @csrf
                
                          <button title="approve" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;">Approve</button>
                        </form>
                      </td> 
                       
                      
                      @endif
                        
                       
                       </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>
            </div>
           
            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="nav-approved-tab">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <?php $ctr=1;?>
                 <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No</th>
                      <th>Entry</th>
                      <th>Amount</th>
                      <th>Requested</th>
                      <th>Requester</th>
                      <th>Note</th>
                      <th>Aprroved</th>
                      
                      @if(Auth::user()->user_type === 'manager')
                      <th colspan="2" class="text-center"></th>
                      @endif
                    </tr>
                 </thead>
                  </thead>
                  <tbody>
                   
                    @foreach ($approved as $item)
                       <tr>
                        <th class="text-center">{{ $ctr++ }}</th>
                        <td class="text-center">{{ $item->no }}</td>
                        <td>{{ $item->entry }}</td>
                        <td>{{ number_format($item->amt, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>        
                        <td>{{ Carbon\Carbon::parse($item->updated_at)->format('M d Y') }}</td>     
                        @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap')
                        <td class="text-center"> 
                          <form action="/property/{{ $property->property_id }}/payable/{{ $item->id }}/release" method="POST">
                          @csrf
                          <button title="release" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;">Release</button>
                        </form>
                      @endif
                       
                       </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>
            </div>
            <div class="tab-pane fade" id="released" role="tabpanel" aria-labelledby="nav-released-tab">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <?php $ctr=1;?>
                 <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No</th>
                      <th>Entry</th>
                      <th>Amount</th>
                      <th>Requested</th>
                      <th>Requester</th>
                      <th>Note</th>
                      <th>Released</th>
                      
                      {{-- @if(Auth::user()->user_type === 'manager')
                      <th colspan="2" class="text-center">Action</th>
                      @endif --}}
                    </tr>
                 </thead>
                  </thead>
                  <tbody>
                   
                    @foreach ($released as $item)
                       <tr>
                        <th class="text-center">{{ $ctr++ }}</th>
                        <td class="text-center">{{ $item->no }}</td>
                        <td>{{ $item->entry }}</td>
                        <td>{{ number_format($item->amt, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>        
                        <td>{{ Carbon\Carbon::parse($item->released_at)->format('M d Y') }}</td>     
                        {{-- @if(Auth::user()->user_type === 'manager')
                        <td class="text-center"> 
                          <form action="/" method="POST">
                          @csrf
                          <button title="release" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check-circle fa-sm text-white-50"></i></button>
                        </form>
                      @endif --}}
                       
                       </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>
            </div>
            <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="nav-declined-tab">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <?php $ctr=1;?>
                 <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No</th>
                      <th>Entry</th>
                      <th>Amount</th>
                      <th>Requested</th>
                      <th>Requester</th>
                      <th>Note</th>
                      <th>Declined</th>
                    </tr>
                 </thead>
                  </thead>
                  <tbody>
                   
                    @foreach ($declined as $item)
                       <tr>
                        <th class="text-center">{{ $ctr++ }}</th>
                        <td class="text-center">{{ $item->no }}</td>
                        <td>{{ $item->entry }}</td>
                        <td>{{ number_format($item->amt, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                         <td>{{ $item->name }}</td>
                        <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>     
                        <td>{{ Carbon\Carbon::parse($item->declined_at)->format('M d Y') }}</td>            
                       </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Add entry</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
   
        <form id="addPayableEntryForm" action="/property/{{ $property->property_id }}/payable" method="POST">
          @csrf
       </form>
 
        
           <p class="text-right">
             <a  href="#/" id='delete_entry' class="btn btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove </a>
           <a href="#/"  id="add_entry" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add </a>     
           </p>
             <div class="table-responsive text-nowrap">
             <table class = "table" id="tab_logic">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Entry</th>
                   <th>Description</th>
                   <th>Date</th>
                 </thead>
               </tr>
                   <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry" >

                   <input form="addPayableEntryForm" type="hidden" id="" name="property_id"  value="{{ $property->property_id }}">
               <tr id='addr1'></tr>
             
             </table>
           </div>
         

      </div>
      <div class="modal-footer">

          <button form="addPayableEntryForm" type="submit" class="btn btn-primary btn-user btn-block" onclick="this.form.submit(); this.disabled = true;"> Add</button>
          </div>
  </div>
  </div>
</div>


<div class="modal fade" id="requestPayable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Request payable</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <form id="requestFundsForm" action="/property/{{ $property->property_id }}/payable/request" method="POST">
          @csrf
       </form>
            <p class="text-right">
              <a href="#/" id='delete_request' class="btn btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove </a>
              <a href="#/" id="add_request" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add </a>     
            </p>
              <div class="table-responsive text-nowrap">
                <table class = "table" id="request_table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Entry</th>
                    <th>Amount</th>
                    <th>Note</th>
                    
                </tr>
                </thead>
                      <input form="requestFundsForm" type="hidden" id="no_of_request" name="no_of_request" >

                      <input form="requestFundsForm" type="hidden" id="" name="property_id"  value="{{ $property->property_id }}">
                  <tr id='request1'></tr>
              </table>
            </div>

      </div>
      <div class="modal-footer">
         
          <button form="requestFundsForm" type="submit" class="btn btn-primary btn-user btn-block" onclick="this.form.submit(); this.disabled = true;"> Add</button>
          </div>
  </div>
  </div>
</div>

@endsection



@section('scripts')
<script>
  $(document).ready(function(){
         var i=1;
         
     $("#add_entry").click(function(){
         $('#addr'+i).html("<th>"+ (i) +"</th><td><input form='addPayableEntryForm' name='entry"+i+"' type='text' required></td><td><input form='addPayableEntryForm' name='description"+i+"' type='text' required></td><td><input form='addPayableEntryForm' name='created_at"+i+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}' required></td>");
 
 
      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      i++;
      
      document.getElementById('no_of_entry').value = i;
 
     });
 
     $("#delete_entry").click(function(){
         if(i>1){
         $("#addr"+(i-1)).html('');
         i--;
         
         document.getElementById('no_of_entry').value = i;
         }
     });

     var j=1;
         
         $("#add_request").click(function(){
             $('#request'+j).html("<th>"+ (j) +"</th><td><input form='requestFundsForm' name='requested_at"+j+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}'></td><td><select form='requestFundsForm' name='entry"+j+"' required><option>Please select entry</option>@foreach($entry as $item)<option value='{{ $item->entry }}'>{{ $item->entry }}</option> @endforeach</select></td><td><input form='requestFundsForm' name='amt"+j+"' type='number' step='0.001' required></td><td><input form='requestFundsForm' name='note"+i+"' type='text'></td>");
     
     
          $('#request_table').append('<tr id="request'+(j+1)+'"></tr>');
          j++;
          
          document.getElementById('no_of_request').value = j;
     
         });
     
         $("#delete_request").click(function(){
             if(j>1){
             $("#request"+(j-1)).html('');
             j--;
             
             document.getElementById('no_of_request').value = j;
             }
         });
   
 });
</script>
@endsection



