@extends('layouts.argon.main')

@section('title', 'Credit memo')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Credit memo</h6>
    </div>
</div>
<form id="addCreditMemoForm"
    action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/payment/{{ $payment->payment_id }}/credit-memo"
    method="POST">
    @csrf
</form>


<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Date</label>
                    <input form="addCreditMemoForm" type="date" class="form-control" name="payment_created"
                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>

                    @error('payment_created')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input form="addCreditMemoForm" type="number" class="form-control" name="amt_paid" value=""
                        step="any" required>

                    @error('amt_paid')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" form="addCreditMemoForm" class="btn btn-primary btn-block"
                        onclick="this.form.submit(); this.disabled = true;"> Save</button>
                    <br>
                    <p class="text-center">
                        <a class="text-center text-dark"
                            href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#payments">Cancel</a>
                    </p>
                </div>



            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection