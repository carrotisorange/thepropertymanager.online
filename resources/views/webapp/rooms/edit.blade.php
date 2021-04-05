@extends('layouts.argon.main')

@section('title', 'Edit Rooms')

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
 
      <div class="row" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          <form id="editUnitsForm" action="/property/{{Session::get('property_id')}}/rooms/update" method="POST">
  
              @csrf
              @method('PUT')

          </form>
          <table class="table table-condensed table-bordered table-hover">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Building</th>
                      <th>Room</th>
                      <th>Size <small>(sqm)</small></th>
                      <th>Floor No</th>
                      <th>Room type</th>
                      <th>Status</th>
                      <th>Occupancy</th>
                      <th>Rent<small>(/mo)</small></th>
                      <th>Term</th>
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
                      $occupancy =1;
                      $rent = 1;
                      $size = 1;
                      $term =1;
                  ?>
                  @foreach ($units as $item)
              
                      <tr>
                          <th> {{ $ctr++ }}</th>
                          <td><input form="editUnitsForm" type="text" name="building{{ $building++  }}" id="" value="{{ $item->building }}"></td>
                          <td>
                            <input form="editUnitsForm" type="text" name="unit_no{{ $unit_no++  }}" id="" value="{{ $item->unit_no }}">
                            <input form="editUnitsForm" type="hidden" name="unit_id{{ $unit_id++  }}" id="" value="{{ $item->unit_id }}">
                          </td>
                          <td><input form="editUnitsForm" type="text" name="size{{ $size++  }}" id="" value="{{ $item->size }}"></td>
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
                            <select form="editUnitsForm" type="text" name="type{{ $type++  }}">
                              <option value="{{ $item->type }}" readonly selected class="bg-primary">{{ $item->type }}</option>
                              <option value="commercial">commercial</option>
                              <option value="residential">residential</option>
                          </select>
                           
                          </td>
                          <td>
                            <select form="editUnitsForm" type="text" name="status{{ $status++  }}" id="" >
                              <option value="{{ $item->status }}" readonly selected class="bg-primary">{{ $item->status }}</option>
                              <option value="dirty">dirty</option>
                              <option value="vacant">vacant</option>
                              <option value="occupied">occupied</option>
                              
                              <option value="reserved">reserved</option>
                          </select>
                          
                          </td>
                        
                       
                          <td><input form="editUnitsForm" type="number" name="occupancy{{ $occupancy++  }}" id="" min="0" value="{{ $item->occupancy }}"></td>
                          <td><input form="editUnitsForm" type="number" step="0.001" name="rent{{ $rent++  }}"  min="0" id="" value="{{$item->rent }}"></td>
                          <td>
                            <select form="editUnitsForm" type="text" name="term{{ $term++  }}" id="" >
                              <option value="{{ $item->term }}" readonly selected class="bg-primary">{{ $item->term }}</option>
                              <option value="lt">lt</option>
                              <option value="st">st</option>
                          </select>
                          
                          </td>
                          <td>
                           @if($item->status === 'deleted')
                           <form action="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/restore" method="POST">
                            @csrf
                            @method('put')
                            
                            <button title="restore this room" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-restore fa-sm text-dark-50"></i></button>
                          </form> 
                           @else
                           <form action="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/delete" method="POST">
                            @csrf
                            @method('delete')
                            
                            <button title="archive this room" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-dark-50"></i></button>
                          </form> 
                           @endif
                          </td>
                      </tr>
                 
                  @endforeach
              </tbody>
            
        </table>
         </div>
         <br>
         @if($units->count() <=0 )

         @else
        <p class="text-right">
                <button type="submit" form="editUnitsForm" class="btn btn-success btn-sm"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Update rooms</button>
            </p>
         @endif
  
</div>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



