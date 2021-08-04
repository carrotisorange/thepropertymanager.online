@extends('webapp.properties.template')


@section('title', 'My properties')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
  
<form   class="user" action="/property/select" method="POST">
  @csrf
@foreach ($properties as $item)

    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">

          <div class="col">
            <input class="form-check-input" type="radio" name="selectedProperty" id="inlineRadio1" value="{{ $item->property_id }}" checked>
            <span class="h2 font-weight-bold mb-0">{{ $item->name }} </span> <a title="Edit this property." href="/property/{{ $item->property_id }}/edit"><i class="fas fa-edit"></i></a>
            {{-- <h5 class="card-title text-uppercase text-muted mb-0">{{ $item->type}} &#9671 {{ $item->ownership }} </h5> --}}
            <input type="hidden" name="property_id" value="{{ $item->property_id }}">
          </div>
          
          <div class="col-auto">

            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
              @if($item->type==1)
              <i class="fas fa-building fa-2x text-gray-300"></i>
              @elseif($item->type=='6')
              <i class="fas fa-store fa-2x text-gray-300"></i>
              @else
              <i class="fas fa-home fa-2x text-gray-300"></i>
              @endif

            </div>
          </div>
        </div>
        
        {{-- <p class="mt-3 mb-0 text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> 
          <small class="text-nowrap">Created on <b>{{ Carbon\Carbon::parse( $item->created_at)->format('M, d Y') }}</b></small>
          
        </p> --}}
      </div>
      
    </div>

@endforeach
{{-- 
@if ($properties->count() <= 0)

@else
@if(Auth::user()->trial_ends_at <= Carbon\Carbon::today())
<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Trial ends on {{ Carbon\Carbon::parse(Auth::user()->trial_ends_at)->format('M d Y') }} </p>
@else
<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Trial expires on {{ Carbon\Carbon::parse(Auth::user()->trial_ends_at)->format('M d Y') }}</p>
@endif
@endif --}}


{{-- <hr> --}}


<div class="row">
  
    @if ($properties->count() <= 0)
    <div class="col">
    <a href="{{ route('create-property') }}" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Add your property</a>
    </div>
    @else
    
    <div class="col">
      @if(Auth::user()->trial_ends_at > Carbon\Carbon::today())
      <button id="manageButton" type="submit" class="btn btn-primary btn-user btn-block btn-sm" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-arrow-right"></i> Manage</button>
      @else
      <a href="#" data-toggle="modal" data-target="#showWarning" class="btn btn-success btn-user btn-block btn-sm"> Manage</a>
      @endif
  
    </div> 
    @endif
  </div>
</form>

{{-- 
  <div class="col">
    @if(Auth::user()->trial_ends_at > Carbon\Carbon::today())
    <button type="submit" class="btn btn-success btn-user btn-block" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-hand-point-up"></i> Manage</button>
    @else
    <a href="#" data-toggle="modal" data-target="#showWarning" class="btn btn-success btn-user btn-block"><i class="fas fa-hand-point-up"></i> Manage</a>

    @endif

  </div> --}}

{{-- <br>
@if (Auth::user()->role_id_foreign === 4)
  @if($users <= 0)
  <div class="row">
    <div class="col">
        <a class="btn btn-info btn-user btn-block" href="/asa" >Import {{ $existing_users }} existing users.</a>

    </div>
  </div>
  @endif
@endif --}}

@endsection


@section('scripts')
{{-- <script>
  window.onload=function(){
   $("#manageButton").click();
   }
  </script> --}}
@endsection