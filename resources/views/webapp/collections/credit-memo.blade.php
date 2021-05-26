@extends('layouts.argon.main')

@section('title', 'Credit memo')

@section('upper-content')

<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Payment # {{ $payment->payment_id }} </h6>
  </div>

</div>

<form id="addCreditMemoForm" action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/payment/{{ $payment->payment_id }}/credit-memo" method="POST">
    @csrf
  </form>

 <br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Date </label>
    <input form="addCreditMemoForm" type="date" class="form-control" name="payment_created" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
   </div>
</div>
 <br>
<div class="row">
   <div class="col-md-8 mx-auto">
    <label for="">Amount to be credited</label>
    <input form="addCreditMemoForm" type="number" class="form-control" name="amt_paid" value="" step="any" required>
   </div>
</div>
<br>
<div class="row">
    <div class="col">
        <p class="text-right">
            <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}#payments" class="btn btn-primary btn-sm text-white"><i class="fas fa-arrow-left"></i> Back</a>
         </p>
    </div>
    <div class="col">
        <p class="text-left">
            <button type="submit" form="addCreditMemoForm" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;">  <i class="fas fa-check"></i> Submit </button>
        </p>
    </div>
</div>


@endsection

@section('main-content')

@endsection

@section('scripts')


@endsection



