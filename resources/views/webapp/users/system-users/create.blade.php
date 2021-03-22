@extends('layouts.argon.dashboard')

@section('title', 'User')

@section('welcome')

<h1 class="text-white">Add New User Here! </h1>

@endsection

@section('content')

            <form class="user" method="POST" action="/user/store">
                @csrf
              
                
                    <div class="form-group">
                      <input id="name" type="text" value="" class="form-control form-control-user @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                  
                   {{-- <input type="hidden" name="property_id" value="{{Session::get('property_id')}}"> --}}
                   
                    <div class="form-group">
                        <input id="email" type="text" value="" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                      </div>

                    <div class="form-group">
                      <select name="user_type" id="user_type" class="form-control form-control-user @error('user_type') is-invalid @enderror" required autocomplete="user_type" autofocus>
                     
                        @if (old('user_type'))
                        <option value="{{ old('user_type') }}" selected>{{ old('user_type') }}</option>
                
                        <option value="admin">admin</option>
                        <option value="ap">ap</option>
                        <option value="billing">billing</option>
                    
                        <option value="treasury">treasury</option>
                        @else
                        <option value="">Select user role</option>
                        <option value="admin">admin</option>
                        <option value="ap">ap</option>
                        <option value="billing">billing</option>
              
                        <option value="treasury">treasury</option>
                        @endif
                       
                      </select>
                            @error('user_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    
                    <div class="form-group">
                        <input id="password" type="password" value="" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                      </div>

                   <div class="row">
                     <div class="col">
                      <a href="/property/all" class="btn btn-primary btn-user btn-block" ><i class="fas fa-home"></i> Home</a>
                     
                     </div>
                     <div class="col">
       
                      <a href="/user/all/" class="btn btn-primary btn-user btn-block"><i class="fas fa-user"></i> Users </a>
                  
                  </div>
                     <div class="col">
                      <button type="submit" class="btn btn-primary btn-user btn-block" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-user-plus"></i> Add</button>
                     </div>
                   </div>
                  </form>  
            
@endsection

@section('scripts')

@endsection

