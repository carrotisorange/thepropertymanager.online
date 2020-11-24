@extends('templates.webapp.template')

@section('title', 'Dashboard')

@section('sidebar')
   
      
           <!-- Heading -->
      
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
                <a class="nav-link" href="/board">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
              </li>
      
            <hr class="sidebar-divider">
      
            <div class="sidebar-heading">
              Interface
            </div>  
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item active">
            <a class="nav-link" href="/home">
              <i class="fas fa-home"></i>
              <span>Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/calendar">
              <i class="fas fa-calendar-alt"></i>
              <span>Calendar</span></a>
          </li>
          @endif
        
          @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link" href="/tenants">
                <i class="fas fa-users fa-chart-area"></i>
                <span>Tenants</span></a>
            </li>
            @endif
      
       @if((Auth::user()->user_type === 'admin' && Auth::user()->property_ownership === 'Multiple Owners') || (Auth::user()->user_type === 'manager' && Auth::user()->property_ownership === 'Multiple Owners'))
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/owners">
            <i class="fas fa-user-tie"></i>
            <span>Owners</span></a>
        </li>
         @endif
      
         <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/concerns">
          <i class="far fa-comment-dots"></i>
              <span>Concerns</span></a>
        </li>
    
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
        <li class="nav-item">
            <a class="nav-link" href="/joborders">
              <i class="fas fa-tools fa-table"></i>
              <span>Job Orders</span></a>
        </li>
        @endif
      
             <!-- Nav Item - Tables -->
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link collapsed" href="/personnels" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-user-cog"></i>
                <span>Personnels</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="/housekeeping">Housekeeping</a>
                  <a class="collapse-item" href="/maintenance">Maintenance</a>
                </div>
              </div>
            </li>
        @endif
      
           @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <!-- Nav Item - Tables -->
            <li class="nav-item">
              <a class="nav-link" href="/bills">
                <i class="fas fa-file-invoice-dollar fa-table"></i>
                <span>Bills</span></a>
            </li>
           @endif
      
           @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/collections">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Collections</span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/financials">
                <i class="fas fa-coins"></i>
                <span>Financials</span></a>
            </li>
            @endif
      
               @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
            <a class="nav-link" href="/payables">
            <i class="fas fa-hand-holding-usd"></i>
              <span>Payables</span></a>
          </li>
          @endif
      
          @if(Auth::user()->user_type === 'manager')
           <!-- Nav Item - Tables -->
           <li class="nav-item">
            <a class="nav-link" href="/users">
              <i class="fas fa-user-circle"></i>
              <span>Users</span></a>
          </li>
          @endif
          
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
      
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
    
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Home</h1>
 @if(Auth::user()->user_type === 'manager')
 <p>
  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
  <a href="/units/edit/{{ Auth::user()->property }}/{{ Carbon\Carbon::now()->getTimestamp() }}" class="btn btn-primary" ><i class="fas fa-edit fa-sm text-white-50"></i> Edit</a>
  {{-- <a href="/units/delete/{{ Auth::user()->property }}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete Rooms</a> --}}
 </p>
 @endif
</div>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ Auth::user()->property }} <span id="count_rooms" class="badge badge-primary">{{ $units_count }}</span></a>
    @foreach ($buildings as $building)
    <a class="nav-item nav-link" id="{{ $building->building }}-tab" data-toggle="tab" href="#{{ $building->building }}" role="tab" aria-controls="{{ $building->building }}" aria-selected="false">{{ $building->building }} <span class="badge badge-primary">{{ $building  ->count }}</span></a>
    @endforeach
  </div>
</nav>
<div class="tab-content" id="">
  <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
    <a title="{{ $item->type_of_units }}" href="/units/{{$item->unit_id}}" class="btn btn-primary">
          <i class="fas fa-home fa-3x"></i>
          <br>
          {{ $item->unit_no }}
    </a>
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
      @if($building->building === $item->building)
       
              <a title="{{ $item->type_of_units }}" href="/units/{{$item->unit_id}}" class="btn btn-primary">
                <i class="fas fa-home fa-3x"></i>
                <br>
                {{ $item->unit_no }}
                </a>
         
          @endif
      @endforeach
      <hr>
    @endforeach
    </div>
  @endforeach 
</div>


  
<div class="modal fade" id="addMultipleUnits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Enter Room Information</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addUMultipleUnitForm" action="/units/add-multiple" method="POST">
              {{ csrf_field() }}
          </form>

          <div class="form-group">
              <small >Enter the name of the building</small>
              <input form="addUMultipleUnitForm" type="text" class="form-control" name="building" placeholder="Building-A" required>
              <small class="text-danger">please put a hyphen (-) between spaces</small>
          </div>

          <div class="form-group">
              <small>Select the floor number</small>
              <select class="form-control" form="addUMultipleUnitForm" name="floor_no" id="floor_no" required>
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
                                    <option value="5">5ht floor</option>
                                    <option value="6">6th floor</option>
                                    <option value="7">7th floor</option>
                                    <option value="8">8th floor</option>
                                    <option value="9">9th floor</option>
              </select>
          </div>

           <div class="form-group">
              <small>Select the room type</small>
              <select form="addUMultipleUnitForm" class="form-control" name="type_of_units" required>
                  <option value="" selected>Please select one</option>
                  <option value="commercial">commercial</option>
                  <option value="residential">residential</option>         
              </select>
          </div> 

          


          <div class="form-group">
              <small>Enter the number of rooms you want to create</small>
              <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
          </div>

          <div class="form-group">
              <small>Enter the initial name of the rooms</small>
              <input form="addUMultipleUnitForm" type="text" class="form-control" name="unit_no" id="unit_no" placeholder="GF-" required>
          </div>

          
          
            
            <input form="addUMultipleUnitForm" type="hidden" value="0" min="0"  class="form-control" name="max_occupancy">

   
         
           
              
                <input form="addUMultipleUnitForm" type="hidden" value="0" step="0.01" min="0" class="form-control" name="monthly_rent" id="monthly_rent">
            
          

      </div>
      <div class="modal-footer">
          <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button>
          <button form="addUMultipleUnitForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Create Rooms</button>
          </div>
  </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(() => {
  var url = window.location.href;
  if (url.indexOf("#") > 0){
  var activeTab = url.substring(url.indexOf("#") + 1);
    $('.nav[role="tablist"] a[href="#'+activeTab+'"]').tab('show');
  }

  $('a[role="tab"]').on("click", function() {
    var newUrl;
    const hash = $(this).attr("href");
      newUrl = url.split("#")[0] + hash;
    history.replaceState(null, null, newUrl);
  });
});
</script>


<script>
$(document).ready(function(){

 if(document.getElementById('count_rooms').innerHTML <= 0){
    $("#addMultipleUnits").modal('show');
  }
});
</script>

@endsection



