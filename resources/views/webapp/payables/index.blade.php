@extends('layouts.argon.main')

@section('title', 'Payables')

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
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Payables</h6>

  </div>

  <div class="col text-right">
    @if(auth()->user()->role_id_foreign === 2 || auth()->user()->role_id_foreign === 4 )
    <a href="/property/{{ Session::get('property_id') }}/payables/entries" class="btn btn-primary shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> New entry</a>
    @endif
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#requestPayable"
      data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> New request</a>

  </div>

</div>

<div class="row">
  <div class="col">

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#all" role="tab"
          aria-controls="nav-all" aria-selected="true"> <i class="fas fa-file-export text-indigo"></i> All <span
            class="badge badge-primary badge-counter">{{ $all->count() }}</span></a>
        <a class="nav-item nav-link" id="nav-pending-tab" data-toggle="tab" href="#pending" role="tab"
          aria-controls="nav-pending" aria-selected="false"><i class="fas fa-clock text-warning"></i> Pending <span
            class="badge badge-primary badge-counter">{{ $pending->count() }}</span></a>
        <a class="nav-item nav-link" id="nav-approved-tab" data-toggle="tab" href="#approved" role="tab"
          aria-controls="nav-approved" aria-selected="false"><i class="fas fa-check text-success"></i> Approved <span
            class="badge badge-primary badge-counter">{{ $approved->count() }}</span></a>
        <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#released" role="tab"
          aria-controls="nav-released" aria-selected="false"><i class="fas fa-clipboard-check text-success"></i>
          Released <span class="badge badge-primary badge-counter">{{ $released->count() }}</span></a>
        <a class="nav-item nav-link" id="nav-declined-tab" data-toggle="tab" href="#declined" role="tab"
          aria-controls="nav-declined" aria-selected="false"><i class="fas fa-times text-danger"></i> Declined <span
            class="badge badge-primary badge-counter">{{ $declined->count() }}</span></a>
      </div>
    </nav>
    <br>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade  show active" id="all" role="tabpanel" aria-labelledby="nav-all-tab">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover">
   
            <thead>

              <tr>
     
                <th>Requested on</th>

                <th>Entry</th>
                <th>Amount</th>

                <th>Requester</th>
                <th>Note</th>
                <th>Status</th>
                @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
                <th>Actions</th>
                @endif

              </tr>
            </thead>
            <tbody>
            @each('webapp.payables.includes.payables', $all, 'payable', 'webapp.tenants.includes.no-record')
            </tbody>
          </table>
        </div>
      </div>

      <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="nav-pending-tab">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover">
      
            <thead>

              <tr>
             
                <th>Requested on</th>
                <th>Entry</th>
                <th>Amount</th>

                <th>Requester</th>
                <th>Note</th>
                @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
                <th>Actions</th>
                @endif

                {{-- <th colspan="2" class="text-center">Action</th> --}}

              </tr>
            </thead>
            <tbody>
              @each('webapp.payables.includes.payables', $pending, 'payable', 'webapp.tenants.includes.no-record')
            </tbody>
          </table>
        </div>
      </div>

      <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="nav-approved-tab">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover">
            <?php $ctr=1;?>
            <thead>
              <tr>
               
                <th>Requested on</th>
                <th>Entry</th>
                <th>Amount</th>

                <th>Requester</th>
                <th>Note</th>
                <th>Aprroved</th>

                @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
                <th>Action</th>
                @endif
              </tr>
            </thead>
            </thead>
            <tbody>
             @each('webapp.payables.includes.payables', $approved, 'payable', 'webapp.tenants.includes.no-record')
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="released" role="tabpanel" aria-labelledby="nav-released-tab">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover">
            <?php $ctr=1;?>
            <thead>
              <tr>
         
                <th>Requested on</th>
                <th>Entry</th>
                <th>Amount</th>
                <th>Requester</th>
                <th>Note</th>
                <th>Released</th>
              </tr>
            </thead>
            </thead>
            <tbody>
            @each('webapp.payables.includes.payables', $released, 'payable', 'webapp.tenants.includes.no-record')
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="nav-declined-tab">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover">
            <?php $ctr=1;?>
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Requested on</th>
                <th>Entry</th>
                <th>Amount</th>

                <th>Requester</th>
                <th>Note</th>
                <th>Declined</th>
              </tr>
            </thead>
            </thead>
            <tbody>
              @each('webapp.payables.includes.payables', $declined, 'payable', 'webapp.tenants.includes.no-record')
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="modal fade" id="requestPayable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New request</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="requestFundsForm" action="/property/{{Session::get('property_id')}}/payable/request" method="POST">
          @csrf
        </form>

        <a href="#/" id='delete_request' class="btn btn-danger"><i class="fas fa-minus"></i> Remove</a>
        <a href="#/" id="add_request" class="btn btn-primary"><i class="fas fa-plus"></i> New</a>

        <button form="requestFundsForm" type="submit" class="btn btn-success"
          onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>Submit (<span
            id="current_no_of_entry"></span>)</button>
        <br><br>
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <table class="table table-hover" id="request_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Entry</th>
                <th>Amount</th>
                <th>Note</th>

              </tr>
            </thead>
            <input form="requestFundsForm" type="hidden" id="no_of_request" name="no_of_request">

            <input form="requestFundsForm" type="hidden" id="" name="property_id"
              value="{{Session::get('property_id')}}">
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
             $('#request'+j).html("<th>"+ (j) +"</th><td><input class='form-control' form='requestFundsForm' name='requested_at"+j+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}'></td><td><select class='form-control' form='requestFundsForm' name='entry"+j+"' required><option>Please select entry</option>@foreach($entry as $item)<option value='{{ $item->id }}'>{{ $item->entry.' | '.$item->description }}</option> @endforeach</select></td><td><input class='form-control' form='requestFundsForm' id='amt"+j+"' name='amt"+j+"' type='number' step='0.001' required></td><td><input class='form-control' form='requestFundsForm' name='note"+j+"' type='text'></td>");
     
     
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