@extends('layouts.argon.main')

@section('title', 'Suppliers')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">New Supplier</h6>
    </div>

</div>

<form id="addSupplierForm" action="/property/{{Session::get('property_id')}}/suppliers/store" method="POST">
    @csrf
</form>
<div class="form-group row">
    <div class="col">
        <label>Name</label>
        <input form="addSupplierForm" class="form-control" type="text" name="name" value="" required>
    </div>
    <div class="col">
        <label>Mobile</label>
        <input form="addSupplierForm" class="form-control" type="number" name="mobile" value="" required>
    </div>
    <div class="col">
        <label>Email</label>
        <input form="addSupplierForm" class="form-control" type="email" name="email" value="" required>
    </div>
</div>
<div class="form-group row">
    <div class="col">
        <label>Representative</label>
        <input form="addSupplierForm" class="form-control" type="text" name="representative" value="" required>
    </div>
</div>
<div class="form-group row">
    <div class="col">
        <label>Description</label>
        <textarea class="form-control" form="addSupplierForm" name="description" rows="4" cols="50"></textarea>
    </div>
</div>
<div class="form-group row">
    <div class="col">
        <p class="text-right">
            <button type="submit" form="addSupplierForm" class="btn btn-primary btn-sm"><i class="fas fa-check"></i>
                Submit</button>
        </p>
    </div>
</div>
@endsection



@section('scripts')

@endsection