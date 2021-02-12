@extends('layouts.material.template')

@section('title', 'Updates')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 mx-auto card card-body">


      
        <form action="/dev/updates/store" method="POST">
          @csrf

          <label for="">What feature is the update for?</label>
          <input class="form-control form-control-user @error('feature') is-invalid @enderror" name="feature" id="" cols="30" rows="3" value="{{ old('feature') }}" placeholder="remittance"/>
          
            @error('feature')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <br>
       <label for="">What is the link for the update?</label>
          <input class="form-control form-control-user @error('link') is-invalid @enderror" name="link" id="" cols="30" rows="3" value="{{ old('link') }}" placeholder="/property/tenant/123/"/>
          
            @error('link')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
    <br>
    <label for="">What is the update all about?</label>
          <textarea  class="form-control form-control-user @error('description') is-invalid @enderror" name="description" id="" cols="30" rows="3" value="{{ old('description') }}" placeholder="A feature to add remittance to unit owner has been added."></textarea required>
          
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
        <br>
      <p class="text-right">
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Post Updates </button>
      </p>
      </form>
    
  

      </div>
    </div>
 <div class="row">
   
      <div class="col-lg-12 col-md-12">
        
        <div class="card">
          
      
          <div class="list-group list-group-flush">
            @foreach ($updates as $item)
 
    <span class="list-group-item list-group-item-action">
      <div class="row align-items-center">
        <div class="col-auto">
          <!-- Avatar -->
          @if($item->feature === 'tenant')
        <i class="fas fa-user text-green fa-lg"></i>
        @elseif($item->feature === 'payable')
        <i class="fas fa-file-export text-indigo fa-lg"></i>
        @elseif($item->feature === 'owner')
        <i class="fas fa-user-tie text-teal fa-lg"></i>
        @elseif($item->feature === 'concern')
        <i class="fas fa-tools text-cyan fa-lg"></i>
        @elseif($item->feature === 'payment')
        <i class="fas fa-coins text-yellow fa-lg"></i>
        @elseif($item->feature === 'bill')
        <i class="fas fa-file-invoice-dollar text-pink fa-lg"></i>
        @elseif($item->feature === 'joborder')
        <i class="fas fa-list text-dark fa-lg"></i>
        @elseif($item->feature === 'unit')
        <i class="fas fa-home text-indigo fa-lg"></i>
        @elseif($item->feature === 'contract')
        <i class="fas fa-file-signature text-teal fa-lg"></i>
        @elseif($item->feature === 'search')
        <i class="fas fa-search text-blue fa-lg"></i>
        @elseif($item->feature === 'financial')
        <i class="fas fa-file-export text-indigo fa-lg"></i>
        @elseif($item->feature === 'user')
        <i class="fas fa-user-circle text-green fa-lg"></i>
        @elseif($item->feature === 'issue')
        <i class="fas fa-dizzy text-red text-red fa-lg"></i>
        @elseif($item->feature === 'remittance')
        <i class="fas fa-hand-holding-usd text-teal fa-lg"></i>
        @else
        <i class="fas fa-building text-primary fa-lg"></i>
        @endif
        </div>
        <div class="col">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="mb-0 text-sm">{{ $item->feature }}</h4>
            </div>
            <div class="text-right text-muted">
              <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
            </div>
          </div>
          <p class="text-sm text-muted mb-0">{{ $item->description }}</p>
         
        </div>
      </div>
    </span>
   
    @endforeach
        
          </div>
      
        </div>
      </div>
    </div>
  </div>
@endsection
