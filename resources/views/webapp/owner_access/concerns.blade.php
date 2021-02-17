@extends('webapp.owner_access.template')

@section('title', 'Concerns')


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
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
    <table class="table">
      <?php $ctr = 1; ?>
      <thead>
        <tr>
          <th>#</th>
          
            <th>Date Reported</th>
           
          
           <th>Category</th>
            <th>Title</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Assigned to</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th></th>
       </tr>
      </thead>
      <tbody>
        @foreach ($concerns as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
       
          <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
            
        <td>{{ $item->category }}</td>
          
            <td>{{ $item->title }}</td>
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
                @if($item->concern_status === 'pending')
                <i class="fas fa-clock text-warning"></i> {{ $item->concern_status }}
                @elseif($item->concern_status === 'active')
                <i class="fas fa-snowboarding text-primary"></i> {{ $item->concern_status }}
                @else
                <i class="fas fa-check-circle text-success"></i> {{ $item->concern_status }}
                @endif
            </td>
            <?php $explode = explode(" ", $item->name );?>
           
            <td>{{ $item->name? $explode[0]: 'NULL' }}</td>
            <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
            <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
   
  </div>
       

@endsection

@section('scripts')
  
@endsection



