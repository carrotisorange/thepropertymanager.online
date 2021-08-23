@extends('layouts.argon.dashboard')

@section('title', 'Portforlio')
@section('welcome')
<h1 class="text-white">Add your property here!</h1>
@endsection

@section('content')
<div class="row">
  @foreach ($properties as $item)
  <div class="col">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">{{ $item->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $item->property_type }}</h6>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.</p>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection

@section('scripts')

@endsection