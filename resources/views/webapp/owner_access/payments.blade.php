@extends('webapp.owner_access.template')

@section('title', 'Payments')



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
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
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
    <h6 class="h2 text-dark d-inline-block mb-0">Payments</h6>
    
  </div>
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
    <table class="table">
        @foreach ($payments as $day => $collection_list)
         <thead>
            <tr>
                <th colspan="10">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $collection_list->count() }})</th>
                
            </tr>
            <tr>
              <?php $ctr = 1; ?>
                <th class="text-center">#</th>
                <th>AR No</th>
                <th>Bill No</th>
          
                <th>Particular</th>
                <th colspan="2">Period Covered</th>
                <th>Form</th>
                <th class="text-right">Amount</th>
            
                </tr>
          </tr>
         </thead>
          @foreach ($collection_list as $item)
         
          <tr>
                <th class="text-center">{{ $ctr++ }}</th>
                  <td>{{ $item->ar_no }}</td>
                  <td>{{ $item->payment_bill_no }}</td>
                    {{-- <td>{{ $item->building.' '.$item->unit_no }}</td>  --}}
                   <td>{{ $item->particular }}</td> 
                   <td colspan="2">
                    {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                    {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                  </td>
                  <td>{{ $item->form }}</td>
                  <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
                  
                  {{-- <td class="">
                    <a title="export" target="_blank" href="/units/{{ $item->unit_tenant_id }}/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a> --}}
                    {{-- <a target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a> 
                  
                  </td>  --}}
                  {{-- <td class="text-center">
                    @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
                    <form action="/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}" method="POST">
                      @csrf
                      @method('delete')
                      <button title="delete" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-times fa-sm text-white-50"></i></button>
                    </form>
                    @endif
                  </td>    --}}
                 
              </tr>
          @endforeach
              <tr>
                <th>TOTAL</th>
                <th colspan="8" class="text-right">{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
              </tr>
              
        @endforeach
    </table>
  </div>
@endsection

@section('scripts')
  
@endsection



