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
              <a class="nav-link" href="/property/{{$property->property_id }}}/personnels">
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
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
                <i class="fas fa-bug text-red"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
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
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#bills">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
     
        <li class="breadcrumb-item active" aria-current="page">Statement of Accounts</li>
      </ol>
    </nav>
    
    
  </div>
</div>


<div class="row">
  <div class="col-md-12">
   
    <form id="editBillsForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/update" method="POST">
      @csrf
      @method('PUT')
    </form>
    {{-- <p class="text-right"> </p> --}}
    @if($balance->count() <=0)
    <p class="text-danger text-center">No bills found!</p>
    @else

    <div class="table-responsive text-nowrap">
      <table class="table">
        <?php $ctr=1; ?>
        <thead>
          <tr>
            <th class="text-center">#</th>
          
            <th>Bill No</th>
             <th>Room</th>
            <th>Particular</th>
            <th colspan="2">Period Covered</th>
            <th>Amount</th>
            <td></td>
          </tr>
        </thead>

        <?php
          $start_ctr = 1;
          $end_ctr = 1;
          $amount = 1;
          $billing_id_ctr =1;
        ?>
        <tbody>
        @foreach ($balance as $item)
        @if($item->bill_status === 'deleted')
        <tr class="bg-success">
          <th class="text-center">{{ $ctr++ }}</th>
          <td>
     
         {{ $item->bill_no }} <input form="editBillsForm" type="hidden" name="billing_id_ctr{{ $billing_id_ctr++ }}" value="{{ $item->bill_id }}">
       
        </td>
          <td>{{$item->unit_no}}</td>
          <td>{{ $item->particular }}</td>
          <td>
            <input form="editBillsForm" type="date" name="start_ctr{{ $start_ctr++ }}" value="{{ $item->start? Carbon\Carbon::parse($item->start)->format('Y-m-d') : null}}"> 
          </td>
          <td>
            <input form="editBillsForm"  type="date" name="end_ctr{{ $end_ctr++ }}" value="{{ $item->end? Carbon\Carbon::parse($item->end)->format('Y-m-d') : null }}">
          </td>
          <td><input form="editBillsForm" type="number" name="amount_ctr{{ $amount++ }}" step="0.01" value="{{  $item->balance }}"></td>
          <td>
            @if(Auth::user()->user_type === 'manager')
            @if($item->bill_status === 'deleted')

            @else
            <form action="/property/{{ $property->property_id }}/bill/{{ $item->bill_id }}" method="POST">
              @csrf
              @method('delete')
              <button title="remove this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
            </form>
            @endif
            
            @endif
          </td>   
        </tr>
        @else
        <tr>
          <th class="text-center">{{ $ctr++ }}</th>
          <td>
     
         {{ $item->bill_no }} <input form="editBillsForm" type="hidden" name="billing_id_ctr{{ $billing_id_ctr++ }}" value="{{ $item->bill_id }}">
       
        </td>
          <td>{{$item->unit_no}}</td>
          <td>{{ $item->particular }}</td>
          <td>
            <input form="editBillsForm" type="date" name="start_ctr{{ $start_ctr++ }}" value="{{ $item->start? Carbon\Carbon::parse($item->start)->format('Y-m-d') : null}}"> 
          </td>
          <td>
            <input form="editBillsForm"  type="date" name="end_ctr{{ $end_ctr++ }}" value="{{ $item->end? Carbon\Carbon::parse($item->end)->format('Y-m-d') : null }}">
          </td>
          <td><input form="editBillsForm" type="number" name="amount_ctr{{ $amount++ }}" step="0.01" value="{{  $item->balance }}"></td>
          <td>
            @if(Auth::user()->user_type === 'manager')
            @if($item->bill_status === 'deleted')

            @else
            <form action="/property/{{ $property->property_id }}/bill/{{ $item->bill_id }}" method="POST">
              @csrf
              @method('delete')
              <button title="remove this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
            </form>
            @endif
            
            @endif
          </td>   
        </tr>
        @endif
      
        @endforeach

        <tr>
          <th>TOTAL</th>
          <th colspan="6" class="text-right">{{ number_format($balance->sum('balance')-$deleted_bills,2) }} </th>
         </tr>  
         <tbody>  
    </table>
  </div>

  <p class="text-right"><button form="editBillsForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" > Update Bills And Message</button> </p>
  @endif
  
  <h6 class="h2 text-dark d-inline-block mb-0">This message will appear at the bottom of the statement of accounts.</h6>
  <br><br>
  <textarea form="editBillsForm" class="form-control" name="note" id="" cols="20" rows="10">
    {{ Auth::user()->note }}
    </textarea> 

 
  </div>

</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'note', {
      filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form',
  });
  </script>

@endsection



