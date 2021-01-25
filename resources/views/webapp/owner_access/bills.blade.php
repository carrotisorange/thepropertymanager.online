@extends('webapp.owner_access.template')

@section('title', 'Bills')


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
          <li class="nav-item">
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li>
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
           <th>Date posted</th>
           <th>Room</th>
             {{-- <th>Bill no</th> --}}
             
             <th>Particular</th>
       
             <th>Period covered</th>
             
             <th class="text-right" >Bill amount</th>
             <th class="text-right" >Amount paid</th>
             <th class="text-right" >Balance</th>
             {{-- <th></th> --}}
           </tr>
      </thead>
        @foreach ($bills as $item)
        <tr>
       <th class="text-center">{{ $ctr++ }}</th>
          <td>
            {{Carbon\Carbon::parse($item->date_posted)->format('M d Y')}}
          </td>   
           
          <td>{{ $item->unit_no }}</td>
            {{-- <td>{{ $item->bill_no }}</td> --}}
    
            <td>{{ $item->particular }}</td>
          
            <td>
              {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
              {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
            </td>
            <td class="text-right"  >{{ number_format($item->amount,2) }}</td>
            <td class="text-right"  >{{ number_format($item->amt_paid,2) }}</td>
            <td class="text-right" >
              @if($item->balance > 0)
              <span class="text-danger">{{ number_format($item->balance,2) }}</span>
              @else
              <span >{{ number_format($item->balance,2) }}</span>
              @endif
            </td>
            {{-- <td class="text-center">
              @if(Auth::user()->user_type === 'manager')
              <form action="/property/{{ $property->property_id }}/tenant/{{ $item->bill_tenant_id }}/bill/{{ $item->billing_id }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
              </form>
              @endif
            </td> --}}
                   </tr>
                   
        @endforeach
        <tr>
          <th>TOTAL </th>
          
          <th class="text-right" colspan="5">{{ number_format($bills->sum('amount'),2) }} </th>
          <th class="text-right" colspan="">{{ number_format($bills->sum('amt_paid'),2) }} </th>
          <th class="text-right text-danger" colspan="">
            @if($bills->sum('balance') > 0)
            <span class="text-danger">{{ number_format($bills->sum('balance'),2) }}</span>
            @else
            <span >{{ number_format($bills->sum('balance'),2) }}</span>
            @endif
       
           </th>
         </tr>
      
    </table>
   
  </div>
  </div>
@endsection

@section('scripts')
  
@endsection



