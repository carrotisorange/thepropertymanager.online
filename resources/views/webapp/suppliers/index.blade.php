@extends('layouts.argon.main')

@section('title', 'Suppliers')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
      <h6 class="h2 text-dark d-inline-block mb-0">Suppliers</h6>
  </div>
    <div class="col text-right">
        <a href="/property/{{ Session::get('property_id') }}/suppliers/create" class="btn btn-primary shadow-sm btn-sm"><i class="fas fa-plus fa-sm text-white-50"></i> New</a>
  </div>
   </div>

   @if($suppliers->count() <=0 )
<p class="text-danger text-center">No suppliers found!</p>

@else
<div class="row" style="overflow-y:scroll;overflow-x:scroll;">
  <table class="table table-hover">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Mobile</th>
    <th>Email</th>
    <th>Representative</th>    
    <th>Description</th>
</tr>
</thead>
<tbody>
  <?php $ctr=1;?>
  @foreach ($suppliers as $item)
    <tr>
        <th>{{ $ctr++ }}</th>
        <td>{{ $item->name }}</td>
        <td>{{ $item->mobile }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->representative }}</td>
        <td>{{ $item->description }}</td>
    </tr>
  @endforeach
</tbody>
</table>
  </div>
@endif
@endsection



@section('scripts')
  
@endsection



