@extends('layouts.argon.main')

@section('title', 'Daily Collection Reports')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Daily Collection Reports</h6>
    
  </div>
  
  <div class="col-lg-6 col-5 text-right">
    <form  action="/property/{{ Session::get('property_id') }}/payments/search" method="GET" >
      @csrf
      <div class="input-group">
        <input type="date" class="form-control" name="search" required>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
    </div>
  </form
  </div>

</div>
</div>
<div class="row">
  <div class="col-md-12 text-center">
   {{-- <p class="text-left"> Showing <b>{{ $collections->count() }} </b> payments</p> --}}
    @if(Session::get(Auth::user()->id.'date'))
    <p class="text-center"> <span class=""> <small> You searched for payments made on </small></span> <span class="text-danger">"{{ Carbon\Carbon::parse( Session::get(Auth::user()->id.'date'))->format('M d, Y') }}"<span></p>
    @endif
  </div>
</div>
@if($collections->count() <=0 )
<p class="text-danger text-center">No collections found!</p>

@else
<div class="row" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
  
  <table class="table table-hover">
      @foreach ($collections as $day => $collection_list)
      <?php $ctr=1;?>
      <thead>
        <tr>
           <th colspan="7">{{ Carbon\Carbon::parse($day)->addDay()->format('M d, Y')}} ({{ $collection_list->count() }})</th>
           <th> <a title="export collections" target="_blank" href="/property/{{ Session::get('property_id') }}/payments/dates/{{Carbon\Carbon::parse($day)->addDay()->format('Y-m-d')}}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a></th>
        </tr>
    
   
        <tr>
          {{-- <th>#</th> --}}
          <th>AR No</th>
          <th>Bill No</th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <th></th>
          @else
          <th>Tenant</th>
          @endif
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <th>Unit</th>
          @else
          <th>Room</th>
          @endif
          <th>Particular</th>
          <th>Period Covered</th>
          {{-- <th>Form</th> --}}
          <th>Amount</th>
          <th></th>
          <th></th>
      
      </tr>

      </thead>
        @foreach ($collection_list as $item)
        <tr>
                {{-- <th>{{ $ctr++ }}</th> --}}
                <td> 
                  {{-- @if($item->payment_status === 'deleted')
                  <span class="text-danger"> {{ $item->ar_no }} (deleted)</span>
                  @else --}}
                  {{ $item->ar_no }}   
                  {{-- @endif --}}
                </td>
                <td>{{ $item->payment_bill_no }}</td>
                {{-- <td><a href="units/{{ $item->unit_id }}/tenants/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a></td> --}}

                
                <th>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}#payments">{{ $item->first_name.' '.$item->last_name }}</a>
                  @else
                  <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#payments">{{ $item->first_name.' '.$item->last_name }}</a>
                  @endif
                 
                </th>
                
                <th>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}#payments">{{ $item->unit_no }}</a>
                  @else
                  <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}#payments">{{ $item->unit_no }}</a>
                  @endif
                  
                </th>
                <td>{{ $item->particular }}</td>
                <td>
                  {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                  {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                </td>
                {{-- <td>{{ $item->form }}</td> --}}
                
                <th>
                  @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
                 <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/contract/{{ $item->contract_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/payment/{{ $item->payment_id }}/remittance/create">{{ number_format($item->amt_paid,2) }}</a> 
                  @else
                  {{ number_format($item->amt_paid,2) }}
                  @endif
                </th>
               
                <td>
               
                  <a title="export collections" target="_blank" href="/property/{{ Session::get('property_id') }}/unit/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/payment/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
    
                </td>
               {{-- <td>
                @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'treasury')
                  @if($item->payment_status === 'deleted')
                
                  @else
                  <form action="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}/payment/{{ $item->payment_id }}" method="POST">
                    @csrf
                    @method('delete')
                    <button title="archive this payment" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                  </form>
                  @endif
               @endif
               </td>
              --}}
            </tr>
        @endforeach
            <tr>
              <th>TOTAL</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th>{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
              <th></th>
              <th></th>
            </tr>
          
      @endforeach
  </table>
   </div>
@endif
@endsection

@section('scripts')
  
@endsection



