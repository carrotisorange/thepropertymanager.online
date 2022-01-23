@extends('layouts.argon.main')

@section('title', 'Dashboard')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
  </div>
</div>
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">rooms</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($units->count(),0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
              <i class="fas fa-home"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          @if($increase_in_room_acquired <= 0) <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
            {{ $increase_in_room_acquired }}%</span>
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
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Owners</h5>
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
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Current tenants</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($tenants->count(), 0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
              <i class="fas fa-users"></i>
            </div>
          </div>
        </div>
        <a class="text-dark" href="/property/{{ Session::get('property_id') }}/tenants/pending">
          <p class="mt-3 mb-0 text-sm">
            @if($pending_tenants->count())
            <span class="text-warning mr-2"><i class="fa fa-user-clock"></i> {{ $pending_tenants->count() }} </span>
            <span class="text-nowrap">Marked as pending</span>
            @endif

          </p>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
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
          @if($increase_in_room_acquired <= 0) <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
            {{ $increase_from_last_month }}%</span>
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
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">OCCUPANCY RATE ({{ $current_occupancy_rate}}%)</h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $movein_rate->container() !!}
          @endif

      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">RETENTION RATE ({{ $renewal_rate }}%)</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $renewed_chart->container() !!}
          @endif

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">FINANCIALS</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $expenses_rate->container() !!}
          @endif

      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-5">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">REFERRALS</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <div class="card-body">
       
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            <table class="table table-hover">
              <thead>
                <tr>
            
                  <th>User</th>
                  <th>Role</th>
                  <th>Count</th>
                </tr>
              </thead>
            <tbody>
              @each('webapp.properties.includes.referrals', $referrals, 'referral', 'webapp.tenants.includes.no-record')
            </tbody>
            </table>
          </div>
        
      </div>
    </div>
  </div>
  <div class="col-md-7 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">SOURCES OF TENANTS</h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $point_of_contact->container() !!}
          @endif
      </div>
    </div>

  </div>
</div>
<br>
<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">TYPE OF TENANTS</h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $status->container() !!}
          @endif
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">LENGHT OF CONTRACTS </h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $length_of_stay->container() !!}
          @endif
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">MOVEOUT FOR THE LAST 6 MONTHS</h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $moveout_rate->container() !!}
          @endif
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">REASON FOR MOVING-OUT</h6>
      </div>
      <div class="card-body">
        @if(!$contracts) <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough
          data to show statistics.</p>
          @else
          {!! $reason_for_moving_out_chart->container() !!}
          @endif
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">EXPIRING CONTRACTS</h6>
        <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/expiring-contracts">View
            all</a></small>
      </div>
      <div class="card-body">
          
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tenant</th>
                  <th>Room</th>
                  <th>Moveout</th>
                  <th>Status</th>
                  <th>Mobile</th>
                </tr>
              </thead>
              @forelse ($expiring_contracts as $item)
              @include('webapp.properties.includes.expiring-contracts', ['item' => $item])
              @empty
              @include('webapp.tenants.includes.no-record')
              @endforelse
            </table>
        
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card shadow mb-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">DELINQUENTS </h6>
        <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/delinquents">View all</a></small>
      </div>
      <div class="card-body">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tenant</th>
                  <th>Room</th>
                  <th>Balance</th>
                </tr>
              </thead>
              @forelse ($delinquents as $delinquent)
              @include('webapp.properties.includes.delinquents', ['delinquent' => $delinquent])
              @empty
              @include('webapp.tenants.includes.no-record')
              @endforelse
            </table>
            {{ $delinquents->links() }}
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow mb-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">PENDING/ACTIVE CONCERNS <span hidden
            id="pending_concerns">{{ $pending_concerns->count() }}</span></h6>
        <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/pending-concerns">View
            all</a></small>
      </div>
      <div class="card-body">
          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tenant</th>
                  <th>Room</th>
                  <th>Concern</th>
                </tr>
              </thead>
              <tbody>
                @each('webapp.properties.includes.pending-concerns', $pending_concerns, 'item', 'webapp.tenants.includes.no-record')
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">DAILY COLLECTIONS as of
          {{ Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</h6>
        <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/collections">View all</a></small>
      </div>
      <div class="card-body">
          
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>AR No</th>
                  <th>Bill No</th>
                  <th>Room</th>
                  <th>Tenant</th>
                  <th>Particular</th>
                  <th>Form</th>
                  <th colspan="2">Period Covered</th>
                  <th>Amount</th>
                </tr>
              </thead>
             @each('webapp.properties.includes.daily-collections', $collections, 'collection', 'webapp.tenants.includes.no-record')
            </table>
            {{ $collections->links() }}
         
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pending concerns</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You have <b>{{ $pending_concerns->count() }}</b> pending/active concern/s that need to be addressed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Dismiss
        </button>
        <a href="/property/{{  Session::get('property_id') }}/pending-concerns" class="btn btn-primary"><i
            class="fas fa-check"></i> Proceed</a>
        </form>
      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
{!! $point_of_contact->script() !!}
{!! $movein_rate->script() !!}
{!! $renewed_chart->script() !!}
{!! $moveout_rate->script() !!}
{!! $expenses_rate->script() !!}
{!! $reason_for_moving_out_chart->script() !!}
{!! $status->script() !!}
{!! $length_of_stay->script() !!}
<script>
  $(document).ready(function(){

  if(document.getElementById('pending_concerns').innerHTML > 0){
    $("#showModal").modal({
            backdrop: 'static',
            keyboard: false
        });

    }
  });
</script>
@endsection