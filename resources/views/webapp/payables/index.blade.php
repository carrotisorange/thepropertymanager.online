@extends('layouts.argon.main')

@section('title', 'Payables')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Payables</h6>
    
  </div>

  <div class="col text-right">
    @if(auth()->user()->user_type === 'ap' || auth()->user()->user_type === 'manager' )
    <a href="/property/{{ Session::get('property_id') }}/payables/entries" class="btn btn-primary shadow-sm btn-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new entry</a>
    @endif
    <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#requestPayable" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add new payable request</a>
  
  </div>

</div>

<div class="row">
  <div class="col">
    
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="nav-all" aria-selected="true">  <i class="fas fa-file-export text-indigo"></i> All <span class="badge badge-primary badge-counter">{{ $all->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="nav-pending" aria-selected="false"><i class="fas fa-clock text-warning"></i> Pending <span class="badge badge-primary badge-counter">{{ $pending->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="nav-approved" aria-selected="false"><i class="fas fa-check text-success"></i> Approved <span class="badge badge-primary badge-counter">{{ $approved->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#released" role="tab" aria-controls="nav-released" aria-selected="false"><i class="fas fa-clipboard-check text-success"></i> Released <span class="badge badge-primary badge-counter">{{ $released->count() }}</span></a>
          <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#declined" role="tab" aria-controls="nav-declined" aria-selected="false"><i class="fas fa-times text-danger"></i> Declined <span class="badge badge-primary badge-counter">{{ $declined->count() }}</span></a>
        </div>
      </nav>
      <br>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade  show active" id="all" role="tabpanel" aria-labelledby="nav-all-tab">
          <div class="table-responsive text-nowrap">
            <table class="table table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
              <thead>
              
                <tr>
                  <th class="text-center">#</th>
             
                  <th>Entry</th>
                  <th>Amount</th>
                  <th>Requested</th>
                  <th>Requester</th>
                  <th>Note</th>
                  <td>Status</td>
                  @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                  <th colspan="2" class="text-center">Actions</th>
                  @endif
                
                  {{-- <th colspan="2" class="text-center">Action</th> --}}
                  
                </tr>
              </thead>
              <tbody>
               
                @foreach ($all as $item)
                   <tr>
                     <th class="text-center">{{ $ctr++ }}</th>
                   
                    <td>{{ $item->entry }}</td>
                    <td>{{ number_format($item->amt, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>    
                   <td>
                    @if($item->payable_status == 'pending')
                    <a title="waiting to be processed" class="btn btn-danger btn-sm" href="#/"><i class="fas fa-clock"></i></a>
                    @elseif($item->payable_status == 'approved')
                    <a title="request approved" class="btn btn-success btn-sm" href="#/"><i class="fas fa-check"></i></a>
                    
                    @elseif($item->payable_status == 'released')

                    <a title="request released" class="btn btn-success btn-sm" href="#/"><i class="fas fa-clipboard-check"></i></a>
                    @elseif($item->payable_status == 'declined')

                    <a title="request declined" class="btn btn-danger btn-sm" href="#/"><i class="fas fa-times"></i></a>
                    @endif
                   </td>
                   @if($item->payable_status == 'pending')
                      @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                      
                      <td class="text-right"> 
                        
                        <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/decline" method="POST">
                        @csrf
                        <button title="decline this payable request" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-times"></i></button>
                      </form>
                    

                    </td> 
                    <td class="text-left">
                      <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/approve" method="POST">
                        @csrf
              
                        <button title="approve this payable request" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i></button>
                      </form>
                    </td> 
                      
                    
                    @endif 
                   @elseif($item->payable_status == 'approved')
                 
                   <td class="text-right"> 
                        
                    <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/release" method="POST">
                    @csrf
                    <button title="release approved funds" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-clipboard-check"></i></button>
                  </form>
                

                </td> 
           

                   @endif
                    <td></td>
                   <td></td>
                   
                   </tr>
                @endforeach
              </tbody>
            </table>
            </div>
        </div>

        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="nav-pending-tab">
          <div class="table-responsive text-nowrap">
            <table class="table table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
              <thead>
              
                <tr>
                  <th class="text-center">#</th>
             
                  <th>Entry</th>
                  <th>Amount</th>
                  <th>Requested</th>
                  <th>Requester</th>
                  <th>Note</th>
                  @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                  <th colspan="2" class="text-center">Actions</th>
                  @endif
                
                  {{-- <th colspan="2" class="text-center">Action</th> --}}
                  
                </tr>
              </thead>
              <tbody>
               
                @foreach ($pending as $item)
                   <tr>
                     <th class="text-center">{{ $ctr++ }}</th>
                   
                    <td>{{ $item->entry }}</td>
                    <td>{{ number_format($item->amt, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>    
                   
                    @if($item->payable_status == 'pending')
                    @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                    <td class="text-right"> 
                      
                      <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/decline" method="POST">
                      @csrf
                      <button title="decline this payable request" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-times"></i></button>
                    </form>
                 
 
                  </td> 
                  <td class="text-left">
                    <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/approve" method="POST">
                      @csrf
            
                      <button title="approve this payable request" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i></button>
                    </form>
                  </td> 
                   
                  
                  @endif 
                    @else
                  <td></td>
                  <td></td>
 
                    @endif
                   
                   </tr>
                @endforeach
              </tbody>
            </table>
            </div>
        </div>
       
        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="nav-approved-tab">
          <div class="table-responsive text-nowrap">
            <table class="table table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
             <thead>
              <tr>
                <th class="text-center">#</th>
               
                  <th>Entry</th>
                  <th>Amount</th>
                  <th>Requested</th>
                  <th>Requester</th>
                  <th>Note</th>
                  <th>Aprroved</th>
                  
                  @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                  <th>Action</th>
                  @endif
                </tr>
             </thead>
              </thead>
              <tbody>
               
                @foreach ($approved as $item)
                   <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    
                    <td>{{ $item->entry }}</td>
                    <td>{{ number_format($item->amt, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>        
                    <td>{{ Carbon\Carbon::parse($item->updated_at)->format('M d Y') }}</td>     
                    @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap'|| Auth::user()->user_type === 'admin')
                    <td class="text-center"> 
                      <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/release" method="POST">
                      @csrf
                      <button title="release the requested funds" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i></button>
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
            <table class="table table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
             <thead>
              <tr>
                <th class="text-center">#</th>
            
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
            <table class="table table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
             <thead>
              <tr>
                <th class="text-center">#</th>
             
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


<div class="modal fade" id="requestPayable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Request payable</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <form id="requestFundsForm" action="/property/{{Session::get('property_id')}}/payable/request" method="POST">
          @csrf
       </form>
           
       <a href="#/" id='delete_request' class="btn btn-danger btn-sm"><i class="fas fa-minus"></i> Remove current row</a>
              <a href="#/" id="add_request" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add new row</a>  
      
              <button form="requestFundsForm" type="submit" class="btn btn-success btn-sm" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Request funds (<span id="current_no_of_entry"></span>)</button>   
        <br><br>
              <div class="table-responsive text-nowrap">
                <table class = "table table-condensed table-border" id="request_table">
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

                      <input form="requestFundsForm" type="hidden" id="" name="property_id"  value="{{Session::get('property_id')}}">
                  <tr id='request1'></tr>
              </table>
            </div>

      </div>

  </div>
  </div>
</div>

@endsection



@section('scripts')
<script>
  $(document).ready(function(){

     var j=1;
         
         $("#add_request").click(function(){
             $('#request'+j).html("<th>"+ (j) +"</th><td><input form='requestFundsForm' name='requested_at"+j+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}'></td><td><select form='requestFundsForm' name='entry"+j+"' required><option>Please select entry</option>@foreach($entry as $item)<option value='{{ $item->id }}'>{{ $item->entry }}</option> @endforeach</select></td><td><input form='requestFundsForm' id='amt"+j+"' name='amt"+j+"' type='number' step='0.001' required></td><td><input form='requestFundsForm' name='note"+j+"' type='text'></td>");
     
     
          $('#request_table').append('<tr id="request'+(j+1)+'"></tr>');
          j++;
          
          document.getElementById('no_of_request').value = j;
          document.getElementById("current_no_of_entry").innerHTML = (j-1);
     
         });
     
         $("#delete_request").click(function(){
             if(j>1){
             $("#request"+(j-1)).html('');
             j--;
             
             document.getElementById('no_of_request').value = j;
             document.getElementById("current_no_of_entry").innerHTML = j-1;
             }
         });
   
 });
</script>
@endsection



