<div class="modal fade" id="addContract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Room</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <form id="contractForm"
          action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id}}/contract/create"
          method="POST">
          @csrf

        </form>
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach ($buildings as $building)
            <a class="nav-item nav-link" id="{{ $building->building }}-tab" data-toggle="tab"
              href="#{{ $building->building }}" role="tab" aria-controls="{{ $building->building }}"
              aria-selected="false"><i class="fas fa-building text-indigo"></i> {{ $building->building }} <span
                id="count_rooms" class="badge badge-primary text-dark">{{ $building->count }}</a>
            @endforeach
          </div>
        </nav>

        <div class="tab-content" id="" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
         

          @foreach ($buildings as $building)
          <div class="tab-pane fade" id="{{ $building->building }}" role="tabpanel"
            aria-labelledby="{{ $building->building }}-tab">
            <br>

            @foreach ($units as $floor_no => $floor_no_list)
            <p class="text-center">
              @if($floor_no >= 1)
              {{ $floor_no.' floor' }}
              @else
              @if($floor_no >= -1)
              1st basement
              @elseif($floor_no >= -2)
              2nd basement
              @elseif($floor_no >= -3)
              3rd basement
              @elseif($floor_no >= -4)
              4th basement
              @elseif($floor_no >= -5)
              5th basement
              @endif
              @endif

            </p>

            @foreach ($floor_no_list as $item)
            @if($building->building === $item->building)


            <a title="{{ $item->monthly_rent }}" href="#/" class="btn btn-primary">

              <i class="fas fa-home fa-2x">

              </i>
              <br>
              <input class="form-check-input text-center" type="radio" form="contractForm" name="unit_id"
                id="inlineRadio1" value="{{ $item->unit_id }}" required>
              {{ $item->unit_no }}
            </a>

            @endif
            @endforeach
            <hr>
            @endforeach
          </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="contractForm" class="btn btn-primary btn-sm"
          onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-arrow-right"></i> Continue</button>
      </div>
    </div>
  </div>
</div>