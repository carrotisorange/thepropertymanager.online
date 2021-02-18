@extends('webapp.owner_access.template')

@section('title', 'Rooms')


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
    <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>
    
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
          <th>Enrollment Date</th>
          <th>Building</th>
            <th>Room</th>
            {{-- <th>Movein </th>
            <th>Moveout at</th> --}}
            <th>Status</th>
            <th>Rent(/month)</th>
            
        </tr>
       </thead>
       <tbody>
           @foreach ($rooms as $item)
               <tr>
                 <th>{{ $ctr++ }}</th>
                 <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                 <td>{{ $item->building }}</td>
                   <th><a href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/room/{{ $item->unit_id }}/contracts">{{ $item->unit_no }}</a></th>
                   {{-- <td>{{ $item->movein_at }}</td>
                   <td>{{ $item->moveout_at }}</td> --}}
                   <td>{{ $item->status }}</td>
                   <td>{{ number_format($item->rent,2) }}</td>
               </tr>
           @endforeach
       </tbody>
        
      </table>
    </div>

  </div>
@endsection

@section('scripts')
  
@endsection



