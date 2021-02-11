@extends('layouts.argon.main')

@section('title', $property->name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $property->name }}</h6>
    
  </div>

</div>

  <form id="editPropertyForm" action="/property/{{Session::get('property_id')}}/" method="POST">
    @method('put')
    @csrf


<div class="row">
    <div class="col">
        <label>Name</label>
        <input form="editPropertyForm" class="form-control" type="text" name="name" value="{{ $property->name }}" >
        <input form="editPropertyForm" class="form-control" type="hidden" name="property_id" value="{{Session::get('property_id')}}" >
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label>Type</label>
        <select form="editPropertyForm" class="form-control" name="type" type="text" id="">
            <option value="{{ $property->type }}">{{ $property->type }}</option>
            <option value="Apartment Rentals">Apartment Rentals</option>
            <option value="Commercial Complex">Commercial Complex</option>
            <option value="Condominium Associations">Condominium Associations</option>
            <option value="Dormitory">Dormitory</option>
            <option value="House">House</option>
            <option value="Lot">Lot</option>
            <option value="Office">Office</option>
        </select>
    </div>
   
</div>
<br>
<div class="row">
    <div class="col">
        <label>Ownership</label>
        <select form="editPropertyForm" class="form-control" name="ownership" type="text" id="">
            <option value="{{ $property->ownership }}">{{ $property->ownership }}</option>
            <option value="Single Owner">Single Owner</option>
            <option value="Multiple Owners">Multiple Owners</option>
        </select>
    </div>
</div>
                
            
     
     <br>
     <div class="row">
        <div class="col">
            <label>Mobile</label>
            <input form="editPropertyForm" class="form-control" type="number" name="mobile" value="{{ $property->mobile }}" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <label>Address</label>
            <input form="editPropertyForm" class="form-control" type="text" name="address" value="{{ $property->address }}" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <label>Country</label>
            <input form="editPropertyForm" class="form-control" type="text" name="country" value="{{ $property->country }}" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <label>Zip</label>
            <input form="editPropertyForm" class="form-control" type="number" name="zip" value="{{ $property->zip }}" >
        </div>
    </div>
    <br>
         <div class="row">
         <div class="col">
          <p class="text-right">   
           
            <button type="submit" form="editPropertyForm" class="btn btn-primary" > Update</button>
        </p>   
         </div>
        </div>  
  



</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



