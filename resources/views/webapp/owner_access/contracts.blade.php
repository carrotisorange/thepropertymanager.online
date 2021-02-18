@extends('webapp.owner_access.template')

@section('title', 'Contracts')


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
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
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
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Contracts in <b>{{ $room->building.' '.$room->unit_no }}</b></h6>
    
  </div>
@endsection

@section('main-content')
<div class="container-fluid mt--6">
    <div class="table-responsive text-nowrap">
      <table class="table">
        <?php $ctr = 1; ?>
       <thead>
        <tr>
          <th>#</th>
          <th>Contract ID</th>
          <th>Started on</th>
            <th>Ended on</th>
            <th>Status</th>
            <th>Rent</th>
            <th>Moveout</th>
        </tr>
       </thead>
       <tbody>
           @foreach ($contracts as $item)
               <tr>
                 <th>{{ $ctr++ }}</th>
                 <td>{{ $item->contract_id }}</td>
                 <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                 <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ number_format($item->rent,2) }}</td>
                <td>{{ $item->moveout_reason? $item->moveout_reason: 'NA' }}</td>
               </tr>
           @endforeach
       </tbody>
        
      </table>
    </div>

  </div>
@endsection

@section('scripts')
  
@endsection



