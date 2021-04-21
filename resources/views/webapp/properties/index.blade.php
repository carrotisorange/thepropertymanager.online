@extends('layouts.argon.dashboard')


@section('title', 'My properties')

@section('welcome')

@if ($properties->count() > 0)
<h1 class="text-white">Welcome, {{ Auth::user()->name }}!</h1>
<p class="text-lead text-white">Simplifying property management.</p>
@else
<h1 class="text-white">Add your first property...</h1>
@endif
@endsection

@section('content')
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
            <h5 class="card-title text-uppercase text-muted mb-0">{{ $item->type}} &#9671 {{ $item->ownership }} </h5>
            <input type="hidden" name="property_id" value="{{ $item->property_id }}">
          </div>
          
          <div class="col-auto">

            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
              @if($item->type=='Condominium Associations')
              <i class="fas fa-building fa-2x text-gray-300"></i>
              @elseif($item->type=='Commercial Complex')
              <i class="fas fa-store fa-2x text-gray-300"></i>
              @else
              <i class="fas fa-home fa-2x text-gray-300"></i>
              @endif

            </div>
          </div>
        </div>
        
        <p class="mt-3 mb-0 text-sm">
          {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> --}}
          <small class="text-nowrap">Created on <b>{{ Carbon\Carbon::parse( $item->created_at)->format('M, d Y') }}</b></small>
          
        </p>
      </div>
      
    </div>

@endforeach

@if ($properties->count() <= 0)
{{-- <h1 class="">Add your first property...</h1> --}}
@else
@if(Auth::user()->trial_ends_at <= Carbon\Carbon::today())
<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Trial ends on {{ Carbon\Carbon::parse(Auth::user()->trial_ends_at)->format('M d Y') }} </p>
@else
<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Trial expires on {{ Carbon\Carbon::parse(Auth::user()->trial_ends_at)->format('M d Y') }}</p>
@endif
@endif


{{-- <hr> --}}


<div class="row">
  
    @if ($properties->count() <= 0)
    <div class="col">
    <a href="/property/{{ Carbon\Carbon::now()->timestamp }}/create" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Create your first property</a>
    </div>
    @else
    
    <div class="col-md-4">
      @if($properties->count()>1)
        <a href="/property/{{ Carbon\Carbon::now()->format('mdY') }}/portforlio" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-columns"></i> See your portforlio</a>
      @else
       @if(Auth::user()->account_type === 'enterprise' || Auth::user()->account_type === 'advanced')
       <a href="/property/{{ Carbon\Carbon::now()->timestamp }}/create" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Add new property</a>
        @else
        <a href="#" class="btn btn-primary btn-user btn-block btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus"></i> Add new property</a>
        @endif
      @endif
    </div>

    <div class="col-md-4">
      @if (Auth::user()->user_type === 'manager')
        @if($users > 1)
        <a title="Upgrade to Pro to add more users." href="/user/create" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Add new user </a>
        @else
        <a title="Limited to 2 users." href="/user/create" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Add new user</a>
        @endif
      @else
      <a title="Reserved for manager." href="#/" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-plus"></i> Add new user</a>
      @endif
    </div>

    <div class="col-md-4">
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
@if (Auth::user()->user_type === 'manager')
  @if($users <= 0)
  <div class="row">
    <div class="col">
        <a class="btn btn-info btn-user btn-block" href="/asa" >Import {{ $existing_users }} existing users.</a>

    </div>
  </div>
  @endif
@endif --}}
<hr>
<small>Need help? </small>
<br><br>
<div class="row">
  <div class="col">
    <a href="https://youtu.be/BMIt10slYgs" target="_blank" class="btn btn-danger btn-user btn-block btn-sm"> <i class="fab fa-youtube"></i> Watch </a>
    </div>
    <div class="col">
      <a title="Please tap the bottom left side of your screen." href="#/"  class="btn btn-primary btn-user btn-block btn-sm"> <i class="fab fa-facebook-messenger"></i> Chat </a>
      </div>
</div>


<div class="modal fade" id="upgradeToPro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Upgrade to PRO</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <p class="text-center">
          The current plan you have reached the limit of properties that you are allowed to add. 
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Dismiss</button>
      </div>
  </div>
  </div>
</div>

@endsection
@section('scripts')
{{-- <script>
  window.onload=function(){
   $("#manageButton").click();
   }
  </script> --}}
@endsection