@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Payments</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-12 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
                <form id="createConcernForm"
                    action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/store/payment-options"
                    method="POST">
                    @csrf
                    @method('PUT')
                </form>
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Charge to:</label>

                        <form form="createConcernForm" name="payee"
                            action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/concern/action"
                            method="GET" onchange="submit();">
                            <select form="createConcernForm" class="form-control" name="payee">
                                <option value="{{ old('payee')?old('payee'):$concern->payee }}">
                                    {{ old('payee')?old('payee'):$concern->payee }}
                                </option>
                                <option value="tenant">Tenant</option>
                                <option value="owner">Owner</option>
                            </select>
                        </form>

                        @error('payee')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror



                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Payment options:</label>
                        <select form="createConcernForm" class="form-control" name="payment_options">
                            <option
                                value="{{ old('payment_options')?old('payment_options'):$concern->payment_options }}">
                                {{ old('payment_options')? old('payment_options'): $concern->payment_options }}</option>
                            <option value="deduct_from_remmittance">Deduct from remmittance</option>
                            <option value="pay_50%_before_and_50%_after">Pay 50% before and 50% after work</option>
                            <option value="add_to_bill">Add to bill</option>
                        </select>
                        @error('payment_options')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>

                </div>







                <div class="form-row">
                    <div class="form-group col-md-12 mx-auto">
                        <button type="submit" form="createConcernForm" class="btn btn-primary btn-block"
                            onclick="this.form.submit(); this.disabled = true;"> Finish</button>
                        <br>
                        <p class="text-center">
                            <a class="text-center text-dark"
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/approval">Back</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection