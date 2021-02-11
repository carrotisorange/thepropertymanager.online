@extends('layouts.argon.main')

@section('title', 'Personnels')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Personnels</h6>
    
  </div>
  <div class="col-lg-6 col-5 text-right">
    <a href="#" data-toggle="modal" data-target="#addPersonnelModal" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
  </div>


</div>
@if($personnels->count() <=0 )
<p class="text-danger text-center">No personnels found!</p>

@else

  
<div class="table-responsive text-nowrap">
     
  <table class="table">
    <thead>
      <?php $ctr=1;?>
      <tr>
          <th>#</th>
          <th>Name</th>
          <th>Mobile NO</th>
          <th>Role</th>
          <th>Added On</th>
          <th></th>
     </tr>
    </thead>
    <tbody>
    @foreach ($personnels as $item)
    <tr>
      <th>{{ $ctr++ }}</th>
        <td>{{ $item->personnel_name }}</td>
        <td>{{ $item->personnel_contact_no }}</td>
       
        <td>{{ $item->personnel_type }}</td>
        <td>{{ $item->created_at }}</td>
        <td class="text-center">
          @if(Auth::user()->user_type === 'manager')
          <form action="/property/{{Session::get('property_id')}}/personnel/{{ $item->personnel_id }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
          </form>
          @endif
        </td>
    </tr>
      @endforeach
    </tbody>
  </table>
  
</div>
@endif

   {{-- Modal to moveout tenant --}}
   <div class="modal fade" id="addPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Personnel</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="addPersonnelForm" action="/property/{{Session::get('property_id')}}/personnel" method="POST">
            @csrf
            </form>
            <input type="hidden" form="addPersonnelForm" name="property_id" value="{{Session::get('property_id')}}" required>
           <div class="row">
             <div class="col">
              <label>Name</label>
              <input type="text" form="addPersonnelForm" class="form-control" name="personnel_name" required >
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col">
               <label>Mobile</label>
               <input form="addPersonnelForm" type="number" class="form-control" name="personnel_contact_no" required>
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col">
               <label>Role</label>
               <select class="form-control" form="addPersonnelForm" name="personnel_type" id="" required>
                 <option value="" selected>Please select one</option>
                 <option value="housekeeping">housekeeping</option>
                 <option value="maintenance">maintenance</option>
               </select>
             </div>
           </div>
         
     
    </div>
    <div class="modal-footer">
            
      <p class="text-right"> <button type="submit" form="addPersonnelForm" class="btn btn-primary"> Add</button></p>
   </div>
    </div>
</div>
</div>

@endsection



@section('scripts')
  
@endsection



