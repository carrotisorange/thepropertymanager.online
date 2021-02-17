@extends('webapp.owner_access.template')

@section('title', 'Remittances')


@section('sidebar')

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Owner Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
              <i class="fas fa-file-signature text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
          </li>
  
        </ul>
      </div>
    </div>
  </div>
</nav>
@endsection

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Remittances</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
        <?php $ctr=1;?>
        <tr>
            <th>#</th>
            <th>Date Prepared</th>
            <th>Period Covered</th>
            <th>Particular</th>
            <th>CV</th>
            <th>Check #</th>
         
            <th>Status</th>
            <th>Amount</th>

        </tr>    
    </thead>
    <tbody>
        @foreach ($remittances as $item)
        <tr>
            <th>{{ $ctr++ }}</th>     
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
            
            <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td>
            <td>{{ $item->particular }}</td>
            <td>{{ $item->cv_number }}</td>
            <td>{{ $item->check_number }}</td>
            
           <td>
            @if($item->remitted_at === NULL)
            <span class="badge badge-danger">pending</span>
            @else
            <span class="badge badge-success">remitted</span>
            @endif
           </td>
            <th><a href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittance/{{ $item->remittance_id }}/expenses">{{ number_format($item->amt_remitted,2) }}</a></th>
        </tr>   
        @endforeach
       
        <tr>
          <th>TOTAL</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>{{ number_format($remittances->sum('amt_remitted'),2) }}</th>
        </tr>
    
    </tbody>
</table>
  </div>
       

@endsection

@section('scripts')
  
@endsection



