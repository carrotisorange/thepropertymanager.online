@extends('layouts.argon.main')

@section('title', 'Condo Dues Bills')

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
  <div class="col-md-9 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">You're about to post condue dues bills of rooms for {{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('M d, Y') }} - {{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('M d, Y') }}...</h6>
  </div>
  
  <div class="col-md-3 text-right">
    <a href="/property/{{Session::get('property_id')}}/bills"  class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back </a> 
    <a href="#" data-toggle="modal" data-target="#editPeriodCovered" class="btn btn-primary"><i class="fas fa-edit"></i> Options</a> 
  </div>
</div>

<div class="table-responsive text-nowrap">

  <form id="add_billings" action="/property/{{Session::get('property_id')}}/bills/create/" method="POST">
      @csrf
  </form>
    
    <table class="table">
   <thead>
    <tr>
      <th>#</th>
      <th>Occupant</th>
      @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
      <th>Unit</th>
      @else
      <th>Room</th>
      @endif
      <th colspan="2">Period Covered</th>     

   
    
      <th>Amount</th>
     

 
  </tr>
   </thead>
   <?php
     $ctr = 1;
     $desc_ctr = 1;
     $tenant_id = 1;
     $unit_id = 1;
     $unit_id_ctr = 1;
     $amt_ctr = 1;
     $id_ctr = 1;
     $start = 1;
     $end = 1;
   ?>   
   @foreach($active_tenants as $item)
  
   {{-- <input type="hidden" form="add_billings" name="ctr" value="{{ $ctr++ }}" required>      --}}
  
    <input type="hidden" form="add_billings" name="bill_tenant_id{{ $id_ctr++ }}" value="{{ $item->tenant_id }}" required>

    <input type="hidden" form="add_billings" name="bill_unit_id{{ $unit_id_ctr++ }}" value="{{ $item->unit_id }}" required>
  
    <input type="hidden" form="add_billings" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>

    <input type="hidden" form="add_billings" name="property_id" value="{{Session::get('property_id')}}" required>
  
    <tr>
      <td>
        {{ $ctr++ }}
      </td>
      <th>
        <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a>
        
      </th>
      <th>
          <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
      </th>
    
      <td>
       
        <input class="form-control" form="add_billings" type="date" name="start{{ $start++  }}" value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
      </td>
      <td> 
        <input class="form-control" form="add_billings" type="date" name="end{{ $end++  }}" value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>
       
    </td>
          <input class="" type="hidden" form="add_billings" name="tenant_id{{ $tenant_id++ }}" value="{{ $item->tenant_id }}" required readonly>
      
          <input class="" type="hidden" form="add_billings" name="particular{{ $desc_ctr++ }}" value="Condo Dues" required readonly>
      <td>
       @if(Session::get('property_id') === '85bb4890-1e63-11eb-a2eb-abe972caa65d')
        @if($item->building === 'Harvard' || $item->building === 'Princeton')
        <input class="form-control" form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"  value="525" oninput="this.value = Math.abs(this.value)">
        @else
        <input  class="form-control" form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"  value="950" oninput="this.value = Math.abs(this.value)">
        @endif
       @else
      
        <input class="form-control" form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"  value="" oninput="this.value = Math.abs(this.value)">
      
       @endif
          
    
      </td>
     
   </tr>
   @endforeach
  </table>
  
  </div>
  <br>
  <p class="text-right">
  <button type="submit" form="add_billings" class="btn btn-primary"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Post bills</button>
  </p>

  
  <div class="modal fade" id="editPeriodCovered" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="modal">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Options</h5>
    
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
     <div class="modal-body">
      <form id="periodCoveredForm" action="/property/{{Session::get('property_id')}}/bills/condodues/{{ $updated_start? Carbon\Carbon::parse($updated_start)->format('Y-m-d'): null }}-{{ Carbon\Carbon::parse($updated_end)->format('Y-m-d') }}/" method="POST">
        @csrf
      <div class="row">
        <div class="col">
        <label for="">Start</label>
        <input class="form-control" form="periodCoveredForm" type="date" name="start" value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
      </div>
      </div>
      <br>
      <div class="row">
        <div class="col">
        <label for="">End</label>
        <input class="form-control" form="periodCoveredForm" type="date" name="end" value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>
      </div>
      </div>
    

    </div>
    <div class="modal-footer">
      {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal"> Dismiss</button> --}}
     <button form="periodCoveredForm" type="submit" id="addBillsButton" class="btn btn-primary"> Update</button>
    </form>
    </div> 
    </div>
    </div>
    
    </div>

@endsection

@section('main-content')

@endsection

@section('scripts')
<script type="text/javascript">
  $(window).on('load',function(){
    $("#editPeriodCovered").modal({
            backdrop: 'static',
            keyboard: false
        });
  });
</script>
@endsection



