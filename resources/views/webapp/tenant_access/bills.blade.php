@extends('webapp.tenant_access.template')

@section('title', 'Bills')


@section('sidebar')

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Tenant Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/rooms">
              <i class="fas fa-home text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concerns">
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="examples/login.html">
              <i class="ni ni-key-25 text-info"></i>
              <span class="nav-link-text">Login</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="examples/register.html">
              <i class="ni ni-circle-08 text-pink"></i>
              <span class="nav-link-text">Register</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="examples/upgrade.html">
              <i class="ni ni-send text-dark"></i>
              <span class="nav-link-text">Upgrade</span>
            </a>
          </li> --}}
        </ul>
        <!-- Divider -->
        {{-- <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Documentation</span>
        </h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html" target="_blank">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Getting started</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html" target="_blank">
              <i class="ni ni-palette"></i>
              <span class="nav-link-text">Foundation</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html" target="_blank">
              <i class="ni ni-ui-04"></i>
              <span class="nav-link-text">Components</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
              <i class="ni ni-chart-pie-35"></i>
              <span class="nav-link-text">Plugins</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active active-pro" href="examples/upgrade.html">
              <i class="ni ni-send text-dark"></i>
              <span class="nav-link-text">Upgrade to PRO</span>
            </a>
          </li> --}}
        </ul>
      </div>
    </div>
  </div>
</nav>
@endsection

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Bills</h6>
    
  </div>
@endsection

@section('main-content')
<div class="table-responsive">
    <div class="table-responsive text-nowrap">
      <table class="table">
        <?php $ctr=1; ?>
       <thead>
        <tr>
            <th class="text-center">#</th>
             <th>Date Billed</th>
               <th>Bill No</th>
               
               <th>Description</th>
               <th>Period Covered</th>
               <th class="text-right" colspan="3">Amount</th>
               
             </tr>
       </thead>
        @foreach ($bills as $item)
        <tr>
       <th class="text-center">{{ $ctr++ }}</th>
          <td>
            {{Carbon\Carbon::parse($item->date_posted)->format('M d Y')}}
          </td>   

            <td>{{ $item->bill_no }}</td>
    
            <td>{{ $item->particular }}</td>
            <td>
              {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
              {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
            </td>
            <td class="text-right" colspan="3">{{ number_format($item->amount,2) }}</td>
        </tr>
        @endforeach
  
    </table>
    <table class="table">
      <tr>
       <th>Total</th>
       <th class="text-right">{{ number_format($bills->sum('balance'),2) }} </th>
      </tr>
    
    </table>
  </div>
  </div>
@endsection

@section('scripts')
  
@endsection



