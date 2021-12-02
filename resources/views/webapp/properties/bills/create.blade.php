@extends('layouts.argon.dashboard')

@section('title', 'Step 2 of 4 | The Property Manager')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
  <form class="user" method="POST" action="/property/{{ Session::get('property_id') }}/bills/store">
    @csrf
    <div class="form-group">
      <label for="">Select all the bills that apply to your property</label>
      @foreach ($particulars as $item)
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="particulars[]" value="{{ $item->particular_id }}">
        <label class="form-check-label" for="exampleRadios1">
          <b>{{ $item->particular }} </b> - {{ $item->description }}
        </label>
      </div>
      @endforeach
      @error('property_type_id')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="row">
      <div class="col">
        <p class="text-right">
          <button type="submit" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"><i
              class="fas fa-arrow-right"></i> Continue</button>
        </p>
        <p class="text-center">
          <a class="text-black" href="{{ url()->previous() }}"><i class="fas fa-times"></i> Cancel</a>
        </p>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')

@endsection