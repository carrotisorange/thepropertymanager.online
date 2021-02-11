@extends('layouts.argon.main')

@section('title', 'Delinquents')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Watchout for delinquents ({{ $delinquents->count() }})...</h6>
    
  </div>
  

</div>
<div class="row">
    <div class="col">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                  <?php $ctr=1; ?>
                  <tr>
                      <th>#</th>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($delinquents as $item)
                  <tr>
                      <th>{{ $ctr++ }}</th>
                    <td>
                      <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}#bills">{{ $item->first_name.' '.$item->last_name }}
                    </td>
                    <td>
                      @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin' )
                      <a href="/property/{{ Session::get('property_id') }}/home/{{ $item->unit_id   }}">{{$item->unit_no }}</a>
                      @else
                     {{ $item->unit_no }}
                      @endif
                    </td>
                    <td>
                      <a>{{ number_format($item->balance,2) }}
                    </td>
                    <td>
                      @if($item->contract_status === 'active')
                     <span class="text-success"><i class="fas fa-check-circle"></i> {{ $item->contract_status }}</span>
                      @else
                      <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>
            
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                
              </table>
            </div>
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



