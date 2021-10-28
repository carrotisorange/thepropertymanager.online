@extends('layouts.argon.dashboard')

@section('title', 'Step 1 of 5 | The Property Manager')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
  <form class="user" method="POST" action="/property">
    @csrf
    <div class="form-group">
      <input id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
        placeholder="Property Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
      @error('name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-group">
      <label for="">Property type</label>
      @foreach ($property_types as $item)
      <div class="form-check">
        <input class="form-check-input form-control-user @error('property_type_id') is-invalid @enderror" type="radio"
          name="property_type_id_foreign" id="exampleRadios1" value="{{ $item->property_type_id }}" required>
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
    </div>
    <div class="form-group">
      <input id="mobile" type="number" class="form-control form-control-user @error('mobile') is-invalid @enderror"
        placeholder="Mobile" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
      @error('mobile')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-group">
      <input id="address" type="text" class="form-control form-control-user @error('address') is-invalid @enderror"
        placeholder="Address" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
      @error('address')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col">

          <select name="country_id_foreign" id="country_id_foreign"
            class="form-control form-control-user @error('country_id_foreign') is-invalid @enderror" required
            autocomplete="country_id_foreign" autofocus>
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

          <input id="zip" type="number" class="form-control form-control-user @error('zip') is-invalid @enderror"
            placeholder="Zip" name="zip" value="{{ old('zip') }}" required autocomplete="zip" autofocus>
          @error('zip')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      {{-- <div class="col">
        <p class="text-left">
          <a href="/property/all" class="btn btn-primary btn-sm"><i class="fas fa-home"></i> Home</a>
        </p>
       </div> --}}

      <div class="col-md-12">
        <p class="text-right">
          <button type="submit" class="btn btn-block btn-primary" onclick="this.form.submit(); this.disabled = true;"><i
              class="fas fa-arrow-right"></i> Continue</button>
        </p>
      
        <p class="text-center">
          <a class="text-dark" href="/property/all"><i class="fas fa-arrow-left"></i> Cancel</a>
        </p>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')

@endsection