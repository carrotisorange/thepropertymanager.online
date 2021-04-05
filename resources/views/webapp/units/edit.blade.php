@extends('layouts.argon.main')

@section('title', 'Edit Units')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/rooms/">{{ Session::get('property_name')}}</a></li>
     
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
    </nav>
    
    
  </div>
 {{-- <div class="col">
  <div class="alert alert-danger alert-dismissable custom-danger-box">
                  
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   
        <strong><i class="fas fa-info-circle"></i> Scroll the bar from left to right to see the delete/restore button. </strong>
      
    
</div>
 </div> --}}
</div>
<div class="row">

  <!-- Content Column -->
  <div class="col-lg-12 mb-4">
    <!-- DataTales Example -->

      {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">LOGINS HISTORY </h6>
        <div class="dropdown no-arrow">
          <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
          </a> 
           <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink"> --}}
            {{-- <div class="dropdown-header">Dropdown Header:</div> --}}
            {{-- <a class="dropdown-item" target="_blank" href="/logins">See All</a> --}}
            {{-- <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a> --}}
          {{-- </div> 
        </div>
      </div> --}}
 
      <div class="table-responsive">
          <form id="editUnitsForm" action="/property/{{Session::get('property_id') }}/units/{{ Carbon\Carbon::now()->getTimestamp()}}/update" method="POST">
  
              @csrf
              @method('PUT')

          </form>
          <table class="table table-condensed table-hover table-bordered">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Building</th>
                      <th>Unit</th>
                      <th>Floor</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody> 
                  <?php 
                      $ctr = 1;
                      $unit_id = 1;
                      $unit_no = 1;
                      $type = 1;
                      $status =1;
                      $building =1;
                      $floor = 1;
                  ?>
                  @foreach ($units as $item)
                      <tr>
                          <th> {{ $ctr++ }}</th>
                            <td><input form="editUnitsForm" type="text" name="building{{ $building++  }}" id="" value="{{ $item->building }}"></td>
                          <td>
                            <input col-md-12" form="editUnitsForm" type="text" name="unit_no{{ $unit_no++  }}" id="" value="{{ $item->unit_no }}">
                            <input form="editUnitsForm" type="hidden" name="unit_id{{ $unit_id++  }}" id="" value="{{ $item->unit_id }}">
                          </td>
                          <td>
                            <select form="editUnitsForm" type="number" name="floor{{ $floor++ }}">
                              <option value="{{ $item->floor }}" readonly selected class="bg-primary">{{ $item->floor }}</option>
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
                           
                          </td>
                          <td>
                            <select class="" form="editUnitsForm" type="text" name="type{{ $type++  }}">
                              <option value="{{ $item->type }}" readonly selected class="bg-primary">{{ $item->type }}</option>
                              <option value="commercial">commercial</option>
                              <option value="residential">residential</option>
                          </select>
                           
                          </td>
                          <td>
                            <select form="editUnitsForm" type="text" name="status{{ $status++  }}" id="" >
                              <option value="{{ $item->status }}" readonly selected class="bg-primary">{{ $item->status }}</option>
                              <option value="reserved">accepted</option>
                              <option value="occupied">occupied</option>
                              <option value="vacant">vacant</option>
                              
                             
                          </select>
                          
                          </td>    
                          <td>
                            <form action="/property/{{Session::get('property_id') }}/unit/{{ $item->unit_id }}" method="POST">
                              @csrf
                              @method('delete')
                              
                              <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                            </form> 
                          </td>
                      </tr>
                  @endforeach
              </tbody>
            
        </table>
         </div>
         <hr>
         @if($units->count() <=0 )

         @else
        <p class="text-right">
                <button type="submit" form="editUnitsForm" class="btn btn-primary btn-sm"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Update</button>
            </p>
         @endif
  
</div>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



