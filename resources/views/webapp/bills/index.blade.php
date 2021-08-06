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
  <div class="col-md-3">
    <form  action="/property/{{ Session::get('property_id') }}/bills/search" method="GET" >
      @csrf
      <div class="input-group">
        <input type="date" class="form-control" name="search" required>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
    </div>
  </div>

  <div class="col text-right">
    <p class="text-right">
      <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#createBills" data-whatever="@mdo"><i class="fas fa-plus"></i> New</a> 
      <a  href="/property/1e2ee7c0-ca86-11eb-b90a-576ba19a581f/tenant/966/bills/edit" class="btn btn-primary" ><i class="fas fa-edit"></i> Edit SOA</a> 
      <a  href="/property/1e2ee7c0-ca86-11eb-b90a-576ba19a581f/bills" class="btn btn-primary" ><i class="fas fa-eraser"></i> Clear</a>  
      {{-- <a href="#" class="btn btn-white btn-sm"><i class="fas fa-lightbulb"></i> Page tips</a> --}}
    </p>
  </div>
</div>
<div class="row">
  <div class="col-md-12 text-center">
   {{-- <p class="text-left"> Showing <b>{{ $collections->count() }} </b> payments</p> --}}
    @if(Session::get(Auth::user()->id.'date'))
    <p class="text-center"> <span class=""> <small> Showing {{ $bills->count() }} bills posted on </small></span> <span class="text-danger">"{{ Carbon\Carbon::parse( Session::get(Auth::user()->id.'date'))->format('M d, Y') }}"<span></p>
    @endif
  </div>
</div>
@if($bills->count() <=0 )
<p class="text-danger text-center">No bills found!</p>

@else
<div class="row" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
  <table class="table table-hover">
<thead>

<tr>
  <th>#</th>
  <th>Date</th>
  <th>Bill #</th>
  @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
  <th>Occupant</th>
  @else
  <th>Tenant</th>
  @endif
  @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
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
  <?php $ctr=1;?>
  @foreach ($bills as $item)
  <tr>
    <th>{{ $ctr++ }}</th>
    <th>{{ Carbon\Carbon::parse($item->date_posted)->format('d M, Y') }}</th>
    <th>{{ $item->bill_no }}</th>  
    <th>
     @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
     <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
     @else
     <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/#bills">{{ $item->first_name.' '.$item->last_name }}</a>
     @endif
    </th>
    <th>
      @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
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
      <button type="submit" form="particular" class="btn btn-primary" this.disabled = true;><i class="fas fa-check"></i> Create</button>  
      </div>
  </div>
  </div>
</div>

@endsection



@section('scripts')
  
@endsection



