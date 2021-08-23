@extends('layouts.argon.main')

@section('title', 'Condo Dues Bills')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-9 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Condo Dues</h6>
  </div>

  <div class="col-md-3 text-right">
    <a href="/property/{{Session::get('property_id')}}/bills" class="btn btn-primary btn-sm"><i
        class="fas fa-arrow-left"></i> Back </a>
    <a href="#" data-toggle="modal" data-target="#editPeriodCovered" class="btn btn-primary btn-sm"><i
        class="fas fa-edit"></i> Options</a>
  </div>
</div>

<div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

  <form id="add_billings" action="/property/{{Session::get('property_id')}}/bills/create/" method="POST">
    @csrf
  </form>

  <table class="table table-condensed table-bordered table-hover">
    <thead>
      <tr>
        <th>#</th>
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
        <th colspan="2">Period Covered</th>
        <th>Amount <small class="text-danger">(Size*Dues)</small></th>
      </tr>
    </thead>
    <?php
     $ctr = 1;
     $desc_ctr = 1;
     $tenant_id = 1;
     $unit_id = 1;
     $unit_id_ctr = 1;
     $amt_ctr = 1;
     $id_ctr = 1;
     $start = 1;
     $end = 1;
   ?>
    @foreach($active_tenants as $item)

    {{-- <input type="hidden" form="add_billings" name="ctr" value="{{ $ctr++ }}" required> --}}

    <input type="hidden" form="add_billings" name="bill_tenant_id{{ $id_ctr++ }}" value="{{ $item->tenant_id }}"
      required>

    <input type="hidden" form="add_billings" name="bill_unit_id{{ $unit_id_ctr++ }}" value="{{ $item->unit_id }}"
      required>

    <input type="hidden" form="add_billings" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
      required>

    <input type="hidden" form="add_billings" name="property_id" value="{{Session::get('property_id')}}" required>

    <tr>
      <td>
        {{ $ctr++ }}
      </td>
      <th>
        <a
          href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a>

      </th>
      <th>
        <a
          href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
      </th>

      <td>

        <input form="add_billings" type="date" name="start{{ $start++  }}"
          value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
      </td>
      <td>
        <input form="add_billings" type="date" name="end{{ $end++  }}"
          value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>

      </td>
      <input class="" type="hidden" form="add_billings" name="tenant_id{{ $tenant_id++ }}"
        value="{{ $item->tenant_id }}" required readonly>

      <input class="" type="hidden" form="add_billings" name="particular{{ $desc_ctr++ }}" value="Condo Dues" required
        readonly>
      <td>
        {{-- @if(Session::get('property_id') === '85bb4890-1e63-11eb-a2eb-abe972caa65d')
        @if($item->building === 'Harvard' || $item->building === 'Princeton')
        <input class="form-control" form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"
        value="525" oninput="this.value = Math.abs(this.value)">
        @else
        <input class="form-control" form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"
          value="950" oninput="this.value = Math.abs(this.value)">
        @endif
        @else --}}
        <input form="add_billings" type="number" name="amount{{ $amt_ctr++ }}" step="0.01"
          value="{{ $item->condodues * $item->size }}" oninput="this.value = Math.abs(this.value)">
        {{-- @endif --}}
      </td>
    </tr>
    @endforeach
  </table>
</div>
<br>
<p class="text-right">
  <button type="submit" form="add_billings" class="btn btn-primary btn-sm"
    onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i
      class="fas fa-check"></i> Post bills</button>
</p>
<div class="modal fade" id="editPeriodCovered" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Options</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="periodCoveredForm"
          action="/property/{{Session::get('property_id')}}/bills/condodues/{{ $updated_start? Carbon\Carbon::parse($updated_start)->format('Y-m-d'): null }}-{{ Carbon\Carbon::parse($updated_end)->format('Y-m-d') }}/"
          method="POST">
          @csrf
          <div class="row">
            <div class="col">
              <label for="">Start</label>
              <input class="form-control" form="periodCoveredForm" type="date" name="start"
                value="{{ Carbon\Carbon::parse($updated_start)->startOfMonth()->format('Y-m-d') }}" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label for="">End</label>
              <input class="form-control" form="periodCoveredForm" type="date" name="end"
                value="{{ Carbon\Carbon::parse($updated_end)->endOfMonth()->format('Y-m-d') }}" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label for="">Condo Dues/Building/SQM</label>
              <table class="table">
                <?php 
            $building=1;
            $condodues=1;
           ?>
                @foreach($buildings as $item)
                <tr>
                  <th>{{ $item->building }}</th>
                  <td>
                    <input class="form-control" form="periodCoveredForm" type="hidden" name="building{{ $building++}}"
                      value="{{ $item->building }}" required>
                    <input class="form-control" form="periodCoveredForm" type="number" step="0.001"
                      name="condodues{{ $condodues++}}" value="{{ $item->condodues }}" required>
                  </td>
                </tr>
                @endforeach

              </table>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal"> Dismiss</button> --}}
        <button form="periodCoveredForm" type="submit" id="addBillsButton" class="btn btn-primary"> Update</button>
        </form>
      </div>
    </div>
  </div>

</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
<script type="text/javascript">
  $(window).on('load',function(){
    $("#editPeriodCovered").modal({
            backdrop: 'static',
            keyboard: false
        });
  });
</script>
@endsection