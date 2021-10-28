@extends('layouts.argon.dashboard')

@section('title', 'Create user')

@section('title')
<h1 class="text-white">Add New User Here! </h1>
@endsection

@section('content')
<div class="card-body px-lg-5 py-lg-5">

    <form class="user" method="POST" action="/user/store">
        @csrf


        <div class="form-group">
            <input id="name" type="text" value=""
                class="form-control form-control-user @error('name') is-invalid @enderror" placeholder="Name"
                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- <input type="hidden" name="property_id" value="{{Session::get('property_id')}}"> --}}

        <div class="form-group">
            <input id="email" type="text" value=""
                class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Email"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <select name="role_id_foreign" id="role_id_foreign"
                class="form-control form-control-user @error('user_type') is-invalid @enderror" required
                autocomplete="user_type" autofocus>

                <option value="{{ old('role_id_foreign') }}" selected>{{ old('role_id_foreign')?old('role_id_foreign'):'Select a role' }}</option>
                @foreach ($roles as $item)
                
                <option value="{{ $item->role_id }}">({{ $item->role }}) - {{ $item->privileges }}</option>
                @endforeach

            </select>
            @error('user_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>


        <div class="form-group">
            <input id="password" type="password" value=""
                class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password"
                name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-12">
            {{-- <div class="col">
                      <a href="/property/all" class="btn btn-primary btn-user btn-block btn-sm" ><i class="fas fa-home"></i> Go back to home</a>
                     
                     </div>
                     <div class="col">
       
                      <a href="/user/all/" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-eye"></i> See all users </a>
                  
                  </div>
                     <div class="col"> --}}
            <button type="submit" class="btn btn-primary btn-user btn-block"
                onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
            {{-- </div> --}}
            <br>
            <p class="text-center">
                <a class="text-center text-dark" href="/property/all"><i class="fas fa-arrow-left"></i> Cancel</a>
            </p>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

@endsection