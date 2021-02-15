@extends('layouts.material.template')

@section('title', 'User Activities')
@section('content')
<div class="content">
  <div class="container-fluid">
 <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="card">
          
      
          <div class="list-group list-group-flush">
            @foreach ($activities as $item)
         
            <a href="#!" class="list-group-item list-group-item-action">
              <div class="row align-items-center">
                <div class="col-auto">
                  <!-- Avatar -->
                  @if($item->action === 'tenant')
                <i class="fas fa-user text-green fa-lg"></i>
                @elseif($item->action === 'payable')
                <i class="fas fa-file-export text-indigo fa-lg"></i>
                @elseif($item->action === 'owner')
                <i class="fas fa-user-tie text-teal fa-lg"></i>
                @elseif($item->action === 'concern')
                <i class="fas fa-tools text-cyan fa-lg"></i>
                @elseif($item->action === 'payment')
                <i class="fas fa-coins text-yellow fa-lg"></i>
                @elseif($item->action === 'bill')
                <i class="fas fa-file-invoice-dollar text-pink fa-lg"></i>
                @elseif($item->action === 'joborder')
                <i class="fas fa-list text-dark fa-lg"></i>
                @elseif($item->action === 'unit')
                <i class="fas fa-home text-indigo fa-lg"></i>
                @elseif($item->action === 'contract')
                <i class="fas fa-file-signature text-teal fa-lg"></i>
                @elseif($item->action === 'search')
                <i class="fas fa-search text-blue fa-lg"></i>
                @elseif($item->action === 'financial')
                <i class="fas fa-file-export text-indigo fa-lg"></i>
                @elseif($item->action === 'user')
                <i class="fas fa-user-circle text-green fa-lg"></i>
                @elseif($item->action === 'issue')
                <i class="fas fa-dizzy text-red text-red fa-lg"></i>
                @elseif($item->action === 'remittance')
                <i class="fas fa-hand-holding-usd text-teal fa-lg"></i>
                @else
                <i class="fas fa-building text-primary fa-lg"></i>
                @endif
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="mb-0 text-sm">{{ $item->message }}</h4>
                    </div>
                    <div class="text-right text-muted">
                      <small>{{ Carbon\Carbon::parse($item->action_made)->diffForHumans() }}</small>
                    </div>
                  </div>
                  <p class="text-sm text-muted mb-0">{{ $item->name }}</p>
                </div>
              </div>
            </a>
        
            @endforeach
        
          </div>
      
        </div>
      </div>
    </div>
  </div>
@endsection
