@extends('layouts.argon.main')

@section('title', 'Remittance')

@section('upper-content')
@foreach ($remittance as $item)
<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Remittance # {{ $item->remittance_id }} </h6>
    <br>
    <small><a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}#remittances">Return to {{ $item->unit_no }}</a> </small>
  </div>

</div>

<form id="addRemittanceForm" action="/property/{{ Session::get('property_id') }}/remittance/{{ $item->remittance_id }}/update" method="POST">
    @csrf
    @method('PUT')
  </form>
  <div class="row">
    <div class="col-md-8 mx-auto">
     <label for="">Room</label>
     <input form="addRemittanceForm" type="text" class="form-control" name="unit_id" value="{{ $item->building.' '.$item->unit_no }}" required>
    </div>
 </div>
 <br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Remittance Amount</label>
    <input form="addRemittanceForm" type="number" class="form-control" name="amt_remitted" value="{{ $item->amt_remitted }}" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Date remitted</label>
    <input form="addRemittanceForm" type="date" class="form-control" name="dateRemitted" value="{{ Carbon\Carbon::parse($item->dateRemitted)->format('Y-m-d') }}" required>
   </div>
</div>
<br>
  <div class="row">
      <div class="col-md-12">
       <p class="text-right">
        
        
        <button type="submit" form="addRemittanceForm" class="btn btn-primary btn-user btn-block" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Update</button>
       </p>
      </div>
  </div>

@endforeach

@endsection

@section('main-content')

@endsection

@section('scripts')


@endsection



