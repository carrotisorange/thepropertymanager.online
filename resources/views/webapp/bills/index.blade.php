@extends('layouts.argon.main')

@section('title', 'Bulk billing')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-4">
    <h6 class="h2 text-dark d-inline-block mb-0">Bulk Billing</h6>
  </div>
  <div class="col text-right">
    <div class=" row">
      {{-- @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex') --}}
      <form id="billingCondoDuesForm" action="/property/{{Session::get('property_id')}}/bills/condodues/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
      </form>
      <input type="hidden" form="billingCondoDuesForm" name="billing_option" value="rent">
          <button class="btn btn-primary"  type="submit" form="billingCondoDuesForm"><i class="fas fa-plus"></i> Condo Dues</button>
      {{-- @else --}}
      <form id="billingRentForm" action="/property/{{Session::get('property_id')}}/bills/rent/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
      </form>
      <input type="hidden" form="billingRentForm" name="billing_option" value="rent">
          <button class="btn btn-primary"  type="submit" form="billingRentForm"><i class="fas fa-plus"></i> Rent</button>
      {{-- @endif --}}
        <form id="billingElectricForm" action=" /property/{{Session::get('property_id')}}/bills/electric/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
          @csrf
      </form>
      <input type="hidden" form="billingElectricForm" name="billing_option" value="electric">
        <button class="btn btn-primary"  type="submit" form="billingElectricForm" ><i class="fas fa-plus"></i> Electric</button>
      <form id="billingWaterForm" action="/property/{{Session::get('property_id')}}/bills/water/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
        @csrf
    </form>
    <input type="hidden" form="billingWaterForm" name="billing_option" value="water">
        <button class="btn btn-primary" type="submit" form="billingWaterForm" ><i class="fas fa-plus"></i> Water</button>
        <form id="billingSurchargeForm" action="/property/{{Session::get('property_id')}}/bills/surcharge/{{ Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}-{{ Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" method="POST">
          @csrf
      </form>
      <input type="hidden" form="billingSurchargeForm" name="billing_option" value="surcharge">
          <button class="btn btn-primary" type="submit" form="billingSurchargeForm" ><i class="fas fa-plus"></i> Surcharge</button>
    </div>
  </div>
</div>
@if($bills->count() <=0 )
<p class="text-danger text-center">No bills found!</p>

@else
<div class="table" >
  <table class="table table-condensed table-bordered table-hover">
    @foreach ($bills as $day => $bill)
<thead>
  <tr>
    <th colspan="8"></th>
  </tr>
  <tr>
    <th colspan="10">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $bill->count() }}) </th>
</tr>
<tr>
  <?php $ctr=1;?>
  {{-- <th>#</th> --}}
  <th>Bill No</th>
  
  
  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
  <th>Occupant</th>
  @else
  <th>Tenant</th>
  @endif
  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
  <th>Unit</th>
  @else
  <th>Room</th>
  @endif
  <th>Particular</th>
 
  <th colspan="2">Period Covered</th>
  <th>Amount</th>
{{-- 
  <td></td> --}}
    
</tr>
</thead>
      @foreach ($bill as $item)
      <tr>
        {{-- <th>{{ $ctr++ }}</th> --}}
        <td>
      
        {{ $item->bill_no }}
      
        </th>  
        {{-- <td>  {{ Carbon\Carbon::parse($item->date_posted)->format('M d Y') }}</td> --}}
       
        
        <th>
         @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
         <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
         @else
         <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
         @endif
          
        
        </th>
        <th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}#payments">{{ $item->building.' '.$item->unit_no }}</a>
          @else
          <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}#payments">{{ $item->building.' '.$item->unit_no }}</a>
          @endif
         
        </th>
        <td>{{ $item->particular }}</td>
       
        <td colspan="2">
          {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
          {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
        </td>
        <td>{{ number_format($item->amount,2) }}</td>
     
        {{-- <td class="text-center">
          @if($item->bill_status === 'deleted')
          <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/restore" method="POST">
            @csrf
            @method('put')
            
            <button title="restore this room" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-restore fa-sm text-dark-50"></i></button>
          </form> 
          @else
          @if(Auth::user()->user_type === 'manager')
          <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/delete" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
          </form>
          @endif
          @endif
       
        </td> --}}
        </tr>
      @endforeach
      <tr>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
     
        <th colspan="2"></th>
       
    
        <th>{{ number_format($bill->sum('amount'),2) }}</th>
        <th></th>
      </tr>
        
    @endforeach
  
  </table>
  </div>
@endif
@endsection



@section('scripts')
  
@endsection



