@extends('webapp.tenant_access.template')

@section('title', 'Concerns')

@section('css')
<style>
  /*This will work on every browser*/
  thead tr:nth-child(1) th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 10;
  }
</style>
@endsection

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>

</div>
<div class="col-md-6 text-right">
  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i
      class="fas fa-plus"></i> Add</a>
</div>
@endsection

@section('main-content')
<div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
  <table class="table table-hover">
    <?php $ctr = 1; ?>
    <thead>
      <tr>
        <th>#</th>

        <th>Reported on</th>


        <th>Category</th>
     
        <th>Urgency</th>
        <th>Status</th>
        <th>Endorsed to</th>
        <th>Rating</th>
        <th></th>
        {{-- <th>Feedback</th> --}}

      </tr>
    </thead>
    <tbody>
      @foreach ($all_concerns as $item)
      <tr>
        <th>{{ $ctr++ }}</th>

        <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>

        <td>{{ $item->category }}</td>

        
        <td>
         @if($item->urgency === 'emergency')
        <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $item->urgency }}</span>
        @elseif($item->urgency === 'major')
        <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $item->urgency }}</span>
        @else
        <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->urgency }}</span>
        @endif
        </td>
        <td>
         @if($item->concern_status === 'pending' || $item->concern_status === 'assessed' ||
          $item->concern_status === 'waiting for approval' || $item->concern_status === 'approved' ||
          $item->concern_status === 'request for purchase' || $item->concern_status === 'for purchase' )
          <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
          @elseif($item->concern_status === 'on-going')
          <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
          @else
          <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
          @endif
        </td>
        
        <td>{{ $item->role? $item->role: 'NULL' }}</td>
        <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
        <th><a class=""
            href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $item->concern_id }}/responses" target="_blank"><i class="fas fa-eye"></i> View</a></th>
      
      </tr>
      @endforeach
    </tbody>
  </table>

</div>

{{-- Modal for renewing tenant --}}
<div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Concern form</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="concernForm" action="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concerns"
          method="POST">
          {{ csrf_field() }}
        </form>

        <input type="hidden" form="concernForm" id="tenant_id" name="tenant_id" value="{{ $tenant->tenant_id }}"
          required>
        <input type="hidden" form="concernForm" id="unit_tenant_id" name="unit_tenant_id"
          value="{{ $tenant->unit_tenant_id }}" required>
        {{--   
                            <div class="row">
                              <div class="col">
                                  <label>Date Reported</label>
                                  <input type="date" form="concernForm" class="form-control" name="reported_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
        required >
      </div>
    </div>
    <br> --}}

    {{-- <div class="row">
      <div class="col">
        <label>Category</label>
        <select class="form-control" form="concernForm" name="category" id="" required>
          <option value="" selected>Please select one</option>
          <option value="unit_work"> Unit work</option>
          <option value="hrr_violations"> HRR violations</option>
          <option value="contract"> Contract</option>
          <option value="remmittance">Remittance</option>
          <option value="billing">Billing</option>
        </select>
      </div>
    </div> --}}
    {{-- <br>
    <div class="row">
      <div class="col">
        <label>Urgency</label>
        <select class="form-control" form="concernForm" name="urgency" id="" required>
          <option value="" selected>Please select one</option>
          <option value="emergency">emergency</option>
          <option value="major">major</option>
          <option value="minor">minor</option>
        </select>
      </div>
    </div>
    <br> --}}



    <div class="row">
      <div class="col">
        <label>Details <span class="text-danger">(Make it as explicit as possible)</span></label>

        <textarea form="concernForm" rows="7" class="form-control" name="details" required></textarea>
      </div>
    </div>
    
    {{-- <div class="row">
                            <div class="col">
                                <label for="movein_date">Assign concern to</label>
                                <select class="form-control" form="concernForm" name="concern_user_id">
                                  <option value="" selected>Please select one</option>
                                  
                                  @foreach($users as $item)
                                      <option value="{{ $item->id }}" selected> {{ $item->role_id_foreign }}</option>
    @endforeach

    </select>
  </div>
</div> --}}
</div>
<div class="modal-footer">
  <button type="submit" form="concernForm" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Submit</button>
</div>
</div>
</div>
</div>

@endsection

@section('scripts')

@endsection