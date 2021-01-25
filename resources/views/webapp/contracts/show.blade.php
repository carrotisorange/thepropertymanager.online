@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

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
            <li class="nav-item">
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
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
              <a class="nav-link" href="/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/system-updates" target="_blank">
                <i class="fas fa-bug text-red"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>
             {{--  <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Plugins</span>
              </a>
            </li> --}}
            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-8">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6>
    
  </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{-- <a href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}#contracts"  class="btn btn-primary"><i class="fas fa-user"></i> Tenant</a>  --}}
        <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/edit"><i class="fas fa-edit"></i> Edit</a>
        <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/extend"><i class="fas fa-external-link-alt"></i> Extend</a>
        @if(!$contract->terminated_at)
          @if($balance->count()>0)
          <a href="#" data-toggle="modal" data-target="#pendingBalance" class="btn btn-danger"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Terminate</a>
          @else
          <a class="btn btn-danger" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/preterminate"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Terminate</a>
          @endif
       @endif
        @if($contract->terminated_at)
          @if($balance->count()>0)
          <a href="#" data-toggle="modal" data-target="#pendingBalance" class="btn btn-danger"><i class="fas fa-sign-out-alt text-white-50"></i> Moveout</a>
          @else
            @if($contract->status != 'inactive')
            <a class="btn btn-success" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/moveout"><i class="fas fa-sign-out-alt text-white-50"></i>  Moveout</a>
            @endif
          @endif
        @endif
       
       
    </div>
    <div class="col-md-2 text-right">
        <form action="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="d-none d-sm-inline-block btn btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt"></i> Delete</button>
          </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                 {{-- <tr>
                     <th>Tenant </th>
                     <td><a target="_blank" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}">View</a></td>
                 </tr> --}}
                 <tr>
                  <th>Room </th>
                  <td><a target="_blank" href="/property/{{Session::get('property_id')}}/room/{{ $contract->unit_id_foreign }}">View</a></td>
              </tr>
              <tr>
                  <th>Referrer </th>
                  <td>
                    @if($contract->referrer_id_foreign != '36')
                    <a target="_blank" href="/property/{{Session::get('property_id')}}/user/{{ $contract->referrer_id_foreign }}">View</a>
                    @else
                    None
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>Source</th>
                  <td>{{ $contract->form_of_interaction }}</td>
              </tr>
              <tr>
                  <th>Rent</th>
                  <td>{{ number_format($contract->rent, 2) }}</td>
              </tr>
              <tr>
                  <th>Discount</th>
                  <td>{{  number_format($contract->discount, 2) }}</td>
              </tr>
              <tr>
                  <th>Status</th>
                  <td>{{ $contract->status }}</td>
              </tr>
              <tr>
                  <th>Movein</th>
                  <td>{{ Carbon\Carbon::parse($contract->movein_at)->format('M d, Y') }}</td>
              </tr>
              <tr>
                  <th>Moveout</th>
                  <td>{{ Carbon\Carbon::parse($contract->moveout_at)->format('M d, Y') }}</td>
              </tr>
              <tr>
                  <th>Length of stay</th>
                  <td>{{ $contract->number_of_months }}</td>
              </tr>
              <tr>
                  <th>Term</th>
                  <td>{{ $contract->term }}</td>
              </tr>
              <tr>
                  <th>Dater terminated</th>
                  <td>{{ $contract->terminated_at? Carbon\Carbon::parse($contract->terminated_at)->format('M d, Y'): 'NA' }}</td>
              </tr>
              <tr>
                  <th>Actual moveout</th>
                  <td>{{ $contract->actual_moveout_at? Carbon\Carbon::parse($contract->actual_moveout_at)->format('M d, Y'): 'NA' }}</td>
              </tr>
              <tr>
                  <th>Reason for termination</th>
                  <td>{{ $contract->moveout_reason? $contract->moveout_reason: 'NA' }}</td>
              </tr>
              {{-- <tr>
                  <th>Created at</th>
                  <td>{{ $contract->created_at? $contract->created_at: 'NA' }}</td>
              </tr>
              <tr>
                  <th>Updated at</th>
                  <td>{{ $contract->created_at? $contract->created_at: 'NA' }}</td>
              </tr> --}}
              </table>
          </div>
          </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pendingBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Balance</h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
       <p class="text-danger">Tenant needs to pay the balance to moveout.</p>
        <div class="row">
          <div class="col">
           
            <div class="table-responsive text-nowrap">
             
              <table class="table">
                <thead>
                <tr>
              
                  <th>Bill No</th>
                 
                  <th>Particular</th>
                  <th>Period Covered</th>
                  <th class="text-right" colspan="3">Amount</th>
                  
                </tr>
              </thead>
                @foreach ($balance as $item)
                <tr>
                
                    <td>{{ $item->bill_no }}</td>
            
                    <td>{{ $item->particular }}</td>
                    <td>
                      {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                      {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                    </td>
                    <td class="text-right" colspan="3">{{ number_format($item->balance,2) }}</td>
                           </tr>
                @endforeach
          
            </table>
            <table class="table">
              <tr>
               <th>TOTAL</th>
               <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
              </tr>    
            </table>
          </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" aria-label="Close" class="btn btn-primary"> Dismiss</a>
      </div>
      
  </div>
  </div>
</div>

@endsection

@section('scripts')
  
@endsection



