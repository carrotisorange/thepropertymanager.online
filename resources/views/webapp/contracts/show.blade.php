@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
            href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/">{{ $tenant->first_name.' '.$tenant->last_name }}</a>
        </li>
        <li class="breadcrumb-item"><a
            href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}#contracts">Contracts</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
      </ol>
    </nav>


  </div>
</div>
<div class="row">
  <div class="card card-body">
    <div class="col-md-10 mx-auto">
      <div class="form-group row">
        <div class="col">
          <label for="">Room</label>
        </div>
        <div class="col">
          <a target="_blank"
            href="/property/{{Session::get('property_id')}}/room/{{ $contract->unit_id_foreign }}">View</a>
        </div>

      </div>
      <div class="form-group row">
        <div class="col">
          <label for="">Referrer</label>
        </div>
        <div class="col">
          @if($contract->referrer_id_foreign != '36')
          <a target="_blank"
            href="/property/{{Session::get('property_id')}}/user/{{ $contract->referrer_id_foreign }}">View</a>
          @else
          None
          @endif
        </div>

      </div>
      <div class="form-group row">
        <div class="col">
          <label for="">Source</label>
        </div>
        <div class="col">
          {{ $contract->form_of_interaction }}
        </div>

      </div>
      <div class="form-group row">
        <div class="col">
          <label for="">Rent</label>
        </div>
        <div class="col">
          {{ number_format($contract->rent, 2) }}
        </div>

      </div>

      <div class="form-group row">
        <div class="col">
          <label for="">Discount</label>
        </div>
        <div class="col">
          {{  number_format($contract->discount, 2) }}
        </div>

      </div>

      <div class="form-group row">
        <div class="col">
          <label for="">Status</label>
        </div>
        <div class="col">
          @if($contract->status != 'active')
          <i class="fas fa-clock text-warning"></i> {{ $contract->status }}
          ({{ $contract->moveout_reason? $contract->moveout_reason: 'NOT AVAILABLE' }})
          @else
          <i class="fas fa-check-circle text-success"></i> {{ $contract->status }}
          @endif
        </div>

      </div>

      <div class="form-group row">
        <div class="col">
          <label for="">Contract</label>
        </div>
        <div class="col">
          {{ Carbon\Carbon::parse($contract->movein_at)->format('M d, Y') }} -
          {{ Carbon\Carbon::parse($contract->moveout_at)->format('M d, Y') }} ({{ $contract->number_of_months }})
          ({{ $contract->term }})
        </div>

      </div>

      <div class="form-group row">
        <div class="col">
          <label for="">Date terminated</label>
        </div>
        <div class="col">
          {{ $contract->terminated_at? Carbon\Carbon::parse($contract->terminated_at)->format('M d, Y'): 'NOT AVAILABLE' }}
        </div>

      </div>

      <div class="form-group row">
        <div class="col">
          <label for="">Actual moveout date</label>
        </div>
        <div class="col">
          {{ $contract->actual_moveout_at? Carbon\Carbon::parse($contract->actual_moveout_at)->format('M d, Y'): 'NOT AVAILABLE' }}
        </div>

      </div>



    </div>

  </div>
</div>
</div>

@endsection

@section('scripts')

@endsection