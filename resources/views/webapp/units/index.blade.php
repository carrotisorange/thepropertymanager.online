@extends('layouts.argon.main')

@section('title', 'Units')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-3">
    <h6 class="h2 text-dark d-inline-block mb-0"></h6>
    
  </div>

  <div class="col-lg-6 text-center">
    <a href="#" class="btn btn-danger"><i class="fas fa-home"></i> Vacant ({{ $units_vacant }})</a>
    <a href="#" class="btn btn-success"><i class="fas fa-home"></i> Occupied ({{ $units_occupied }})</a>
   
  </div>

  <div class="col-md-3 text-right">
    <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
    <a href="/property/{{Session::get('property_id')}}/units/{{ Carbon\Carbon::now()->getTimestamp() }}/edit" class="btn btn-primary" ><i class="fas fa-edit fa-sm text-white-50"></i> Edit</a>
  </div>

 
</div>
@if($units->count() <=0 )
<p class="text-danger text-center">No units found!</p>
@else


  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="unit-tab" data-toggle="tab" href="#all" role="tab" aria-controls="unit" aria-selected="true">{{ Session::get('property_name') }} <span id="count_rooms" class="badge badge-primary">{{ $units_count }}</span></a>
      @foreach ($buildings as $building)
      <a class="nav-item nav-link" id="{{ $building->building }}-tab" data-toggle="tab" href="#{{ $building->building }}" role="tab" aria-controls="{{ $building->building }}" aria-selected="false">{{ $building->building }} <span id="count_rooms" class="badge badge-primary">{{ $building->count }}</a>
      @endforeach
    </div>
  </nav>

<div class="tab-content" id="">
  <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
  <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="unit-tab">
    <br>
  
@foreach ($units as $floor_no => $floor_no_list)
<p class="text-center">
@if($floor_no >= 1)
{{ $numberFormatter->format($floor_no).' floor  ('.$floor_no_list->count().')' }}
@else
  @if($floor_no >= -1)
  {{ '1st basement ('.$floor_no_list->count().')' }} 
  @elseif($floor_no >= -2)
  {{ '2nd basement ('.$floor_no_list->count().')' }} 
  @elseif($floor_no >= -3)
  {{ '3rd basement ('.$floor_no_list->count().')' }} 
  @elseif($floor_no >= -4)
  {{ '4th basement ('.$floor_no_list->count().')' }} 
  @elseif($floor_no >= -5)
  {{ '5th basement ('.$floor_no_list->count().')' }} 
  @endif
@endif

</p>

@foreach ($floor_no_list as $item)
@if($item->status === 'vacant' || $item->status=== 'accepted')
<a title="{{ $item->type_of_units }}" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-danger">
    <i class="fas fa-home fa-3x"></i>
    <br>
    {{ $item->unit_no }}
</a>

@elseif($item->status=== 'occupied')
  <a title="{{ $item->type_of_units }}" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-success">
    <i class="fas fa-home fa-3x"></i>
    <br>
    {{ $item->unit_no }}
    </a>
@endif 
@endforeach
<hr>
@endforeach

  </div>
   @foreach ($buildings as $building)
    <div class="tab-pane fade show" id="{{ $building->building }}" role="tabpanel" aria-labelledby="{{ $building->building }}-tab">
      <br>
  
      @foreach ($units as $floor_no => $floor_no_list)
      <p class="text-center">
      @if($floor_no >= 1)
      {{ $numberFormatter->format($floor_no).' floor' }}
      @else
      @if($floor_no >= -1)
        {{ '1st basement' }} 
        @elseif($floor_no >= -2)
       {{ '2nd basement' }} 
        @elseif($floor_no >= -3)
        {{ '3rd basement' }} 
        @elseif($floor_no >= -4)
        {{ '4th basement' }} 
        @elseif($floor_no >= -5)
        {{ '5th basement' }} 
        @endif
      @endif
      
      </p>
    
      @foreach ($floor_no_list as $item)
      @if($building->building === $item->building)
        @if($item->status === 'vacant' || $item->status=== 'accepted')
            <a title="{{ $item->type_of_units }}" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-danger">
                <i class="fas fa-home fa-3x"></i>
                <br>
                {{ $item->unit_no }}
            </a>
         
            @elseif($item->status=== 'occupied')
              <a title="{{ $item->type_of_units }}" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-success">
                <i class="fas fa-home fa-3x"></i>
                <br>
                {{ $item->unit_no }}
                </a>
            @endif   
          @endif
      @endforeach
      <hr>
    @endforeach
    </div>
  @endforeach 
</div>

@endif
<div class="modal fade" id="addMultipleUnits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Add Unit</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addUMultipleUnitForm" action="/property/{{ Session::get('property_id') }}/unit/store" method="POST">
              @csrf
          </form>

          <div class="form-group">
              <label>Building</label>
              <input form="addUMultipleUnitForm" type="text" class="form-control" name="building" placeholder="ex. Building A, Building 1">
              
          </div>

          <div class="form-group">
              <label>Floor</label>
              <select class="form-control" form="addUMultipleUnitForm" name="floor" id="floor" onchange ="autoFillInitialName()" required>
                                  <option value="" selected>Please select one</option>
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
          </div>

           <div class="form-group">
              <label>Type</label>
              <select form="addUMultipleUnitForm" class="form-control" name="type" required>
                  <option value="" selected>Please select one</option>
                  <option value="commercial">commercial</option>
              
                  <option value="residential">residential</option>         
              </select>
          </div> 
            <input form="addUMultipleUnitForm" type="hidden" value="{{Session::get('property_id')}}" name="property_id">
          
              {{-- <div class="form-group">
                <label>Occupancy</label>
                <input form="addUMultipleUnitForm" type="number" value="1" min="0"  class="form-control" name="occupancy">
            </div> --}}

          <div class="form-group">
              <label>Number of units to be created</label>
              <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
          </div>

          <input form="addUMultipleUnitForm" type="hidden" class="form-control" name="unit_no" id="unit_no" required>
      </div>
      <div class="modal-footer">
          <button form="addUMultipleUnitForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add</button>
          </div>
  </div>
  </div>
</div>

@endsection



@section('scripts')
  <script>
    function autoFillInitialName(){
      $floor = document.getElementById('floor').value;
      $unit_name = document.getElementById('unit_no');
      if($floor === '1'){
        $unit_name.value = 'GF';
      }
      if($floor === '2'){
        $unit_name.value = '2F';
      }
      if($floor === '3'){
        $unit_name.value = '3F';
      }
      if($floor === '4'){
        $unit_name.value = '4F';
      }
      if($floor === '5'){
        $unit_name.value = '5F';
      }
      if($floor === '6'){
        $unit_name.value = '6F';
      }
      if($floor === '7'){
        $unit_name.value = '7F';
      }
      if($floor === '8'){
        $unit_name.value = '8F';
      }
      if($floor === '9'){
        $unit_name.value = '9F';
      }

      if($floor === '-1'){
        $unit_name.value = '1B';
      }
      if($floor === '-2'){
        $unit_name.value = '2B';
      }
      if($floor === '-3'){
        $unit_name.value = '3B';
      }
      if($floor === '-4'){
        $unit_name.value = '4B';
      }
      if($floor === '-5'){
        $unit_name.value = '5B';
      }
    }
  </script>
@endsection



