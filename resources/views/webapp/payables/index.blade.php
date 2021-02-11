@extends('layouts.argon.main')

@section('title', 'Payables')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Payables</h6>
    
  </div>

  <div class="col text-right">
    @if(auth()->user()->user_type === 'ap' || auth()->user()->user_type === 'manager' )
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addEntry" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Entry</a>
    @endif
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#requestPayable" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Request</a>
  
  </div>

</div>
<div class="row">
  <div class="col">
    <h3>Entries</h3>

    <div class="table-responsive text-nowrap">
      <table class="table table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Particular</th>
            <th>Created</th>
           
          </tr>
        </thead>
        <tbody>
          <?php $ctr = 1; ?>
          @foreach ($entry as $item)
             <tr>
              <th>{{ $ctr++ }}</th>
              <td>{{ $item->entry }}</td>
              <td>{{ $item->description }}</td>
              <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
               {{-- <td class="text-right"> 
                @if(auth()->user()->user_type === 'ap' || auth()->user()->user_type === 'manager')
               <form action="/account-payable/{{ $item->id }}/" method="POST">
                  @csrf
                  @method('delete')
                  <button title="remove this entry" type="submit" class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                </form> 
                @endif
               </td>--}}
         
             </tr>
          @endforeach
        </tbody>
      </table>
      {{ $entry->links() }}
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col">
    <h3>Requests</h3>
    
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
                   
                    <td>{{ $item->entry }}</td>
                    <td>{{ number_format($item->amt, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>    
                   
                    @if(Auth::user()->user_type === 'manager')
                    <td class="text-right"> 
                      
                      <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/decline" method="POST">
                      @csrf
                      <button title="decline" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="this.form.submit(); this.disabled = true;">Decline</button>
                    </form>
                 

                  </td> 
                  <td class="text-left">
                    <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/approve" method="POST">
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
                    
                    <td>{{ $item->entry }}</td>
                    <td>{{ number_format($item->amt, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($item->requested_at)->format('M d Y') }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pb_note? $item->pb_note: '-' }}</td>        
                    <td>{{ Carbon\Carbon::parse($item->updated_at)->format('M d Y') }}</td>     
                    @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap')
                    <td class="text-center"> 
                      <form action="/property/{{Session::get('property_id')}}/payable/{{ $item->pb_id }}/release" method="POST">
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
            <table class="table">
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
   
        <form id="addPayableEntryForm" action="/property/{{Session::get('property_id')}}/payable" method="POST">
          @csrf
       </form>
 
        
           <p class="text-right">
             <a  href="#/" id='delete_entry' class="btn btn-danger"> Remove </a>
           <a href="#/"  id="add_entry" class="btn btn-primary"> Add </a>     
           </p>
             <div class="table-responsive text-nowrap">
             <table class = "table" id="tab_logic">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Entry</th>
                   <th>Particular</th>
                   <th>Date</th>
                 </thead>
               </tr>
                   <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry" >

                   <input form="addPayableEntryForm" type="hidden" id="" name="property_id"  value="{{Session::get('property_id')}}">
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
        <form id="requestFundsForm" action="/property/{{Session::get('property_id')}}/payable/request" method="POST">
          @csrf
       </form>
            <p class="text-right">
              <a href="#/" id='delete_request' class="btn btn-danger"> Remove </a>
              <a href="#/" id="add_request" class="btn btn-primary"> Add </a>     
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

                      <input form="requestFundsForm" type="hidden" id="" name="property_id"  value="{{Session::get('property_id')}}">
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
             $('#request'+j).html("<th>"+ (j) +"</th><td><input form='requestFundsForm' name='requested_at"+j+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}'></td><td><select form='requestFundsForm' name='entry"+j+"' required><option>Please select entry</option>@foreach($entry as $item)<option value='{{ $item->id }}'>{{ $item->entry }}</option> @endforeach</select></td><td><input form='requestFundsForm' name='amt"+j+"' type='number' step='0.001' required></td><td><input form='requestFundsForm' name='note"+i+"' type='text'></td>");
     
     
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



