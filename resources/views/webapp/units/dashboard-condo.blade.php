@extends('layouts.argon.main')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <a href="#" class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

@if(Auth::user()->property_ownership === 'Multiple Owners')
<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a class="text-primary"
                href="/units"> ROOMS</a> </div>
            <div id="count_rooms" class="h5 mb-0 font-weight-bold text-gray-800">{{ $units->count() }}</div>
            {{--                             
            <small>O ({{ $units_occupied->count() }})</small>
            <small>V ({{ $units_vacant->count() }})</small>
            <small>R ({{ $units_reserved->count() }})</small>
            --}}
          </div>
          <div class="col-auto">
            <i class="fas fa-home fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a class="text-success"
                href="/tenants"> ACTIVE TENANTS</a></div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_tenants->count() }}</div>
            {{-- <small>PENDING ({{ $pending_tenants->count() }})</small> --}}

          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><a class="text-warning"
                href="/owners"> OWNERS</a> </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $owners->count() }}</div>
            {{-- <small>|</small> --}}

          </div>
          <div class="col-auto">
            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><a class="text-danger"
                href="#active-concerns"> ACTIVE CONCERNS</a></div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_concerns->count() }}</div>
            {{--                            
            <small>PENDING ({{ $pending_concerns->count() }})</small> --}}
          </div>
          <div class="col-auto">
            <i class="fas fa-tools fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@else
<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a class="text-primary"
                href="/rooms"> ROOMS</a></div>
            <div id="count_rooms" class="h5 mb-0 font-weight-bold text-gray-800">{{ $units->count() }}</div>

            {{-- <small>O ({{ $units_occupied->count() }})</small>
            <small>V ({{ $units_vacant->count() }})</small>
            <small>R ({{ $units_reserved->count() }})</small> --}}

          </div>
          <div class="col-auto">
            <i class="fas fa-home fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a class="text-success"
                href="/tenants"> ACTIVE TENANTS</a></div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_tenants->count() }}</div>
            {{-- <small>PENDING ({{ $pending_tenants->count() }})</small> --}}

          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><a class="text-danger"
                href="#active-concerns"> ACTIVE CONCERNS</a></div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_concerns->count() }}</div>

            {{-- <small>PENDING ({{ $pending_concerns->count() }})</small> --}}
          </div>
          <div class="col-auto">
            <i class="fas fa-tools fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endif


<div class="row">

  <!-- Occupancy Line Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">OCCUPANCY RATE</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        {!! $movein_rate->container() !!}
      </div>
    </div>
  </div>

  <!-- Retention Doughnut Chart -->
  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-3">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">RETENTION RATE</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        {!! $renewed_chart->container() !!}
      </div>
    </div>
  </div>
</div>

<div class="row">

  <!-- Financial Line Chart -->
  <div class="col-xl-12 col-lg-12">
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

<div class="row">
  {{-- Moveout Line Chart --}}
  <div class="col-lg-6 mb-4">
    <!-- Illustrations -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">FREQUENCY OF MOVEOUT</h6>
      </div>
      <div class="card-body">
        {!! $moveout_rate->container() !!}
      </div>
    </div>

  </div>

  <div class="col-lg-6 mb-4">
    <!-- Moveout Pie Chart -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">REASON FOR MOVING-OUT</h6>
      </div>
      <div class="card-body">
        {!! $reason_for_moving_out_chart->container() !!}
      </div>
    </div>

  </div>
</div>


<!-- Content Row -->
<div class="row">

  <!-- Content Column -->
  <div class="col-lg-6 mb-4">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">EXPIRING CONTRACTS</h6>

      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>TENANT</th>
                <th>ROOM</th>
                <th>STATUS</th>
                <th>ACTION</th>
                <th>ACTION STATUS</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tenants_to_watch_out as $item)
              <?php   $diffInDays =  number_format(Carbon\Carbon::now()->DiffInDays(Carbon\Carbon::parse($item->moveout_date), false)) ?>
              <tr>
                <td title="{{ $item->tenants_note }}">
                  @if(Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 5 )
                  <a href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/billings">{{ $item->first_name.' '.$item->last_name }}
                    @else
                    <a
                      href="{{ route('show',['unit_id' => $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }}</a>
                    @endif
                </td>
                <td>
                  @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
                  <a href="/units/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                  @else
                  {{ $item->building.' '.$item->unit_no }}
                  @endif
                </td>
                <td>
                  @if($diffInDays <= -1) <span class="badge badge-danger">contract has lapsed {{ $diffInDays*-1 }} days
                    ago</span>
                    @else
                    <span class="badge badge-warning">contract expires in {{ $diffInDays }} days </span>
                    @endif
                </td>
                <td>
                  {{-- @if($item->email_address === null)
                    <a href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/edit#email_address"
                  class="badge badge-warning">Please add an email</a>
                  @else
                  <form action="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/alert/contract">
                    @csrf
                    @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
                    <button class="btn btn-primary btn btn-primary" type="submit"
                      onclick="this.form.submit(); this.disabled = true;"><i
                        class="fas fa-paper-plane fa-sm text-white-50"></i> Send Email</button>
                    @else
                    <button class="btn btn-primary btn btn-primary" title="for manager and admin access only"
                      type="submit" onclick="this.form.submit(); this.disabled = true;" disabled><i
                        class="fas fa-paper-plane fa-sm text-white-50"></i> Send Email</button>
                    @endif
                  </form>
                  @endif --}}
                </td>
                <td><span class="badge badge-success">{{ $item->tenants_note }}</span></td>
              </tr>


              @endforeach
            </tbody>
          </table>
          {{ $tenants_to_watch_out->links() }}
        </div>
      </div>
    </div>

  </div>

  <!-- Pie Chart -->
  <div class="col-xl-6 col-lg-6">
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
                <th>TENANT</th>
                <th>ROOM</th>
                <th>AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              {{-- @foreach($delinquent_accounts as $item)
              <tr>
                <td title="{{ $item->tenants_note }}">
              @if(Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 5 )
              <a href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/billings">{{ $item->first_name.' '.$item->last_name }}
                @else
                <a
                  href="{{ route('show',['unit_id' => $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }}</a>
                @endif
                </td>
                <td>
                  @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
                  <a href="/units/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                  @else
                  {{ $item->building.' '.$item->unit_no }}
                  @endif
                </td>
                <td>
                  <a
                    href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/billings">{{ number_format($item->balance,2) }}</a>
                </td>
                </tr>
                @endforeach
            </tbody> --}}
          </table>
          {{-- {{ $delinquent_accounts->links() }} --}}
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
        <h6 class="m-0 font-weight-bold text-primary">DAILY COLLECTION</h6>


        <a title="export" target="_blank" href="/property/{{ Auth::user()->property }}/export"><i
            class="fas fa-download "></i></a>


      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>AR NO</th>
                <th>BILL NO</th>
                <th>TENANT</th>
                <th>ROOM</th>

                <th>AMOUNT</th>
                <th></th>
              </tr>

            </thead>
            <tbody>
              @foreach ($collections_for_the_day as $item)
              <tr>
                <td>{{ $item->ar_no }}</td>
                <td>{{ $item->payment_bill_no }}</td>
                <td>{{ $item->first_name.' '.$item->last_name }}</td>
                <td>{{ $item->building.' '.$item->unit_no }}</td>


                <td>{{ number_format($item->total,2) }}</td>
                <td>
                  <a title="export pdf" target="_blank"
                    href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export"
                    class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a>
                  {{-- <a id="" target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a>  --}}

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <table class="table table-striped"" id=" dataTable" width="100%" cellspacing="0">
            <tr>
              <th>TOTAL</th>
              <th class="text-right">{{ number_format($collections_for_the_day->sum('total'),2) }}</th>
            </tr>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row" id="active-concerns">
  <div class="col-md-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">ACTIVE CONCERNS</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">

          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>DATE REPORTED</th>
                <th>TENANT</th>
                <th>ROOM</th>
                <th>TYPE</th>
                <th>DESCRIPTION</th>
                <th>URGENCY</th>
                <th>STATUS</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($concerns as $item)
              <tr>
                <td>{{ $item->concern_id }}</td>
                <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                <td>
                  <a
                    href="{{ route('show',['unit_id'=> $item->unit_id, 'tenant_id'=>$item->tenant_id]) }}">{{ $item->first_name.' '.$item->last_name }}</a>
                </td>
                <td> @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
                  <a href="/units/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                  @else
                  {{ $item->building.' '.$item->unit_no }}
                  @endif</td>
                <td>

                  {{ $item->category }}

                </td>
                <td>
                  @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
                  <a title="{{ $item->details }}"
                    href="/units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}/concerns/{{ $item->concern_id }}">{{ $item->title }}</a>
                </td>
                @else
                {{ $item->title }}
                @endif


                <td>
                  @if($item->urgency === 'urgent')
                  <span class="badge badge-danger">{{ $item->urgency }}</span>
                  @elseif($item->urgency === 'major')
                  <span class="badge badge-warning">{{ $item->urgency }}</span>
                  @else
                  <span class="badge badge-primary">{{ $item->urgency }}</span>
                  @endif
                </td>
                <td>
                  @if($item->status === 'pending')
                  <span class="badge badge-warning">{{ $item->status }}</span>
                  @elseif($item->status === 'active')
                  <span class="badge badge-primary">{{ $item->status }}</span>
                  @else
                  <span class="badge badge-secondary">{{ $item->status }}</span>
                  @endif
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $concerns->links() }}

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
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
@endsection