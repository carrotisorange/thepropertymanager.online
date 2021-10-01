@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Materials</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-12 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
           <div class="form-row">
               <form id="createBillForm"
                        action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $concern->concern_tenant_id?$tenant->tenant_id:$tenant->owner_id }}/concern/{{ $concern->concern_id }}/store/materials"
                        method="POST">
                        @csrf
                    </form>
                    <table class="table table-responsive">
                        <thead>
                            <th>#</th>
                            <th>Material</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                        <tr>
                            <td></td>
                            <td>
                                <input form="createBillForm" type="text" value="{{ old('material') }}" name="material" id="material"
                                    class="form-control">
                                @error('material')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="number" value="{{ old('price') }}" name="price" id="price"
                                    class="form-control" oninput="autoCompute()">
                                @error('price')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="number" value="{{ old('quantity') }}" min="1" name="quantity" id="quantity"
                                    class="form-control" oninput="autoCompute()">
                                @error('quantity')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td>
                                <input form="createBillForm" type="number" min="1" value="{{ old('total_cost') }}" step="0.001"
                                    name="total_cost" id="total_cost" class="form-control" readonly>
                                @error('total_cost')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </td>
                            <td> <button form="createBillForm" type="submit" class="btn btn-primary"
                                    onclick="this.form.submit(); this.disabled = true;"> Save</button></td>
                        </tr>
                    </table>
                </div>

                <div class="form-row">
                            <table class="table">
                                <?php $ctr = 1; ?>
                        
                                @foreach ($materials as $item)
                                <tbody>
                                    <tr>
                                        <th>{{ $ctr++ }}</th>
                                        <td><input form=""type="text" value="{{ $item->description }}" name="material" id="material"
                                            class="form-control" readonly></td>
                                        <td><input form="" type="text" value="{{ $item->price }}" name="material" id="material" class="form-control" readonly></td>
                                        <td><input form="" type="text" value="{{ $item->quantity }}" name="material" id="material" class="form-control" readonly></td>
                                        <td><input form="" type="text" value="{{ $item->total_cost }}" name="material" id="material" class="form-control" readonly></td>
                                
                                         <td><a class="text-danger" href="/material/{{ $item->material_id }}/delete"><i
                                            class="fas fa-times"></i> Remove</a></td> 
                                    </tr>
                                </tbody>
                        
                                @endforeach
                                <tr>
                                    <th></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   
                                    <th><input form="" type="text" value="{{ $materials->sum('total_cost') }}" name="material" id="material" class="form-control" readonly></th>
                                    <th></th>
                                </tr>
                        
                            </table>
                        
                        </div>

                <div class="form-row">
                    <div class="form-group col-md-12 mx-auto">
                      <p class="text-center">
                        <a class="btn btn-block btn-primary"
                        href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $concern->concern_tenant_id?$tenant->tenant_id:$tenant->owner_id }}/concern/{{ $concern->concern_id }}/approval">Next</a>
                      </p>
                        
                        <p class="text-center">
                            <a class="text-center text-dark"
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/scope_of_work">Back</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function autoCompute() {
      var price = parseFloat(document.getElementById('price').value);
      var quantity = parseFloat(document.getElementById('quantity').value);
   
      document.getElementById('total_cost').value = price * quantity;
      
    //   document.getElementById(consumption).value = parseFloat(actual_consumption,2);
    //   document.getElementById(amt).value = parseFloat(actual_consumption) * rate;
     
    }
</script>
@endsection