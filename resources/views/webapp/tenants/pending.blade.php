@extends('layouts.argon.main')

@section('title', 'Pending tenants')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Pending tenants</h6>
    
  </div>
  

</div>
<div class="row">
    
    <div class="col">
        <p>These are the list of tenants who are not able to pay their movein charges yet.</p>
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;">
            <table class="table table-bordered">
                <thead>
                    <?php $ctr=1; ?>
                  <tr>
                    <th>#</th>
                    <th>Movein on</th>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Type</th>
                 
                </tr>
                </thead>
                <tbody>
                  @foreach($tenants as $item)
                  <tr>
                    <th>{{ $ctr++ }}</th>
                    <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                    <th><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a></th>
                    <th><a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a></th>
                    <td>{{ $item->type_of_tenant }}</td>
                    
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



