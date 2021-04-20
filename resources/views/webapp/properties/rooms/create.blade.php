@extends('layouts.argon.dashboard')

@section('title', 'Step 2 of 5 | The Property Manager')

@section('title-page')
<div class="row">
  <div class="col-md-9">
    <h2 class="text-left"><i class="fas fa-building"></i> Buildings and rooms</h2>
  </div>
  <div class="col">
    <h3 class="text-right">Step 2 of 5</h3>
  </div>
</div>
@endsection

@section('content')
<form id="addPayableEntryForm" method="POST" action="/property/{{ Session::get('property_id') }}/rooms/store">
  @csrf
  <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
  <div class="row">
    <div class="col">
       <p class="text-right">
        <a href="#/"  id="add_entry" class="btn btn-primary"><i class="fas fa-plus"></i> Add more building </a>   
        <a  href="#/" id='delete_entry' class="btn btn-danger"><i class="fas fa-minus"></i> Remove current building </a>
      
       </p>
           
        <div class="modal-body">
            <form class="user" form="addPayableEntryForm" method="POST" action="/property/{{ Session::get('property_id') }}/rooms/store">
              @csrf
           </form>
     
        
                 <div class="table-responsive">
                 <table class = "table table-hover" id="tab_logic">    
                   <thead>
                     <tr>
                       <th>#</th>
                       <th>Building name</th>
                       <th># of rooms</th>
                       <th>Room Size (square meter)</th>
                     </thead>
                   </tr>
                       <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry" >
    
                      
                   <tr id='addr1'></tr>
                 
                 </table>
               </div>
             
    
          </div>
    </div>
</div>
  <br>

  <div class="row">
    {{-- <div class="col">
      <p class="text-left">
        <a href="/property/all" class="btn btn-primary"><i class="fas fa-home"></i> Home</a>
      </p>
     </div> --}}

     <div class="col">
      <p class="text-right">
        <button type="submit" form="addPayableEntryForm" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Next</button>
      </p>
     </div>
   </div>
 
            
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
           var i=1;

       $("#add_entry").click(function(){

           $('#addr'+i).html("<th>"+ (i) +"</th><td><input class='form-control' form='addPayableEntryForm' name='building"+i+"' type='text' required></td><td><input class='form-control' form='addPayableEntryForm' name='no_of_room"+i+"' type='number' min='1' required></td><td><input class='form-control' form='addPayableEntryForm' name='size"+i+"' min='1' step='0.001' type='number' required></td>");
   
   
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

