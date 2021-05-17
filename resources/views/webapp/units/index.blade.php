@extends('layouts.argon.main')

@section('title', 'Rooms')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">

  <div class="col-lg-6 text-left">
   
      <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>
     
  </div>

  <div class="col-md-6 text-right">
    @if(Auth::user()->account_type === 'starter')
      @if($units->count()>20)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === 'basic' )
      @if($units->count()>30)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === 'large' )
      @if($units->count()>50)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === 'advanced' )
      @if($units->count()>75)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === 'enterprise' )
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
    @endif
    @if($units->count() >1 )
 

   
  @endif
  <a href="/property/{{Session::get('property_id')}}/units/{{ Carbon\Carbon::now()->getTimestamp() }}/edit" class="btn btn-primary btn-sm" ><i class="fas fa-edit fa-sm text-dark-50"></i> Edit</a>
  {{-- <a href="/property/{{Session::get('property_id')}}/rooms/clear" class="btn btn-danger btn-sm" ><i class="fas fa-backspace fa-sm text-dark-50"></i> Clear search filters</a> --}}
  </div>

 
</div>
<div class="row">
  
  <div class="col-md-12 mx-auto">

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-home text-indigo"></i> All <span class="badge badge-primary badge-counter">{{ $units->count() }}</span></a>
        @foreach ($buildings as $item)
        <a class="nav-item nav-link" id="nav-{{ $item->building }}-tab" data-toggle="tab" href="#nav-{{ $item->building }}" role="tab" aria-controls="nav-{{ $item->building }}" aria-selected="false"><i class="fas fa-building text-indigo"></i> {{ $item->building }} <span class="badge badge-primary badge-counter">{{ $item->count }}</span></a>
        @endforeach
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <br>
        {{-- <div class="row" >
          @if($units->count() <=0 )
        <p class="">No rooms found!</p>
        @else
        <p class="">Showing <b>{{ $units->count() }} {{ Session::get('status') }}  {{ Session::get('type') }}  {{ Session::get('building') }}  {{ Session::get('rent') }}  {{ Session::get('occupancy') }}  {{ Session::get('floor') }} </b>rooms...
       
        </p>
        </div> --}}
        
        <div class="row  text-center" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          @foreach ($units as $item)
        
          <div class="col-md-2.5">
            @if($item->status === 'occupied')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
              <i class="fas fa-home fa-2x"></i>
              <br>
            <small>  {{ $item->unit_no }}</small>
          </a>
            @elseif($item->status === 'vacant')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-sm btn-danger" style="width: 85px; height: 60px;">
              <i class="fas fa-home fa-2x"></i>
              <br>
                <small>  {{ $item->unit_no }}</small>
          </a>
          @elseif($item->status === 'dirty')
          <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
            <i class="fas fa-home fa-2x"></i>
            <br>
            <small>  {{ $item->unit_no }}</small>
        </a>
        @else
        
        <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" class="btn btn-sm btn-warning" style="width: 85px  ; height: 60px;">
          <i class="fas fa-home fa-2x"></i>
          <br>
          <small>  {{ $item->unit_no }}</small>
      </a>
            @endif
                
           <hr>
         </div>
         
         
          @endforeach
        </div>
    
        {{-- @endif --}}
      </div>
      @foreach ($buildings as $item)
      <div class="tab-pane fade" id="nav-{{ $item->building }}" role="tabpanel" aria-labelledby="nav-{{ $item->building }}-tab">
        <br>
        <div class="row  text-center" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
          @foreach ($units as $unit)
        
          @if($unit->building === $item->building)
          <div class="col-md-2.5">
            @if($unit->status === 'occupied')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}" class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
            <small>  {{ $unit->unit_no }}</small>
          </a>
            @elseif($unit->status === 'vacant')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}" class="btn btn-sm btn-danger" style="width: 85px; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
                <small>  {{ $unit->unit_no }}</small>
          </a>
          @elseif($unit->status === 'dirty')
          <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}" class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
            @if($unit->unit_type_id_foreign == '1')
            <i class="fas fa-home fa-2x"></i>
            @elseif($unit->unit_type_id_foreign == '2')
            <i class="fas fa-dumpster fa-2x"></i>
            @else
            <i class="fas fa-car fa-2x"></i>
            @endif
            <br>
            <small>  {{ $unit->unit_no }}</small>
        </a>
        @else
        
        <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}" class="btn btn-sm btn-warning" style="width: 85px  ; height: 60px;">
          @if($unit->unit_type_id_foreign == '1')
          <i class="fas fa-home fa-2x"></i>
          @elseif($unit->unit_type_id_foreign == '2')
          <i class="fas fa-dumpster fa-2x"></i>
          @else
          <i class="fas fa-car fa-2x"></i>
          @endif
          <br>
          <small>  {{ $unit->unit_no }}</small>
      </a>
            @endif
                
           <hr>
         </div>
          @endif
         
         
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    
    </div>
</div>



<div class="modal fade" id="upgradeToPro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Upgrade to PRO</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <p class="text-center">
          The current plan you have reached the limit of rooms that you are allowed to add. 
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Dismiss</button>
      </div>
  </div>
  </div>
</div>

<div class="modal fade" id="addMultipleUnits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >New Room</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addUMultipleUnitForm" action="/property/{{ Session::get('property_id') }}/room/store" method="POST">
              @csrf
          </form>

          <div class="form-group">
            <label>Select a room type</label>
            <select class="form-control" form="addUMultipleUnitForm" name="room_type" id="room_type" required>
                <option value="" selected>Please select one</option>
                @foreach ($room_types as $item)
                  <option value="{{ $item->unit_type_id }}">{{ $item->unit_type }}</option>
                @endforeach
            </select>
        </div>

          <div class="form-group residential" style="display:none">
            <label>Number of rooms</label>
            <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
        </div>

        <div class="form-group residential" style="display:none">
          <label>Number of rooms</label>
          <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
      </div>

      <div class="form-group residential" style="display:none">
        <label>Number of rooms</label>
        <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
    </div>

          <div class="form-group residential" style="display:none">
              <label >Building <small>(Optional)</small></label>
              <input form="addUMultipleUnitForm" type="text" class="form-control" name="building" placeholder="Building 2">
              
          </div>

          <div class="form-group residential" style="display:none">
            <label >Size <small>(sqm)</small></label>
            <input form="addUMultipleUnitForm" type="number" step="0.001" class="form-control" name="size" placeholder="20" required>
            
        </div>
      
          <div class="form-group residential" style="display:none">
            <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
              <label>Floor</label>
              <select class="form-control" form="addUMultipleUnitForm" name="floor" id="floor" onchange ="autoFillInitialName()" required>
                  <option value="" selected>Please select one</option>
                  @foreach ($room_floors as $item)
                    @if($item->unit_floor>=0)
                      <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format($item->unit_floor) }} floor</option>
                    @else
                      <option value="{{ $item->unit_floor_id }}">{{ $numberFormatter->format(intval($item->unit_floor)*-1) }} basement</option>
                    @endif
                  @endforeach            
              </select>
          </div>

        
          
              <div class="form-group residential" style="display:none">
                <label>Occupancy</label>
                <input form="addUMultipleUnitForm" type="number" value="1" min="0"  class="form-control" name="occupancy">
            </div>

        
              <input form="addUMultipleUnitForm" type="hidden" class="form-control" name="unit_no" id="unit_no" required>
    
         
            <div class="form-group residential" style="display:none">
                <label>Monthly rent</label>
                <input form="addUMultipleUnitForm" type="number" value="0" step="0.01" min="0" class="form-control" name="rent" id="rent">
            </div>
          

      </div>
      <div class="modal-footer">
        
          <button style="display:none" id="submitButton" form="addUMultipleUnitForm" type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
          </div>
  </div>
  </div>
</div>

@endsection



@section('scripts')
  <script>
      $('#room_type').on('change',function(){
      if($(this).val()=="1"){
        $(".commercial").hide()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").hide()
      }
        else if($(this).val()=="2"){
        $(".commercial").show()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").hide()
      }
      else if($(this).val()=="3"){
        $(".commercial").hide()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").show()
      }
      else{
        $(".commercial").hide()
        $(".residential").hide()
        $("#submitButton").hide()
        $(".parking").hide()
      }
  });

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
      if($floorfed === '-5'){
        $unit_name.value = '5B';
      }
    }
  </script>
@endsection



