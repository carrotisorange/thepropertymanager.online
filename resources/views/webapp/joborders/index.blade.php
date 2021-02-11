@extends('layouts.argon.main')

@section('title', 'Job Orders')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Job Orders</h6>
    
  </div>

</div>
@if($joborders->count() <=0 )
<p class="text-danger text-center">No job orders found!</p>

@else
<div class="table-responsive text-nowrap">
     
  <table class="table" >
    <thead>
      <?php $ctr=1; ?>
      <tr>
          <th>#</th>
          <th>Date filed</th>
          <th>Concern </th>
          <th>Summary</th>
          <th>Personnel</th>
          <th>Status</th>
         
     </tr>
    </thead>
    <tbody>
      @foreach ($joborders as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
        <td>{{ $item->created_at }}</td>
        <td><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id_foreign }}">{{ $item->details }}</a></td>
        <td>{{ $item->summary }}</td>
        <td>{{ $item->personnel_name }}</td>
        <td>{{ $item->joborder_status }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
 
</div>

@endif
@endsection



@section('scripts')
  
@endsection



