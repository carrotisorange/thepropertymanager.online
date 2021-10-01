@extends('layouts.argon.main')

@section('title', $room->building.' '.$room->unit_no.' | Report Concern')

@section('css')

@endsection

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Approval</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-12 py-3 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    {{-- <form id="createBillForm"
                        action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $concern->concern_id }}/store/materials"
                    method="POST">
                    @csrf
                    </form> --}}

                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Approval:</label>
                        <p>Tenant</p>

                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Status:</label>

                        @if($concern->approved_by_tenant_at)
                        <p class="text-success"> <i class="fas fa-check-circle"></i> approved</p>

                        @else
                        <p class="text-warning"> <i class="fas fa-clock"></i> pending</p>
                        @endif

                    </div>

                    <div class="form-group col-md-2">
                        <label for="">Approved on:</label>
                        <p>{{ $concern->approved_by_tenant_at? $concern->approved_by_tenant_at:'NA' }}</p>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">

                        <p>Owner</p>

                    </div>
                    <div class="form-group col-md-4">

                        @if($concern->approved_by_owner_at)
                        <p class="text-success"> <i class="fas fa-check-circle"></i> approved</p>

                        @else
                        <p class="text-warning"> <i class="fas fa-clock"></i> pending</p>
                        @endif
                    </div>

                    <div class="form-group col-md-2">

                        <p>{{ $concern->approved_by_owner_at? $concern->approved_by_owner_at:'NA' }}</p>

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">

                        <p>Manager</p>

                    </div>
                    <div class="form-group col-md-4">
                        @if($concern->approved_by_manager_at)
                        <p class="text-success"> <i class="fas fa-check-circle"></i> approved</p>

                        @else
                        <p class="text-warning"> <i class="fas fa-clock"></i> pending</p>
                        @endif
                    </div>

                    <div class="form-group col-md-2">

                        <p>{{ $concern->approved_by_manager_at? $concern->approved_by_manager_at:'NA' }}</p>

                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mx-auto">
                        <p class="text-center">
                            @if($concern->approved_by_tenant_at && $concern->approved_by_owner_at &&
                            $concern->approved_by_manager_at)
                            <a class="btn btn-block btn-primary"
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $concern->concern_tenant_id?$tenant->tenant_id:$tenant->owner_id }}/concern/{{ $concern->concern_id }}/payment-options">Next</a>
                            @else
                            <a class="btn btn-block btn-primary" href="" disabled>Waiting for approval</a>
                            @endif
                        </p>

                        <p class="text-center">
                            <a class="text-center text-dark"
                                href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/tenant/{{ $concern->concern_tenant_id?$tenant->tenant_id:$tenant->owner_id }}/materials">Back</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection