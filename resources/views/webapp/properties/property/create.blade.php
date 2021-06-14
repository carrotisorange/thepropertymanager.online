@extends('layouts.argon.dashboard')

@section('title', 'Step 1 of 5 | The Property Manager')
@section('title-page')
<div class="row">
  <div class="col">
    <h2 class="text-left"><i class="fas fa-building"></i> Property</h2>
  </div>
  <div class="col">
    <h3 class="text-right">Step 1 of 5</h3>
  </div>
</div>
@endsection

@section('content')

            <form class="user" method="POST" action="/property">
                @csrf
                  {{-- <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Your Property Here! </h1> --}}
                    {{-- <b class="text-success">All existing rooms, tenants, owners, etc. will be migrated to this new property.</b> --}}
{{--                     
                  </div>
                  <br> --}}
                    <div class="form-group">
                      <label for="">1. Name of your property</label>
                      <input id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" placeholder="Property Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                      <label for="">2. Select your property type</label>
                      {{-- <select name="type" id="type" class="form-control form-control-user @error('type') is-invalid @enderror" required autocomplete="type" autofocus> --}}
                      
                      {{-- @if (old('type'))
                        <option value="{{ old('type') }}" selected>{{ old('type') }}</option>
                        @foreach ($property_types as $item)
                        <option value="{{ $item->property_type_id }}">{{ $item->property_type }}</option>
                     @endforeach
                        
                    
                        @else --}}
      
                 
                          @foreach ($property_types as $item)
                          <div class="form-check">
                            <input class="form-check-input form-control-user @error('property_type_id') is-invalid @enderror" type="radio" name="property_type_id_foreign" id="exampleRadios1" value="{{ $item->property_type_id }}">
                            <label class="form-check-label" for="exampleRadios1">
                              <b>{{ $item->property_type }}</b> - {{ $item->description }}
                            </label>
                          </div>
                      
                       @endforeach
                          
                       @error('property_type_id')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               
               
                      {{-- @endif --}}
                       
                      {{-- </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                    </div>

                    {{-- <div class="form-group">
                      <select name="ownership" id="ownership" class="form-control form-control-user @error('ownership') is-invalid @enderror" name="ownership" required autocomplete="ownership" autofocus>
            
                        @if (old('ownership'))
                        <option value="{{ old('ownership') }}" selected>{{ old('ownership') }}</option>
                        <option value="Multiple Owners">Multiple Owners</option>
                        <option value="Single Owner">Single Owner</option>
                      
                        @else
                      <option value="">Select your property ownership</option>
                        <option value="Multiple Owners">Multiple Owners</option>
                        <option value="Single Owner">Single Owner</option> 
                        @endif

                      </select>
                            @error('ownership')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div> --}}

              
                    
                    <div class="form-group">
                      <label for="">3. Contact number of your property</label>
                      <input id="mobile" type="number" class="form-control form-control-user @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                   
                    <div class="form-group">
                      <label for="">4. Address of your property</label>
                      <input id="address" type="text" class="form-control form-control-user @error('address') is-invalid @enderror" placeholder="Address" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                   
                     
                    <div class="form-group">
                     <div class="row">
                      <div class="col">
                        <label for="">5. Country</label>
                        <select name="country_id_foreign" id="country_id_foreign" class="form-control form-control-user @error('country_id_foreign') is-invalid @enderror" required autocomplete="country_id_foreign" autofocus>
                          <option value="31" selected>Philippines</option>
                          @foreach ($countries as $item)
                           
                              <option value="{{ $item->country_id }}">{{ $item->country }}</option> 
                          @endforeach
                        </select>
                        @error('country_id_foreign')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       </div>
                       <div class="col">
                        <label for="">6. Zipcode</label>
                        <input id="zip" type="number" class="form-control form-control-user @error('zip') is-invalid @enderror" placeholder="Zip" name="zip" value="{{ old('zip') }}" required autocomplete="zip" autofocus>
                        @error('zip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       </div>
                     </div>
                    </div>
                 
                   <div class="row">
                    <div class="col">
                      <p class="text-left">
                        <a href="/property/all" class="btn btn-primary"><i class="fas fa-home"></i> Home</a>
                      </p>
                     </div>
             
                     <div class="col">
                      <p class="text-right">
                        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-arrow-right"></i> Next</button>
                      </p>
                     </div>
                   </div>
                  </form>  
            
@endsection

@section('scripts')

@endsection

