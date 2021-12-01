@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no.' | Add Inventory')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0"><a href="/property/{{ Session::get('property_id')}}/room/{{ $unit->unit_id }}#inventory">{{ $unit->building.' '.$unit->unit_no }}</a>/ Add Inventory</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-11 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
                <form id="createInventoryForm"
                    action="/property/{{ Session::get('property_id') }}/room/{{ $unit->unit_id }}/store/inventory"
                    method="POST">
                    @csrf
                </form>
                <div class="form-row">
                    <table class="table table-responsive">
                        <?php $ctr = 1; ?>
                        <thead>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th></th>
                        </thead>
                        <tr>
                               <input form="createInventoryForm" type="hidden" value="{{ $unit->unit_id }}" name="unit_id_foreign"
                                    id="unit_id_foreign" class="form-control">
                           
                            <td>
                                <input form="createInventoryForm" type="text" value="{{ old('item') }}" name="item"
                                    id="start" class="form-control">
                                @error('item')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createInventoryForm" type="text" value="{{ old('remarks') }}"
                                    name="remarks" id="remarks" class="form-control">
                                @error('remarks')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createInventoryForm" type="number" min="1" value="{{ old('quantity') }}"
                                    name="quantity" id="quantity" class="form-control">
                                @error('quantity')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td> <button form="createInventoryForm" type="submit" class="btn btn-primary"
                                    onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>
                                    Submit </button></td>
                        </tr>
                    </table>
                </div>
                <br><br>
                @if($inventories->count())
                <h2>Current inventories</h2>
                <div class="form-row">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th></th>
                        </thead>
                        @foreach ($inventories as $item)
                        <tbody>
                            <tr>
                                <td>{{ $ctr++ }}</td>
                                <td>{{ $item->item }}</td>
                                <td>{{ $item->remarks }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
