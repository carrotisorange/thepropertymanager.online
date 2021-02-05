@extends('layouts.argon.main')

@section('title', 'Edit Rooms')

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
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
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
                <span class="nav-link-text">Users</span>
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
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0"><a href="/property/{{Session::get('property_id')}}/rooms" class="btn btn-primary" ><i class="fas fa-arrow-left"></i> Back</a></h6>
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
 
      <div class="table-responsive">
          <form id="editUnitsForm" action="/property/{{Session::get('property_id')}}/rooms/{{ Carbon\Carbon::now()->getTimestamp()}}/update" method="POST">
  
              @csrf
              @method('PUT')

          </form>
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Building</th>
                      <th>Room</th>
                      <th>Floor</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th>Occupancy</th>
                      <th>Rent</th>
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
                      $term =1;
                  ?>
                  @foreach ($units as $item)
              
                      <tr>
                          <th> {{ $ctr++ }}</th>
                          <td><input form="editUnitsForm" type="text" name="building{{ $building++  }}" id="" value="{{ $item->building }}"></td>
                          <td>
                            <input  form="editUnitsForm" type="text" name="unit_no{{ $unit_no++  }}" id="" value="{{ $item->unit_no }}">
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
                              <option value="dirty">dirty</option>
                              <option value="vacant">vacant</option>
                              <option value="occupied">occupied</option>
                              
                              <option value="reserved">reserved</option>
                          </select>
                          
                          </td>
                        
                       
                          <td><input class="col" form="editUnitsForm" type="number" name="occupancy{{ $occupancy++  }}" id="" min="0" value="{{ $item->occupancy }}"> pax</td>
                          <td><input class="" form="editUnitsForm" type="number" step="0.001" name="rent{{ $rent++  }}"  min="0" id="" value="{{$item->rent }}"></td>
                          <td>
                            <select form="editUnitsForm" type="text" name="term{{ $term++  }}" id="" >
                              <option value="{{ $item->term }}" readonly selected class="bg-primary">{{ $item->term }}</option>
                              <option value="lt">lt</option>
                              <option value="st">st</option>
                          </select>
                          
                          </td>
                          <td>
                            <form action="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}" method="POST">
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
         <br>
         @if($units->count() <=0 )

         @else
        <p class="text-right">
                <button type="submit" form="editUnitsForm" class="btn btn-primary"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Update</button>
            </p>
         @endif
  
</div>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



