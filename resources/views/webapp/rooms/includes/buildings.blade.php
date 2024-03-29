   <div class="tab-pane fade" id="nav-{{ $building->building }}" role="tabpanel"
          aria-labelledby="nav-{{ $building->building }}-tab">
          <br>
          <div class="row text-center">
            @foreach ($rooms as $room)

            @if($room->building === $building->building)
            <div class="col-md-2.5">
              @if($room->status === 'occupied')
              <a title="₱ {{ number_format ($building->rent, 2)}}/mo"
                href="/property/{{Session::get('property_id')}}/room/{{ $room->unit_id }}/#tenants"
                class="btn btn-sm btn-primary" style="width: 85px; height: 60px;">
                @if($room->unit_type_id_foreign == '1')
                <i class="fas fa-home fa-2x"></i>
                @elseif($room->unit_type_id_foreign == '2')
                <i class="fas fa-dumpster fa-2x"></i>
                @else
                <i class="fas fa-car fa-2x"></i>
                @endif
                <br>
                <small> {{ $room->unit_no }}</small>
              </a>
              @elseif($room->status === 'vacant')
              <a title="₱ {{ number_format ($building->rent, 2)}}/mo"
                href="/property/{{Session::get('property_id')}}/room/{{ $room->unit_id }}/#tenants"
                class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
                @if($room->unit_type_id_foreign == '1')
                <i class="fas fa-home fa-2x"></i>
                @elseif($room->unit_type_id_foreign == '2')
                <i class="fas fa-dumpster fa-2x"></i>
                @else
                <i class="fas fa-car fa-2x"></i>
                @endif
                <br>
                <small> {{ $room->unit_no }}</small>
              </a>
              @elseif($room->status === 'reserved')
              <a title="₱ {{ number_format ($building->rent, 2)}}/mo"
                href="/property/{{Session::get('property_id')}}/room/{{ $room->unit_id }}/#tenants"
                class="btn btn-sm btn-warning" style="width: 85px; height: 60px;">
                @if($room->unit_type_id_foreign == '1')
                <i class="fas fa-home fa-2x"></i>
                @elseif($room->unit_type_id_foreign == '2')
                <i class="fas fa-dumpster fa-2x"></i>
                @else
                <i class="fas fa-car fa-2x"></i>
                @endif
                <br>
                <small> {{ $room->unit_no }}</small>
              </a>
              @elseif($room->status === 'maintenance')
              <a title="₱ {{ number_format ($building->rent, 2)}}/mo"
                href="/property/{{Session::get('property_id')}}/room/{{ $room->unit_id }}/#tenants"
                class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
                @if($room->unit_type_id_foreign == '1')
                <i class="fas fa-home fa-2x"></i>
                @elseif($room->unit_type_id_foreign == '2')
                <i class="fas fa-dumpster fa-2x"></i>
                @else
                <i class="fas fa-car fa-2x"></i>
                @endif
                <br>
                <small> {{ $room->unit_no }}</small>
              </a>
              @else

              <a title="₱ {{ number_format ($building->rent, 2)}}/mo"
                href="/property/{{Session::get('property_id')}}/room/{{ $room->unit_id }}/#tenants"
                class="btn btn-sm btn-gray" style="width: 85px  ; height: 60px;">
                @if($room->unit_type_id_foreign == '1')
                <i class="fas fa-home fa-2x"></i>
                @elseif($room->unit_type_id_foreign == '2')
                <i class="fas fa-dumpster fa-2x"></i>
                @else
                <i class="fas fa-car fa-2x"></i>
                @endif
                <br>
                <small> {{ $room->unit_no }}</small>
              </a>
              @endif

              <hr>
            </div>
            @endif


            @endforeach
          </div>
        </div>