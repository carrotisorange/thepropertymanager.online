@extends('layouts.argon.main')

@section('title', $property->name)

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-auto text-left">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="/property/{{ Session::get('property_id') }}/rooms/">{{ $property->name }}</a></li>

                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>


    </div>
    {{-- <div class="col">
    <div class="alert alert-danger alert-dismissable custom-danger-box">
                    
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  
     
          <strong><i class="fas fa-info-circle"></i> Scroll the bar from left to right to see the delete/restore button. </strong>
        
      
  </div>
   </div> --}}
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form id="editPropertyForm" action="/property/{{ $property->property_id }}/update" method="POST">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Name</label>
                                <input form="editPropertyForm" class="form-control" type="text" name="name"
                                    value="{{ $property->name }}">
                                <input form="editPropertyForm" class="form-control" type="hidden" name="property_id"
                                    value="{{Session::get('property_id')}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>Type</label>
                                <select form="editPropertyForm" class="form-control" name="type" type="text" id="">
                                    <option value="{{ $property->type }}">{{ $property->type }}</option>
                                    <option value="7">7</option>
                                    <option value="6">6</option>
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
                                <input form="editPropertyForm" class="form-control" type="number" name="mobile"
                                    value="{{ $property->mobile }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>Address</label>
                                <input form="editPropertyForm" class="form-control" type="text" name="address"
                                    value="{{ $property->address }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>Country</label>
                                <input form="editPropertyForm" class="form-control" type="text" name="country"
                                    value="{{ $property->country }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>Zip</label>
                                <input form="editPropertyForm" class="form-control" type="number" name="zip"
                                    value="{{ $property->zip }}">
                            </div>
                        </div>
                        <br>
                       <div class="form-group">
                                <button type="submit" form="editPropertyForm" class="btn btn-primary btn-block"
                                    onclick="this.form.submit(); this.disabled = true;"> Save</button>
                                <br>
                                <p class="text-center">
                                    <a class="text-center text-dark" href="/property/all">Cancel</a>
                                </p>
                            </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')

@endsection