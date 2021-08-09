@extends('layouts.argon.main')

@section('title', 'Materials used')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Materials used</h6>
    </div>
</div>

  <div class="row">
    <div class="col-md-11 py-3 mx-auto">
      <div class="card">
        <div class="card-body">
      
          <div class="form-row">
            <table class="table table-responsive" >
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
                        <input form="createBillForm" type="text" value="{{ old('material') }}" name="material" id="material" class="form-control">
                        @error('material')
                        <small class="text-danger">
                          {{ $message }}
                        </small>
                      @enderror
                    </td>
                    <td>
                        <input form="createBillForm" type="number" value="{{ old('price') }}" name="price" id="price" class="form-control" oninput="autoCompute()">
                        @error('price')
                        <small class="text-danger">
                          {{ $message }}
                        </small>
                        @enderror
                    </td>
                    <td>
                        <input form="createBillForm" type="number" value="{{ old('quantity') }}" name="quantity" id="quantity" class="form-control" oninput="autoCompute()">
                        @error('quantity')
                        <small class="text-danger">
                          {{ $message }}
                        </small>
                      @enderror
                    </td>
                    <td>
                        <input form="createBillForm" type="number" min="1" value="{{ old('total_cost') }}" step="0.001" name="total_cost" id="total_cost" class="form-control" readonly>
                        @error('total_cost')
                        <small class="text-danger">
                          {{ $message }}
                        </small>
                      @enderror
                    </td>
                    <td> <button form="createBillForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Save</button></td>
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
                <td>{{ $item->description }}</td>
                <td>{{ number_format($item->price,2) }}</td>
                <td>{{ $item->quantity}}</td>
                <td>{{ number_format($item->total_cost, 2) }}</td>
                <th></th>
                {{-- <td><a class="text-danger" href="/material/{{ $item->material_id }}/delete"><i class="fas fa-times"></i> Remove</a></td> --}}
              </tr>
              </tbody>
              
              @endforeach 
              <tr>
             <th>Total</td>
             <td></td>
             <td></td>
             <td></td>
             <th>{{ number_format($materials->sum('total_cost'),2) }}</th>
            <th></th>
             </tr>

          </table>

      </div>
      <form id="createBillForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/store/materials" method="POST">
        @csrf
    </form>
     
     
      
      </div>
    
    <br>
    <div class="form-group col-md-11 mx-auto">
        <a class="btn btn-primary btn-block" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/#concerns"> Finish</a>
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





