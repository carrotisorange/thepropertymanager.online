@extends('layouts.argon.main')
@section('title', 'Billing Information Sheet')
@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Billing Information Sheet</h6>
    </div>
</div>
<div class="row">
    <div class="col-md-11 py-3 mx-auto">
        <div class="card">
                <h3>Bills</h3>
                <div class="form-row">
                    <table class="table">
                        <?php $ctr = 1; ?>
                        <thead>
                            <th>#</th>
                            <th>Bill no</th>
                            <th>Particular</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </thead>
                        {{-- @foreach ($inventories as $item)
                        <tbody>
                            <tr>
                                <td>{{ $ctr++ }}</td>
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
                        @endforeach --}}
                    </table>
                </div>
                <form id="createBillForm"
                    action="/property/{{ Session::get('property_id') }}/room/{{ $unit->unit_id }}/store/inventory"
                    method="POST">
                    @csrf
                </form>
                <h3>Additional bills</h3>
                <div class="form-row">
                    <table class="table table-responsive">
                        <tr>
                            <td>
                                <select class="form-control" form="createBillForm" name="particular_id_foreign" id="">
                                    <option value="{{ old('particular_id_foreign') }}" selected>
                                        {{ old('particular_id_foreign') }}
                                    </option>
                                 
                                </select>
                                @error('particular_id_foreign')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="date" value="{{ old('start') }}" name="start"
                                    id="start" class="form-control">
                                @error('start')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="date" value="{{ old('end') }}" name="end" id="end"
                                    class="form-control">
                                @error('end')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="number" min="1" value="{{ old('amount') }}"
                                    step="0.001" name="amount" id="amount" class="form-control">
                                @error('amount')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td> <button form="createBillForm" type="submit" class="btn btn-primary"
                                    onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>
                                    Add</button></td>
                        </tr>
                    </table>
                </div>

            </div>
            {{-- <div class="form-group">
       <div class="col text-center">
        <a href="#/" id="add_bill" ><i class="fas fa-plus"></i> Add</a>
       </div>
       
    </div> --}}

            <br>
            <div class="form-group col-md-11 mx-auto">
                <a class="btn btn-primary btn-block"
                    href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}"><i
                        class="fas fa-check"></i> Finish</a>
                {{-- <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}">Cancel</a>
                </p> --}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')

@endsection