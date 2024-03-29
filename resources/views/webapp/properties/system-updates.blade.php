@extends('layouts.argon.main')

@section('title', 'System updates')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">System updates</h6>

  </div>

</div>
<div class="row">
  <div class="col">
    <div class="list-group list-group-flush">
      @foreach ($updates as $item)

      <a href="#!" class="list-group-item list-group-item-action">
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
      </a>

      @endforeach

    </div>
  </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')

@endsection