@extends('layouts.argon.dashboard')

@section('title', 'Not found')

@section('sidebar')

@endsection

@section('css')

@endsection

@section('content')
<soan class="text-center">
  <h1>Sorry page isn't available.</h1>
  
  <p>This link you followed probably broken, or the page has been removed.</p>
  
  <p>Return to the <a href="/property/{{ Session::get('property_id') }}/dashboard"> Dashboard</a></p>
</span>
@endsection

@section('scripts')

@endsection



