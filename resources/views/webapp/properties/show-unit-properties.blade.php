@extends('templates.webapp-new.template')

@section('title', 'Dashboard')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{ $property->name }} 
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="/property/{{$property->property_id }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/users">
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
              <a class="nav-link" href="/property/{{ $property->property_id }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/announcements" target="_blank">
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
              <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
              
            </div>
      
          </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"> UNITS</h5>
                      <span class="h2 font-weight-bold mb-0">{{ number_format($units->count(),0) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="fas fa-home"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    @if($increase_in_room_acquired > 0)
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_in_room_acquired }}%</span>
                    @else
                    <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_in_room_acquired }}%</span>
                    @endif
                    <span class="text-nowrap">Since last month</span>
                    </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">OWNERS</h5>
                      <span class="h2 font-weight-bold mb-0">{{ number_format($owners->count(),0) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="fas fa-user-tie"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-white mr-2"> | </span>
                    <span class="text-nowrap"></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Occupants</h5>
                      <span class="h2 font-weight-bold mb-0">{{ number_format($tenants->count(), 0) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-white mr-2"> | </span>
                    <span class="text-nowrap"></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Collections</h5>
                      <span class="h2 font-weight-bold mb-0">{{ number_format($collection_rate_1, 0) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="fas fa-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    @if($increase_in_room_acquired > 0)
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $increase_from_last_month }}%</span>
                    @else
                    <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $increase_from_last_month }}%</span>
                    @endif
                    <span class="text-nowrap">Since last month</span>
                    </p>
                </div>
              </div>
            </div>
          </div>


          <div class="row">

            <!-- Occupancy Line Chart -->
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">TURNED OVER RATE ({{ $current_occupancy_rate}}%)</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    {!! $movein_rate->container() !!}
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">FINANCIALS</h6>
                    <div class="dropdown no-arrow">
                    </div>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                      {!! $expenses_rate->container() !!}
                  </div>
                </div>
              </div>
          
          </div>

          
          <!-- Content Row -->
          <div class="row">

                  <!-- Pie Chart -->
                  <div class="col-md-12">
                    <div class="card shadow mb-3">
                      <!-- Card Header - Dropdown -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">DELINQUENTS</h6>
                       
                        
                      </div>
                      <!-- Card Body -->
                      <div class="card-body">
                        <div class="table-responsive text-nowrap">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Tenant</th>
                                <th>Room</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                              {{-- @foreach($delinquent_accounts as $item)
                              <tr>
                                <td>
                      
                                  <a href="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}#bills">{{ $item->first_name.' '.$item->last_name }}
                            
                                </td>
                                <td>
                                  @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin' )
                                  <a href="/property/{{ $property->property_id }}/home/{{ $item->unit_id   }}">{{ $item->building.' '.$item->unit_no }}</a>
                                  @else
                                 {{ $item->building.' '.$item->unit_no }}
                                  @endif
                                </td>
                                <td>
                                  <a>{{ number_format($item->balance,2) }}
                                </td>
                              </tr>
                              @endforeach --}}
                            </tbody>
                          </table>
                     
                        </div>
                      </div>
                    </div>
                  </div>
          
          </div>
          
          <div class="row">
                  <!-- Content Column -->
          <div class="col-lg-12 mb-4">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">DAILY COLLECTIONS ({{ $collections_for_the_day->count() }})</h6>
          
          
            <a title="export all" target="_blank" href="/property/{{ Auth::user()->property }}/export"><i class="fas fa-download fa-sm fa-fw text-primary-400"></i></a>
          
          
          </div>
          <div class="card-body">
          <div class="table-responsive text-nowrap">
           <table class="table" >
             <thead>
              <?php $ctr=1;?>
              <tr>
                <th class="text-center">#</th>
                  <th>AR No</th>
                  <th>Bill No</th>
                  <th>Room</th>
                  <th>Tenant</th>
               
                 
                  <th>Particular</th>
                  <th colspan="2">Period Covered</th>
                  <th>Amount</th>
                  <th></th>
              </tr>
              
            </thead>
             <tbody>
              @foreach ($collections_for_the_day as $item)
              <tr>
                <th class="text-center">{{ $ctr++ }}</th>
                <td>{{ $item->ar_no }}</td>
                 <td>{{ $item->payment_billing_no }}</td>
                 <td>{{ $item->building.' '.$item->unit_no }}</td>
                  <td>{{ $item->first_name.' '.$item->last_name }}</td>
                
                  <td>
                    {{ $item->billing_desc }}</td>
                  <td colspan="2">
                  {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                  {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
                  </td>
                  <td>{{ number_format($item->amt_paid,2) }}</td>
                  <td class="text-center">
                    <a title="export" target="_blank" href="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a>
                    {{-- <a id="" target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a>  --}}
                  </td>
              </tr>
              @endforeach
              <tr>
                <th>Total</th>
                <th class="text-right" colspan="8">{{ number_format($collections_for_the_day->sum('amt_paid'),2) }}</th>
               </tr>
             </tbody>
           </table>
          </div>
          </div>
          </div>
          </div>
          </div>
      
@endsection

  
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="modal">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">New feature.</h5>
  
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
   <div class="modal-body">
    Please help us improve your experience in managing your property by reporting the issues and bugs you encountered while using the system.
  
  </div>
  <div class="modal-footer">
   <button type="button" class="btn btn-secondary" data-dismiss="modal"> Dismiss </button>
   <a href="/property/{{  Session::get('property_id') }}/issues" class="btn btn-primary" >Report now</a>
  </form>
  </div> 
  </div>
  </div>
  
  </div>

@section('scripts')
{!! $point_of_contact->script() !!}
{!! $movein_rate->script() !!}
{!! $renewed_chart->script() !!}
{!! $moveout_rate->script() !!}
{!! $expenses_rate->script() !!}
{!! $reason_for_moving_out_chart->script() !!}


<script>
  $(document).ready(function(){

  if(document.getElementById('count_rooms').innerHTML <= 0){
      $("#myModal").modal('show');
    }
  });
</script>

<script type="text/javascript">
  $(window).on('load',function(){
      $('#showModal').modal('show');
  });
</script>

@endsection



