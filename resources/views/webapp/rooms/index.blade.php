@extends('layouts.argon.main')

@section('title', 'Rooms')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">

  <div class="col-lg-6 text-left">

    <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>

  </div>

  <div class="col-md-6 text-right">
    {{-- @if(Auth::user()->account_type === '1')
      @if($units->count()>20)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === '2' )
      @if($units->count()>30)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === '3' )
      @if($units->count()>50)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === '4' )
      @if($units->count()>75)
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @else
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#upgradeToPro" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
      @endif
    @elseif(Auth::user()->account_type === '5' )
        <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a>
    @endif --}}
    {{-- <a href="#" class="btn btn-primary shadow-sm btn-sm" data-toggle="modal" data-target="#addMultipleUnits" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-dark-50"></i> New</a> --}}
    <a href="{{ route('create-room') }}" class="btn btn-primary"><i class="fas fa-plus fa-sm"></i> New</a>
    {{-- @if($units->count() >1 )

  @endif --}}
    <a href="{{ route('edit-room') }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
    {{-- <a href="/property/{{Session::get('property_id')}}/rooms/clear" class="btn btn-danger btn-sm" ><i
      class="fas fa-backspace fa-sm text-dark-50"></i> Clear search filters</a> --}}
  </div>


</div>
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
    <div class="col-md-11 mx-auto">
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <br>
          {{-- <div class="row" >
          @if($units->count() <=0 )
        <p class="">No rooms found!</p>
        @else
        <p class="">Showing <b>{{ $units->count() }} {{ Session::get('status') }} {{ Session::get('type') }}
          {{ Session::get('building') }} {{ Session::get('rent') }} {{ Session::get('occupancy') }}
          {{ Session::get('floor') }} </b>rooms...

          </p>
        </div> --}}

        <div class="row  text-center">
          @foreach ($units as $item)

          <div class="col-md-2.5">
            @if($item->status === 'occupied')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/#tenants"
              class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
              @if($item->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($item->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $item->unit_no }}</small>
            </a>
            @elseif($item->status === 'vacant')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/#tenants"
              class="btn btn-sm btn-danger" style="width: 85px; height: 60px;">
              @if($item->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($item->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $item->unit_no }}</small>
            </a>
            @elseif($item->status === 'dirty')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/#tenants"
              class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
              @if($item->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($item->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $item->unit_no }}</small>
            </a>
            @else

            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}/#tenants"
              class="btn btn-sm btn-warning" style="width: 85px  ; height: 60px;">
              @if($item->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($item->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $item->unit_no }}</small>
            </a>
            @endif

            <hr>
          </div>


          @endforeach
        </div>

        {{-- @endif --}}
      </div>
      @foreach ($buildings as $item)
      <div class="tab-pane fade" id="nav-{{ $item->building }}" role="tabpanel"
        aria-labelledby="nav-{{ $item->building }}-tab">
        <br>
        <div class="row text-center">
          @foreach ($units as $unit)

          @if($unit->building === $item->building)
          <div class="col-md-2.5">
            @if($unit->status === 'occupied')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/#tenants"
              class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $unit->unit_no }}</small>
            </a>
            @elseif($unit->status === 'vacant')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/#tenants"
              class="btn btn-sm btn-danger" style="width: 85px; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $unit->unit_no }}</small>
            </a>
            @elseif($unit->status === 'dirty')
            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/#tenants"
              class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $unit->unit_no }}</small>
            </a>
            @else

            <a title="₱ {{ number_format ($item->rent, 2)}}/mo"
              href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}/#tenants"
              class="btn btn-sm btn-warning" style="width: 85px  ; height: 60px;">
              @if($unit->unit_type_id_foreign == '1')
              <i class="fas fa-home fa-2x"></i>
              @elseif($unit->unit_type_id_foreign == '2')
              <i class="fas fa-dumpster fa-2x"></i>
              @else
              <i class="fas fa-car fa-2x"></i>
              @endif
              <br>
              <small> {{ $unit->unit_no }}</small>
            </a>
            @endif

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
<script>
  $('#room_type').on('change',function(){
      if($(this).val()=="1"){
        $(".commercial").hide()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").hide()
      }
        else if($(this).val()=="2"){
        $(".commercial").show()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").hide()
      }
      else if($(this).val()=="3"){
        $(".commercial").hide()
        $(".residential").show()
        $("#submitButton").show()
        $(".parking").show()
      }
      else{
        $(".commercial").hide()
        $(".residential").hide()
        $("#submitButton").hide()
        $(".parking").hide()
      }
  });

</script>
@endsection