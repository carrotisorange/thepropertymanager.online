@extends('layouts.argon.main')

@section('title', 'Bills')

@section('css')
 <style>
/*This will work on every browser*/
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>   
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-3">
   <form action="/property/{{ Session::get('property_id') }}/bills/filter" method="GET" onchange="submit();">
    <select class="form-control" name="particular" id="">
      <option value="">All posted bills</option>
      @foreach ($property_bills as $item)
          <option value="{{ $item->particular_id }}">{{ $item->particular }} bills only</option>
      @endforeach
    </select>
   
   </form>
  </div>
  <div class="col text-right">
    <p class="text-right">
      <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBills" data-whatever="@mdo"><i class="fas fa-plus"></i> New</a> 
      <a href="#" class="btn btn-white btn-sm"><i class="fas fa-lightbulb"></i> Page tips</a>
    </p>
  </div>
</div>
@if($bills->count() <=0 )
<p class="text-danger text-center">No bills found!</p>

@else
<div class="row" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
  <table class="table table-hover">
<thead>

<tr>
  <th>Date</th>
  <th>Bill #</th>
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
</tr>
</thead>
<tbody>
  @foreach ($bills as $item)
  <tr>
    <th>{{ Carbon\Carbon::parse($item->date_posted)->format('d M, Y') }}</th>
    <th>{{ $item->bill_no }}</th>  
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
      {{ $item->start? Carbon\Carbon::parse($item->start)->format('d M, Y') : null}}-
      {{ $item->end? Carbon\Carbon::parse($item->end)->format('d M, Y') : null }}
    </td>
    <td>₱ {{ number_format($item->amount,2) }}</td>
 
    </tr>
  @endforeach
</tbody>
      
  
</table>
  </div>
@endif

<div class="modal fade" id="createBills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Select the bill you want to create</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
     
      <div class="modal-body">
        @foreach ($property_bills as $item)
        <form id="particular" action="/property/{{Session::get('property_id')}}/bill/{{ $item->particular_id }}" method="POST">
          @csrf
        </form>
        <div class="form-check">
          <input form ="particular" class="form-check-input" type="radio" name="particular_id" id="exampleRadios1" value="{{ $item->particular_id.'-'.$item->property_bill_id }}">
          <label class="form-check-label" for="exampleRadios1">
            {{ $item->particular }}
          </label>
        </div>
    
     @endforeach

      </div>
      <div class="modal-footer">
      <button type="submit" form="particular" class="btn btn-primary btn-sm" this.disabled = true;><i class="fas fa-check"></i> Create</button>  
      </div>
  </div>
  </div>
</div>

@endsection



@section('scripts')
  
@endsection



