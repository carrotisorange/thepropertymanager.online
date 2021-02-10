@extends('layouts.argon.main')

@section('title', 'Bills')

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
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms">
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
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/bills">
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
  <div class="col-lg-4">
    <h6 class="h2 text-dark d-inline-block mb-0">Bills</h6>
  </div>
  <div class="col text-right">
    <div class=" row">
      @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
      <form id="billingCondoDuesForm" action="/property/{{Session::get('property_id')}}/bills/condodues/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
      </form>
      <input type="hidden" form="billingCondoDuesForm" name="billing_option" value="rent">
          <button class="btn btn-primary"  type="submit" form="billingCondoDuesForm"><i class="fas fa-plus"></i> Condo Dues</button>
      @else
      <form id="billingRentForm" action="/property/{{Session::get('property_id')}}/bills/rent/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
      </form>
      <input type="hidden" form="billingRentForm" name="billing_option" value="rent">
          <button class="btn btn-primary"  type="submit" form="billingRentForm"><i class="fas fa-plus"></i> Rent</button>
      @endif
        <form id="billingElectricForm" action=" /property/{{Session::get('property_id')}}/bills/electric/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
          @csrf
      </form>
      <input type="hidden" form="billingElectricForm" name="billing_option" value="electric">
        <button class="btn btn-primary"  type="submit" form="billingElectricForm" ><i class="fas fa-plus"></i> Electric</button>
      <form id="billingWaterForm" action="/property/{{Session::get('property_id')}}/bills/water/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
    </form>
    <input type="hidden" form="billingWaterForm" name="billing_option" value="water">
        <button class="btn btn-primary" type="submit" form="billingWaterForm" ><i class="fas fa-plus"></i> Water</button>
        <form id="billingSurchargeForm" action="/property/{{Session::get('property_id')}}/bills/surcharge/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
          @csrf
      </form>
      <input type="hidden" form="billingSurchargeForm" name="billing_option" value="surcharge">
          <button class="btn btn-primary" type="submit" form="billingSurchargeForm" ><i class="fas fa-plus"></i> Surcharge</button>
    </div>
  </div>
</div>
@if($bills->count() <=0 )
<p class="text-danger text-center">No bills found!</p>

@else
<div class="table-responsive">
  <table class="table">
    @foreach ($bills as $day => $bill)
<thead>
  <tr>
    <th colspan="12">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $bill->count() }}) </th>
</tr>
<tr>
  <?php $ctr=1;?>
  <th>#</th>
  <th>Bill No</th>
  
  
  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
  <th>Occupant</th>
  @else
  <th>Tenant</th>
  @endif
  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
  <th>Unit</th>
  @else
  <th>Room</th>
  @endif
  <th>Particular</th>
 
  <th colspan="2">Period Covered</th>
  <th>Amount</th>

  <td></td>
    
</tr>
</thead>
      @foreach ($bill as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
        <td>
        @if($item->bill_status === 'deleted')
        <strike> {{ $item->bill_no }}</strike>
        @else
        {{ $item->bill_no }}
        @endif
        </th>  
        {{-- <td>  {{ Carbon\Carbon::parse($item->date_posted)->format('M d Y') }}</td> --}}
       
        
        <th>
         @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
         <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
         @else
         <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
         @endif
          
        
        </th>
        <th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}#payments">{{ $item->building.' '.$item->unit_no }}</a>
          @else
          <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}#payments">{{ $item->building.' '.$item->unit_no }}</a>
          @endif
         
        </th>
        <td>{{ $item->particular }}</td>
       
        <td colspan="2">
          {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
          {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
        </td>
        <td>{{ number_format($item->amount,2) }}</td>
     
        <td class="text-center">
          @if($item->bill_status === 'deleted')
          <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/restore" method="POST">
            @csrf
            @method('put')
            
            <button title="restore this room" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-restore fa-sm text-dark-50"></i></button>
          </form> 
          @else
          @if(Auth::user()->user_type === 'manager')
          <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/delete" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
          </form>
          @endif
          @endif
       
        </td>
        </tr>
      @endforeach
          
        
    @endforeach
  </table>
  </div>
@endif
@endsection



@section('scripts')
  
@endsection



