@extends('layouts.argon.main')

@section('title', 'Remittance')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Remittance # {{ $remittance->remittance_id }} </h6>
    <br>
    <small><a href="/property/{{ Session::get('property_id') }}/remittances">Return to Remittances</a> </small>
  </div>

</div>

<form id="addRemittanceForm" action="/property/{{ Session::get('property_id') }}/remittance/{{ $remittance->remittance_id }}/update" method="POST">
    @csrf
    @method('PUT')
  </form>
  <div class="row">
    <div class="col-md-8 mx-auto">
     <label for="">Room</label>
     <input form="addRemittanceForm" type="text" class="form-control" name="unit_id" value="{{ $room->building.' '.$room->unit_no }}" readonly required>
    </div>
 </div>
 <br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Remitted amount</label>
    <input form="addRemittanceForm" type="number" class="form-control" name="amt_remitted" value="{{ $remittance->amt_remitted }}" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Date remitted</label>
    <input form="addRemittanceForm" type="date" class="form-control" name="remitted_at" value="{{ Carbon\Carbon::parse($remittance->remitted_at)->format('Y-m-d') }}" required>
   </div>
</div>
<br>
<p class="text-right">
   <button type="submit" form="addRemittanceForm" class="btn btn-success btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;">  <i class="fas fa-check"></i> Mark as deposited</button>

</p>


@endsection

@section('main-content')

@endsection

@section('scripts')


@endsection



