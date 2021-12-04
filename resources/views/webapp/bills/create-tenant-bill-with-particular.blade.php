@extends('layouts.argon.main')

@section('title', 'Create Bill')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 d-inline-block mb-0"><a
                href="/property/{{ Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/#bills">{{
                $tenant->first_name.' '.$tenant->last_name }}</a>/ Create Bill/ {{ $particular->particular }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">

                <div class="form-group ">
                    <label><b>Room</b></label>
                    <select class="form-control" form="createBillForm" name="bill_unit_id" id="">
                        <option value="{{ old('bill_unit_id')? old('bill_unit_id'): ''}}" selected>
                            {{ old('bill_unit_id')? old('bill_unit_id'): 'Please select one' }}</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->unit_id }}">{{ $room->building.' '.$room->unit_no }}</option>
                        @endforeach
                    </select>
                    @error('bill_unit_id')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

             
                <label for=""><b>More details</b></label>
                <div class="form-row residential">

                    <div class="col-md-4">
                        <label>Rate </label>
                        <input class="form-control" form="createBillForm" type="number" value="{{ old('start') }}"
                            name="start" id="start" class="">
                        @error('start')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Previous </label>
                        <input class="form-control" form="createBillForm" type="number" value="{{ old('end') }}"
                            name="end" id="end" class="">
                        @error('end')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Current </label>
                        <input class="form-control" form="createBillForm" type="number" value="{{ old('end') }}"
                            name="end" id="end" class="">
                        @error('end')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>
                <br>
                <label for=""><b>Biling period</b></label>
                <div class="form-row residential">

                    <div class="col-md-6">
                        <label>Start </label>
                        <input class="form-control" form="createBillForm" type="date" value="{{ old('start') }}"
                            name="start" id="start" class="">
                        @error('start')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>End </label>
                        <input class="form-control" form="createBillForm" type="date" value="{{ old('end') }}"
                            name="end" id="end" class="">
                        @error('end')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>
                <br>
                <div class="form-group residential">
                    <label><b>Amount</b></label>
                    <input class="form-control" form="createBillForm" type="number" min="1" value="{{ old('amount') }}"
                        step="0.001" name="amount" id="amount" class="">
                    @error('amount')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" form="createBillForm" class="btn btn-primary btn-block"
                        onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Save</button>
                    <br>
                    <p class="text-center">
                        <a class="text-center text-dark" href="{{ url()->previous() }}/#certificates"><i
                                class="fas fa-times"></i> Cancel</a>
                    </p>
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

                <form id="createBillForm"
                    action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/particular/{{ $particular->particular_id }}/store/bill"
                    method="POST" >
                    @csrf
                </form>

                <div class="form-row">
                    <table class="table">
                        <?php $ctr = 1; ?>
                        <thead>
                            <th>#</th>
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
                                <td>{{ $item->bill_no }}</td>
                                <td>{{ $item->particular }}</td>
                                <td>{{ Carbon\Carbon::parse($item->start)->format('M d, Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($item->end)->format('M d, Y') }}</td>
                                <td>{{ number_format($item->balance , 2) }}</td>
                                <td><a class="text-danger" href="/bill/{{ $item->bill_id }}/delete/bill"><i
                                            class="fas fa-times"></i>
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
</div>
@endsection
