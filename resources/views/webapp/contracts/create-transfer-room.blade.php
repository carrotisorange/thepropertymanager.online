@extends('layouts.argon.main')

@section('title', 'Select room')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-3 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Select room</h6>
    </div>
</div>
<form id="contractForm"
    action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id}}/contract/{{ $contract->contract_id }}/store/transfer" method="POST">
    @csrf

</form>
<div class="row">

    <div class="col-md-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true"><i class="fas fa-home text-indigo"></i> All <span
                        class="badge badge-primary badge-counter">{{ $units->count() }}</span></a>
                @foreach ($buildings as $item)
                <a class="nav-item nav-link" id="nav-{{ $item->building }}-tab" data-toggle="tab"
                    href="#nav-{{ $item->building }}" role="tab" aria-controls="nav-{{ $item->building }}"
                    aria-selected="false"><i class="fas fa-building text-indigo"></i> {{ $item->building }} <span
                        class="badge badge-primary badge-counter">{{ $item->count }}</span></a>
                @endforeach
            </div>
        </nav>
        <div class="col-md-12 mx-auto">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <br>
                    <div class="row  text-center">
                        @foreach ($units as $item)

                        <div class="col-md-2.5">

                            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="#/" class="btn btn-sm btn-success"
                                style="width: 85px; height: 60px;">
                                @if($item->unit_type_id_foreign == '1')
                                <i class="fas fa-home fa-2x"></i>
                                @elseif($item->unit_type_id_foreign == '2')
                                <i class="fas fa-dumpster fa-2x"></i>
                                @else
                                <i class="fas fa-car fa-2x"></i>
                                @endif
                                <br>
                                <input class="form-check-input text-center" type="radio" form="contractForm"
                                    name="room_id" id="inlineRadio1" value="{{ $item->unit_id }}" required>
                                <small> {{ $item->unit_no }}</small>
                            </a>


                            <hr>
                        </div>
                        @endforeach
                    </div>
                </div>
                @foreach ($buildings as $item)
                <div class="tab-pane fade" id="nav-{{ $item->building }}" role="tabpanel"
                    aria-labelledby="nav-{{ $item->building }}-tab">
                    <br>
                    <div class="row text-center">
                        @foreach ($units as $unit)

                        @if($unit->building === $item->building)
                        <div class="col-md-2.5">

                            <a title="₱ {{ number_format ($item->rent, 2)}}/mo" href="#/" class="btn btn-sm btn-success"
                                style="width: 85px; height: 60px;">
                                @if($unit->unit_type_id_foreign == '1')
                                <i class="fas fa-home fa-2x"></i>
                                @elseif($unit->unit_type_id_foreign == '2')
                                <i class="fas fa-dumpster fa-2x"></i>
                                @else
                                <i class="fas fa-car fa-2x"></i>
                                @endif
                                <br>
                                <input class="form-check-input text-center" type="radio" form="contractForm"
                                    name="room_id" id="inlineRadio1" value="{{ $item->unit_id }}" required>
                                <small> {{ $unit->unit_no }}</small>
                                <br>

                            </a>


                            <hr>
                        </div>
                        @endif


                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>

    </div>
    
</div>
<div class="row">
    <div class="col">
        <p class="text-center">
            <button type="submit" form="contractForm" class="btn btn-primary"
                onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>
                Confirm transfer</button>
        </p>
    </div>
</div>



<div class="modal fade" id="upgradeToPro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upgrade to PRO</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    The current plan you have reached the limit of rooms that you are allowed to add.
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

@endsection