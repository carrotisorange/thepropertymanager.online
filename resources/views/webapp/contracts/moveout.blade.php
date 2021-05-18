@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="//property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/#contracts"">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/">Contract</a></li>
        <li class="breadcrumb-item active" aria-current="page">Moveout</li>
      </ol>
    </nav>
    
    
  </div>
</div>
{{-- <div class="row">
  <div class="col">
    <h1 class="text-center">
      <i class="fas fa-people-carry fa-lg"></i>
    </h1>
  </div>
</div> --}}
<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          
          <form id="moveoutTenantForm" action="/property/{{Session::get('property_id')}}/home/{{ $contract->unit_id_foreign }}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/moveout" method="POST">
            @csrf
            @method('PUT')
        </form>

          <b>{{ $tenant->first_name.' '.$tenant->last_name }}</b> stayed for <?php   $diffInDays =  number_format((Carbon\Carbon::parse($contract->movein_at))->DiffInDays(Carbon\Carbon::parse($contract->moveout_at))) ?> <b>{{ $contract->number_of_months? $contract->number_of_months: 'NULL' }}</b> in <b>{{ Session::get('property_name') }}</b>. 
            The reason for his/her moveout is <b>{{ $contract->moveout_reason }}</b>. He/she is scheduled to moveout on <b>{{ Carbon\Carbon::parse($contract->actual_moveout_at )->format('M d Y') }}</b>. 
            Please click  <button type="submit" form="moveoutTenantForm">here</button> to export the gatepass. 
            Please remind the tenant to present the gatepass to the guard before leaving the property. Also, don't forget to remind the tenant to rate their stay at their tenant portal.
        </div>
      </div>      
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



