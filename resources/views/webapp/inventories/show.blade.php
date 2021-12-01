@extends('layouts.argon.main')

@section('title', $unit->building.' '.$unit->unit_no.' | Show Inventory')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0"><a
                href="/property/{{ Session::get('property_id')}}/room/{{ $unit->unit_id }}#inventory">{{
                $unit->building.' '.$unit->unit_no }}</a>/ Show Inventory</h6>
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
                    <table class="table">
                        <?php $ctr = 1; ?>
                        <thead>
                            <th>#</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Updated on</th>
                            <th></th>
                        </thead>
                        @foreach ($inventories as $item)
                        <tbody>
                            <tr>
                                <td>{{ $ctr++ }}</td>
                                <td>{{ $item->item }}</td>
                                <td>{{ $item->remarks }}</td>
                                <td>{{ $item->update_quantity }}</td>
                                 <td>{{ Carbon\Carbon::parse($item->updated_on)->format('M d, Y') }}</td>
                               
                            </tr>
                        </tbody>

                        @endforeach
                    </table>
                </div>


            </div>
          
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection