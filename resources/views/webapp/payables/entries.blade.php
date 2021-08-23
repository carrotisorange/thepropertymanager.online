@extends('layouts.argon.main')

@section('title', 'Entries')

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
  <div class="col-auto text-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/payables/">Payables</a></li>

        <li class="breadcrumb-item active" aria-current="page">Entries</li>
      </ol>
    </nav>


  </div>
</div>

<div class="row">
  <div class="col">
    <a href="#/" id="add_entry" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New </a>
    <a href="#/" id='delete_entry' class="btn btn-danger btn-sm"><i class="fas fa-minus"></i> Remove </a>

    <button id="savebutton" form="addPayableEntryForm" type="submit" class="btn btn-success btn-sm"
      onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>Save (<span
        id="current_no_of_entry"></span>)</button>



    <form id="addPayableEntryForm" action="/property/{{Session::get('property_id')}}/payable" method="POST">
      @csrf
    </form>
    <br>

    <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:300px;">
      <table class="table table-hover" id="tab_logic">
        <thead>
          <tr>
            <th>#</th>
            <th>Entry</th>
            <th>Particular</th>
            <th>Added on</th>
        </thead>
        </tr>
        <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry">

        <input form="addPayableEntryForm" type="hidden" id="" name="property_id"
          value="{{Session::get('property_id')}}">
        <tr id='addr1'></tr>

      </table>
    </div>



  </div>
</div>
<br>
<div class="row">
  <div class="col">
    <h3>Entries</h3>

    <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
      <table class="table table-hover">
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
          @foreach ($entries as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <td>{{ $item->entry }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
            {{-- <td class="text-right"> 
                  @if(auth()->user()->role_id_foreign === 2 || auth()->user()->role_id_foreign === 4)
                 <form action="/account-payable/{{ $item->id }}/" method="POST">
            @csrf
            @method('delete')
            <button title="remove this entry" type="submit" class="btn btn-sm btn-danger"
              onclick="return confirm('Are you sure you want perform this action?');"><i
                class="fas fa-trash fa-sm text-white-50"></i></button>
            </form>
            @endif
            </td>--}}

          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="modal fade" id="addEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add entry</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-footer">

        <button form="addPayableEntryForm" type="submit" class="btn btn-primary btn-user btn-block"
          onclick="this.form.submit(); this.disabled = true;"> Add</button>
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

           $('#addr'+i).html("<th>"+ (i) +"</th><td><input class='form-control' form='addPayableEntryForm' name='entry"+i+"' type='text' required></td><td><input class='form-control' form='addPayableEntryForm' name='description"+i+"' type='text' required></td><td><input class='form-control' form='addPayableEntryForm' name='created_at"+i+"' type='date' value='{{ Carbon\Carbon::now()->format('Y-m-d') }}' required></td>");
   
   
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