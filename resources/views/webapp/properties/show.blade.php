@extends('layouts.argon.main')

@section('title', 'Dashboard')

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
            <h5 class="card-title text-uppercase text-muted mb-0"> total rooms</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($units->count(),0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
              <i class="fas fa-home"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          @if($increase_in_room_acquired <= 0)
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
            <h5 class="card-title text-uppercase text-muted mb-0">total Owners</h5>
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
          <span class="text-warning mr-2"><i class="fa fa-user-clock"></i> {{ $pending_tenants->count() }} </span>
          <span class="text-nowrap">Marked as pending</span>
        </p>
      </a>
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
          @if($increase_in_room_acquired <= 0)
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
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">OCCUPANCY RATE ({{ $current_occupancy_rate}}%)</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        @if($contracts <= 0)
        <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
        @else
        {!! $movein_rate->container() !!}
        @endif
         
      </div>
    </div>
  </div>

  <!-- Retention Doughnut Chart -->
  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-3">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">RETENTION RATE ({{ $renewal_rate }}%)</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        @if($contracts <= 0)
        <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
        @else
        {!! $renewed_chart->container() !!}
        @endif
         
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
        @if($contracts <= 0)
        <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
        @else
        {!! $expenses_rate->container() !!}
        @endif
        
      </div>
    </div>
  </div>

 
</div>
<div class="row">

  <!-- Financial Line Chart -->
  <div class="col-md-5">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">TOP AGENTS</h6>
        <div class="dropdown no-arrow">
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
      @if($top_agents->count() <=0)
      <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
      @else
      <div class="table-responsive text-nowrap">
        <table class="table">
       
         <thead>
          <tr>
        
            <th>User</th>
            <th>Role</th>
            <th># Referrals</th>
          </tr>
         </thead>
         <tbody>
           @foreach ($top_agents as $item)
           <tr>
            <?php $explode = explode(" ", $item->name);?>
             <td>{{ $explode[0] }}</td>
             <td>{{ $item->user_type }}</td>
             <td>{{ number_format($item->referrals) }}</td>
          </tr>
           @endforeach
         </tbody>
        </table>
        </div>
    @endif
      </div>
    </div>
  </div>
  <div class="col-md-7 mb-4">
    <!-- Illustrations -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">SOURCES</h6>
          {{-- <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/demographics">View all</a></small> --}}
        </div>

  
      <div class="card-body">
      @if($contracts <= 0)
      <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
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
    <!-- Illustrations -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">TYPE OF TENANT</h6>
          {{-- <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/demographics">View all</a></small> --}}
        </div>

  
      <div class="card-body">
      @if($contracts <= 0)
      <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
      @else
      {!! $status->container() !!}
      @endif
      </div>
    </div>

  </div>

  <div class="col-md-6 mb-4">
    <!-- Illustrations -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">LENGHT OF STAY</h6>
          {{-- <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/demographics">View all</a></small> --}}
        </div>

  
      <div class="card-body">
      @if($contracts <= 0)
      <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
      @else
      {!! $length_of_stay->container() !!}
      @endif
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
        <h6 class="m-0 font-weight-bold text-primary">MOVEOUT FOR THE LAST 6 MONTHS</h6>
      </div>
      <div class="card-body">
        @if($contracts <= 0)
        <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
        @else
        {!! $moveout_rate->container() !!}
        @endif
         
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
        @if($contracts <= 0)
        <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Not enough data to show statistics.</p>
        @else
        {!! $reason_for_moving_out_chart->container() !!}
        @endif
      
    </div>
    </div>

  </div>
</div>


<!-- Content Row -->
<div class="row">
  
  <!-- Content Column -->
  <div class="col-lg-12 mb-4">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
     <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
       <h6 class="m-0 font-weight-bold text-primary">EXPIRING CONTRACTS</h6>
       <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/expiring-contracts">View all</a></small>
     </div>
     <div class="card-body">
      @if($tenants_to_watch_out->count() <=0)
      <p class="text-success text-center"><i class="fas fa-check-circle"></i> No expiring contracts.</p>
     @else
     <div class="table-responsive text-nowrap">
      <table class="table" >
        <thead>
    
          <tr>
     
            <th>Tenant</th>
            <th>Room</th>
            <th>Moveout</th>
           
            <th>Status</th>
            <th>Action</th>
         
        </tr>
        </thead>
        <tbody>
          @foreach($tenants_to_watch_out as $item)
         
           <tr>
 
               <th>
                 <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#contracts">{{ $item->first_name.' '.$item->last_name }}  
                 </th>
               <th>
                 @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                 <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                @else
                <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                @endif
                
               </th>
               <td>{{Carbon\Carbon::parse($item->moveout_at)->format('M d Y')}} <span class="text-danger">({{ Carbon\Carbon::parse($item->moveout_at)->diffForHumans() }})</span></td>
               
               <td>
                 @if($item->contract_status === 'active')
                <span class="text-success"><i class="fas fa-check-circle"></i> {{ $item->contract_status }}</span>
                 @else
                 <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>
       
                 @endif
               </td>
               <td>
                 @if($item->email_address === null)
                 <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/edit#email_address" class="badge badge-danger">Please add an email</a>
                 @else
                 <form action="/property/{{Session::get('property_id')}}/home/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/contract/{{ $item->contract_id }}/alert">
                   @csrf
                   @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                   <button class="btn btn-sm btn btn-primary" type="submit" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-paper-plane fa-sm text-white-50"></i> Send email</button>
                   @else
                   <button class="btn btn-sm btn btn-primary" title="for manager and admin access only" type="submit" onclick="this.form.submit(); this.disabled = true;" disabled><i class="fas fa-paper-plane fa-sm text-white-50"></i> Send Email</button>
                   @endif
                 </form>
                 @endif
               </td>
             
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
     @endif

     </div>
   </div>

       </div>

</div>


<!-- Content Row -->
<div class="row">

        <!-- Pie Chart -->
        <div class="col-md-6">
          <div class="card shadow mb-3">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">TOP DELINQUENTS </h6>
             
              <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/delinquents">View all</a></small>
              
            </div>
            <!-- Card Body -->
            <div class="card-body">
              @if($delinquent_accounts->count() <=0)
              <p class="text-success text-center"><i class="fas fa-check-circle"></i> No delinquent tenants.</p>
             @else
             <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                  
                  <tr>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($delinquent_accounts as $item)
                  <tr>
                    <th>
          
                      <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#bills">{{ $item->first_name.' '.$item->last_name }}
                
                    </th>
                    <th>
                      @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin' )
                      @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                      <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id   }}">{{$item->unit_no }}</a>
                     @else
                     <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id   }}">{{$item->unit_no }}</a>
                     @endif
                     
                      @else
                     {{ $item->unit_no }}
                      @endif
                    </th>
                    <td>
                      <a>{{ number_format($item->balance,2) }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                
              </table>
             
            </div>
           
              @endif
            </div>
          </div>
          
        </div>

        <div class="col-md-6">
          <div class="card shadow mb-3">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">PENDING CONCERNS <span hidden id="pending_concerns">{{ $pending_concerns->count() }}</span></h6>
              <small class="text-right"><a href="/property/{{ Session::get('property_id') }}/pending-concerns">View all</a></small>
              {{-- <b class="text-success">({{ $concerns->count()? 0: number_format($concerns->sum('rating')/$concerns->count(), 2) }}/5) SATISFACTION RATE</b> --}}
            </div>
            <!-- Card Body -->
            <div class="card-body">
             @if($pending_concerns->count() <=0)
              <p class="text-success text-center"><i class="fas fa-check-circle"></i> No pending concerns.</p>
             @else
             <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Concern</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($pending_concerns as $item)
                  <tr>
                    <th>
          
                      <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}
                
                    </th>
                    <th>
                      @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin' )
                      @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                      <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id   }}">{{ $item->unit_no }}</a>
                     @else
                     <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id   }}">{{ $item->unit_no }}</a>
                     @endif
                      
                      @else
                      {{ $item->unit_no }}
                      @endif
                    </th>
                    <th>
                      <a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id   }}">{{ $item->title }}</a>
                    </th>
                  </tr>
                  @endforeach
                </tbody>
              </table>
         {{ $pending_concerns->links() }}
            </div>
             @endif
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
<h6 class="m-0 font-weight-bold text-primary">DAILY COLLECTIONS</h6>

<small class="text-right"><a href="/property/{{ Session::get('property_id') }}/collections">View all</a></small>
  {{-- <a title="export all" target="_blank" href="/property/{{ Auth::user()->property }}/export"><i class="fas fa-download fa-sm fa-fw text-primary-400"></i></a> --}}


</div>
<div class="card-body">
  @if($collections_for_the_day->count() <=0)
  <p class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> No collections recorded for today!</p>
  @else
  <div class="table-responsive text-nowrap">
    <table class="table" >
      <thead>

       <tr>
    
           <th>AR No</th>
           <th>Bill No</th>
           <th>Room</th>
           <th>Tenant</th>
        
          
           <th>Particular</th>
           <th colspan="2">Period Covered</th>
           <th class="text-right">Amount</th>
           
       </tr>
       
     </thead>
      <tbody>
       @foreach ($collections_for_the_day as $item)
       <tr>

         <td>{{ $item->ar_no }}</td>
          <td>{{ $item->payment_bill_no }}</td>
          <th>
           @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
           <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->unit_no }}
          @else
          <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->unit_no }}
          @endif

           </th>
           <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#payments">{{ $item->first_name.' '.$item->last_name }}</a></th>
         
           <td>
             {{ $item->particular }}</td>
           <td colspan="2">
           {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
           {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
           </td>
           <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
              {{-- <td class="text-center">
          <a title="export" target="_blank" href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/payment/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="btn btn-sm btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a> --}}
             {{-- <a id="" target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a> 
       </tr> --}}
           
       @endforeach
       <tr>
         <th>TOTAL</th>
         <th class="text-right" colspan="8">{{ number_format($collections_for_the_day->sum('amt_paid'),2) }}</th>
        </tr>
      </tbody>
    </table>
   </div>
  @endif

</div>
</div>
</div>
</div>





<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="modal">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Pending concerns</h5>

<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
You have <b>{{ $pending_concerns->count() }}</b> pending concern/s that need to be addressed.
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal"> Dismiss </button>
<a href="/property/{{  Session::get('property_id') }}/pending-concerns" class="btn btn-primary" >Proceed</a>
</form>
</div> 
</div>
</div>

</div>

@endsection

@section('main-content')

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

{{-- <script type="text/javascript">
  $(window).on('load',function(){
      $('#showModal').modal('show');
  });
</script> --}}
{{-- 
<script type="text/javascript">
  $(window).on('load',function(){
      $('#showModal').modal('show');
  });
</script> --}}


@endsection



