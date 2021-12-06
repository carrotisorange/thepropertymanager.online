@extends('layouts.argon.main')

@section('title', 'Bills')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-3">
    <form action="/property/{{ Session::get('property_id') }}/bills/filter" method="GET" onchange="submit();">
      <select class="form-control" name="particular" id="">
        <option value="">All posted bills</option>
        @foreach ($property_bills as $item)
        <option value="{{ $item->particular_id }}">{{ $item->particular }} bills</option>
        @endforeach
      </select>

    </form>
  </div>
  <div class="col-md-3">
    <form action="/property/{{ Session::get('property_id') }}/bills/search" method="GET">
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
      <a href="/property/{{ Session::get('property_id') }}/bills/create" class="btn btn-primary" ><i
          class="fas fa-plus"></i> Add</a>
      <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createBills" data-whatever="@mdo"><i
          class="fas fa-plus"></i> New</a>
      <a href="/property/1e2ee7c0-ca86-11eb-b90a-576ba19a581f/bills/edit" class="btn btn-primary"><i
          class="fas fa-edit"></i> Edit</a>
      <a href="/property/{{ Session::get('property_id') }}/bills" class="btn btn-primary"><i
          class="fas fa-eraser"></i> Clear</a>
      {{-- <a href="#" class="btn btn-white btn-sm"><i class="fas fa-lightbulb"></i> Page tips</a> --}}
    </p>
  </div>
</div>


<h3 class="text-center">
  <span class=""> <small> Showing <b>{{ $bills->count() }} </b> of {{ $count_bills }}
      {{ Str::plural('bill', $count_bills) }}</span></small>
</h3>

{{-- @if(!$bills->count())
<p class="text-danger text-center">No bills found!</p>

@else --}}

  <table class="table table-hover">
    <thead>

      <tr>
  
        <th>Date posted</th>
        <th>Bill No</th>
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type')
        === '6')
        <th>Occupant</th>
        @else
        <th>Tenant</th>
        @endif
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type')
        === '6')
        <th>Unit</th>
        @else
        <th>Room</th>
        @endif
        <th>Particular</th>

        <th colspan="2">Period Covered</th>
        <th>Amount</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
   @each('webapp.bills.includes.bills', $bills, 'bill', 'webapp.tenants.includes.no-record')
    </tbody>


  </table>
  {{ $bills->links() }}

{{-- @endif --}}

<div class="modal fade" id="createBills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
        <form id="particular" action="/property/{{Session::get('property_id')}}/bill/{{ $item->particular_id }}"
          method="POST">
          @csrf
        </form>
        <div class="form-check">
          <input form="particular" class="form-check-input" type="radio" name="particular_id" id="exampleRadios1"
            value="{{ $item->property_bill_id }}">
          <label class="form-check-label" for="exampleRadios1">
            {{ $item->particular }}
          </label>
        </div>

        @endforeach

      </div>
      <div class="modal-footer">
        <button type="submit" form="particular" class="btn btn-primary btn-block"
          onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>  Submit</button>
      </div>
    </div>
  </div>
</div>

@endsection



@section('scripts')

@endsection