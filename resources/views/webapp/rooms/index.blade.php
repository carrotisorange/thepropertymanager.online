@extends('layouts.argon.main')

@section('title', 'Rooms')

@section('css')

@endsection

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{Session::get('property_name')}}
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
           <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/rooms">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Rooms</span>
              </a>
              @endif
            
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                 <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bulk Billing</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Daily Collection Report</span>
              </a>
            </li>
            @if(Session::get('property_type') === 'Apartment Rentals')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/remittances">
                <i class="fas fa-hand-holding-usd text-teal"></i>
                <span class="nav-link-text">Remittances</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">User History</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
                   <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>

            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">

  <div class="col-lg-6 text-left">
   
      <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>
     
  </div>

  <div class="col-md-6 text-right">
    @if(Auth::user()->account_type === 'starter')
      @if($units->count()>20)
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @endif
    @elseif(Auth::user()->account_type === 'basic' )
      @if($units->count()>30)
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @endif
    @elseif(Auth::user()->account_type === 'large' )
      @if($units->count()>50)
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @endif
    @elseif(Auth::user()->account_type === 'advanced' )
      @if($units->count()>75)
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
      @endif
    @elseif(Auth::user()->account_type === 'enterprise' )
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> Create Rooms</a>
    @endif

    <a href="/property/{{Session::get('property_id')}}/rooms/{{ Carbon\Carbon::now()->getTimestamp() }}/edit" class="btn btn-primary" ><i class="fas fa-edit fa-sm text-dark-50"></i> Edit Rooms</a>
    <a href="/property/{{Session::get('property_id')}}/rooms/clear" class="btn btn-danger" ><i class="fas fa-backspace fa-sm text-dark-50"></i> Clear Filters</a>
  </div>

 
</div>

<div class="row">
  
  <form id="filter" action="/property/{{ Session::get('property_id') }}/rooms/filter"></form>
  <div class="col-md-3">
    <div class="col-left">
     <label for=""><b>Status</b></label>

     <br>
    </div>
   
    @foreach ($statuses as $status)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="status" value="{{ $status->status }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $status->status }} ({{ $status->count }})</label>
    </div>
    @endforeach
    <hr>
    <label for=""><b>Building</b></label>
   <br>
    @foreach ($buildings as $building)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="building" value="{{ $building->building }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $building->building }} ({{ $building->count }})</label>
    </div>
    @endforeach

    <hr>
    <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
    <label for=""><b>Floor</b></label>
    @foreach ($floors as $floor)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="floor" value="{{ $floor->floor }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $numberFormatter->format($floor->floor) }} floor ({{ $floor->count }})</label>
    </div>
    @endforeach
    <hr>
   
    <label for=""><b>Type</b></label>
    @foreach ($types as $type)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="type" value="{{ $type->type }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $type->type }} ({{ $type->count }})</label>
    </div>
    @endforeach

    <hr>
   
    <label for=""><b>Size</b></label>
    @foreach ($sizes as $size)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="size" value="{{ $size->size }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $size->size }} <b>sqm</b> ({{ $size->count }})</label>
    </div>
    @endforeach

    <hr>

    <label for=""><b>Occupancy</b></label>
    @foreach ($occupancies as $occupancy)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="occupancy" value="{{ $occupancy->occupancy }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">{{ $occupancy->occupancy }} <b>pax</b> ({{ $occupancy->count }})</label>
    </div>
    @endforeach

    <hr>
   
    <label for=""><b>Rent</b></label>
    @foreach ($rents as $rent)
    <div class="form-check">
      <input form="filter" type="checkbox" class="form-check-input" name="rent" value="{{ $rent->rent }}" id="exampleCheck1" onChange="this.form.submit()">
      <label class="form-check-label" for="exampleCheck1">₱ {{ number_format($rent->rent, 2) }} ({{ $rent->count }})</label>
    </div>
    @endforeach


  </div>
  
  <div class="col-md-9">
    @if($units->count() <=0 )
    <p class="">No rooms found!</p>
    @else
    <p class="">Showing  <b>{{ $units->count() }} {{ Session::get('status') }}  {{ Session::get('type') }}  {{ Session::get('building') }}  {{ Session::get('rent') }}  {{ Session::get('occupancy') }}  {{ Session::get('floor') }} </b>rooms...
   
    </p>
    
        @foreach ($units as $item)
     
        <div class="card card-body">
     
        <div class="row">  
          <div class="col-md-7">
            <h1 class="display-6">   <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a></h1>
            <p class="">
              Floor &#9671 {{ $numberFormatter->format($item->floor) }} <br>
              Status &#9671 {{ $item->status }} <br>
              Rent &#9671 ₱{{ number_format($item->rent,2) }}<br>
              Type &#9671 {{ $item->type }}
              <br>
              Room created on &#9671 {{ $item->created_at? Carbon\Carbon::parse($item->created_at)->format('M d, Y'): 'NOT AVAILABLE' }}
              <br>
              Last contract ended on &#9671 {{ $item->updated_at? Carbon\Carbon::parse($item->updated_at)->format('M d, Y'): 'NOT AVAILABLE' }}
            </p>
  
          </div>
          <div class="col-md-5">
            <img  src="{{ asset('/arsha/assets/img/not-available.png') }}" width = "70%" alt="image of the room" class="img-thumbnail">
          </div>
         </div>

          </div>

{{--        
        <a title="{{ $item->type }}" href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}" class="btn btn-primary ">
          <i class="fas fa-home"></i>
        
           {{ $item->unit_no }}
         </a>  --}}
       
          @endforeach

    @endif

    </div>
</div>


<div class="modal fade" id="upgradeToPro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="addMultipleUnits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Room Information</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addUMultipleUnitForm" action="/property/{{ Session::get('property_id') }}/room/store" method="POST">
              @csrf
          </form>

          <div class="form-group">
            <label>Number of rooms</label>
            <input form="addUMultipleUnitForm" type="number" value="1" min="1" class="form-control" name="no_of_rooms" required>
        </div>

          <div class="form-group">
              <label >Building <small>(Optional)</small></label>
              <input form="addUMultipleUnitForm" type="text" class="form-control" name="building" placeholder="Building 2">
              
          </div>

          <div class="form-group">
            <label >Size <small>(sqm)</small></label>
            <input form="addUMultipleUnitForm" type="number" step="0.001" class="form-control" name="size" placeholder="20">
            
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

           {{-- <div class="form-group">
              <label>Type</label>
              <select form="addUMultipleUnitForm" class="form-control" name="type" required>
                  <option value="" selected>Please select one</option>
                  <option value="commercial">commercial</option>
                  <option value="residential">residential</option>         
              </select>
          </div>  --}}
            {{-- <input form="addUMultipleUnitForm" type="hidden" value="{{Session::get('property_id')}}" name="property_id"> --}}
          
              <div class="form-group">
                <label>Occupancy <small>(Number of tenants allowed)</small></label>
                <input form="addUMultipleUnitForm" type="number" value="1" min="0"  class="form-control" name="occupancy">
            </div>

        
              <input form="addUMultipleUnitForm" type="hidden" class="form-control" name="unit_no" id="unit_no" required>
    
         
            <div class="form-group">
                <label>Rent <small>(/month)</small></label>
                <input form="addUMultipleUnitForm" type="number" value="0" step="0.01" min="0" class="form-control" name="rent" id="rent">
            </div>
          

      </div>
      <div class="modal-footer">
        
          <button form="addUMultipleUnitForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Create Rooms</button>
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
      if($floorfed === '-5'){
        $unit_name.value = '5B';
      }
    }
  </script>
@endsection



