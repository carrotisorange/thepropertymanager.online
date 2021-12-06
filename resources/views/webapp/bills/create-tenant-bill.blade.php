@extends('layouts.argon.main')

@section('title', 'Create Bill')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 d-inline-block mb-0"><a
        href="/property/{{ Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/#bills">{{
        $tenant->first_name.' '.$tenant->last_name }}</a>/ Create Bill</h6>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="form-group ">
          <label><b>Particular</b></label>
          <form id="selectParticularForm"
            action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/post/particular" method="POST"
            onchange="submit();">
            @csrf
    
          <select class="form-control" form="selectParticularForm" name="particular_id_foreign" id="">
            <option value="{{ old('particular_id_foreign')? old('particular_id_foreign'): ''}}" selected>
              {{ old('particular_id_foreign')? old('particular_id_foreign'): 'Please select one' }}
            </option>
            @foreach ($particulars as $particular)
            <option value="{{ $particular->particular_id }}">{{ $particular->particular }}</option>
            @endforeach
          </select>
          </form>
        </div>
      </div>
    </div>
  </div>
  
</div>

<h2>Statement of accounts</h2>

<div class="row">
  <div class="col-md-12 py-3 mx-auto">
    <div class="card">
      <div class="card-body">


        <div class="form-row">
          <table class="table">
            <?php $ctr = 1; ?>
            <thead>
              <th>#</th>
              <th>Date posted</th>
              <th>Bill #</th>
              <th>Particular</th>
              <th>Start</th>
              <th>End</th>
              <th>Amount</th>
              <th></th>
            </thead>

            @foreach ($bills as $item)
            <tbody>
              <tr>
                <th>{{ $ctr++ }}</th>
                <td>{{ Carbon\Carbon::parse($item->date_posted)->format('M d, Y') }}</td>
                <td>{{ $item->bill_no }}</td>
                <td>{{ $item->particular }}</td>
                <td>{{ Carbon\Carbon::parse($item->start)->format('M d, Y') }}</td>
                <td>{{ Carbon\Carbon::parse($item->end)->format('M d, Y') }}</td>
                <td>{{ number_format($item->balance , 2) }}</td>
                <td><a class="text-danger" href="/bill/{{ $item->bill_id }}/delete/bill"><i class="fas fa-times"></i>
                    Remove</a></td>
              </tr>
            </tbody>

            @endforeach
            <tr>
              <th>Total</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <th>{{ number_format($bills->sum('balance'),2) }}</th>
              <td></td>
            </tr>

          </table>

        </div>


      </div>
      {{-- <div class="form-group">
        <div class="col text-center">
          <a href="#/" id="add_bill"><i class="fas fa-plus"></i> Add</a>
        </div>

      </div> --}}

      {{-- <br>
      <div class="form-group col-md-11 mx-auto">
        <a class="btn btn-primary btn-block"
          href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#bills">
          Finish</a>
        <br>

      </div> --}}
    </div>
  </div>
</div>
@endsection