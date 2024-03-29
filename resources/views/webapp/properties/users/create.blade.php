@extends('layouts.argon.dashboard')

@section('title', 'Step 4 of 4 | The Property Manager')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
  <form id="addPayableEntryForm" method="POST" action="/property/{{ Session::get('property_id') }}/users/store">
    @csrf
    <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
    <div class="row">
      <div class="col">
        <p class="text-right">
          <a href="#/" id="add_entry" class="btn-sm btn-primary"><i class="fas fa-plus"></i> Add </a>
          <a href="#/" id='delete_entry' class="btn-sm btn-danger"><i class="fas fa-minus"></i> Remove </a>

        </p>

        <div class="modal-body">
          <form class="user" form="addPayableEntryForm" method="POST"
            action="/property/{{ Session::get('property_id') }}/users/store">
            @csrf
          </form>


          <div class="table-responsive">
            <table class="table table-hover" id="tab_logic">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
              </thead>
              </tr>
              <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry">


              <tr id='addr1'></tr>

            </table>
          </div>


        </div>
      </div>
    </div>

    <div class="row">

      <div class="col">
        <p class="text-right">
          <button id="savebutton" form="addPayableEntryForm" type="submit" class="btn btn-primary btn-block"><i
              class="fas fa-check"></i> Finish</button>

          <p class="text-center"><a href="/property/all">Skip for now</a></p>
        </p>
        {{-- <button id="savebutton" type="submit" class="btn btn-primary btn-user btn-block"><i class="fas fa-arrow-right" onclick="this.form.submit(); this.disabled = true;"></i> Save users (<span id="current_no_of_entry">0</span>)</button> --}}
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){
           var i=1;

       $("#add_entry").click(function(){

           $('#addr'+i).html("<th>"+ (i) +"</th><td><input class='' form='addPayableEntryForm' name='name"+i+"' type='text' required></td><td><input class='' form='addPayableEntryForm' name='email"+i+"' type='email' required></td><td><select class='' form='addPayableEntryForm' name='role"+i+"' id='role"+i+"' required><option value=''>Please select a role</option>@foreach($roles as $item)<option value='{{ $item->role_id }}'>{{ $item->role.' '.$item->privileges }}</option>@endforeach</select></td>");
   
   
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++;

        
        document.getElementById('no_of_entry').value = i;
        document.getElementById("current_no_of_entry").innerHTML = (i-1);
   
       });
   
       $("#delete_entry").click(function(){
           if(i>1){
           $("#addr"+(i-1)).html('');
           i--;
           document.getElementById('no_of_entry').value = i;
           document.getElementById("current_no_of_entry").innerHTML = i-1;
           }
       });
   });
</script>
@endsection