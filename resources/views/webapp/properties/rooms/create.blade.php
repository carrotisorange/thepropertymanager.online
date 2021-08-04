@extends('layouts.argon.dashboard')

@section('title', 'Step 2 of 5 | The Property Manager')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
<form id="addPayableEntryForm" method="POST" action="/property/{{ Session::get('property_id') }}/rooms/store">
  @csrf
  <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
  <div class="row">
    <div class="col">
       <p class="text-right">
        <a href="#/"  id="add_entry" class="btn btn-primary"><i class="fas fa-plus"></i> Add a building </a>   
        <a  href="#/" id='delete_entry' class="btn btn-danger"><i class="fas fa-minus"></i> Remove current building </a>
       </p>  
        <div class="modal-body">
        
                 <div class="table">
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
  <div class="row">
     <div class="col">
        <button type="submit" form="addPayableEntryForm" class="btn btn-primary btn-block"><i class="fas fa-arrow-right"></i> Continue</button>
        <br>
        <p class="text-center">   <a href="/property/all">Skip for now</a></p>
     </div>
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

