@extends('layouts.argon.main')

@section('title', 'Job Orders')

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
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Job Orders</h6>
    
  </div>

</div>
@if($joborders->count() <=0 )
<p class="text-danger text-center">No job orders found!</p>

@else
<div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
     
  <table class="table table-hover">
    <thead>
      <?php $ctr=1; ?>
      <tr>
          <th>#</th>
          <th>Date filed</th>
          <th>Concern </th>
          <th>Summary</th>
          <th>Personnel</th>
          <th>Status</th>
          <th>Action</th>
         
     </tr>
    </thead>
    <tbody>
      @foreach ($joborders as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
        <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
        <td><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id_foreign }}">{{ $item->details }}</a></td>
        <td>{{ $item->summary }}</td>
        <td>{{ $item->personnel_name }}</td>
        <td>
          @if($item->joborder_status === 'pending')
          <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->joborder_status }}</span>
          @elseif($item->joborder_status === 'active')
          <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->joborder_status }}</span>
          @else
          <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->joborder_status }}</span>
          @endif
          {{-- @if($item->joborder_status=='active')
          <a title="job order is being done..." class="btn btn-danger btn-sm" href="#/"><i class="fas fa-clock"></i></a>
          @else
          <a title="" class="btn btn-success btn-sm" href="#/"><i class="fas fa-check"></i></a>
          @endif --}}
        </td>
        <td><a title="add inventory to the job order" href="/property/{{ Session::get('property_id') }}/joborder/{{ $item->joborder_id }}/inventory" class="btn btn-primary btn-sm">  <i class="fas fa-list"></i></a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
 
</div>

@endif
@endsection



@section('scripts')
  
@endsection



