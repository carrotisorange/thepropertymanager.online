@extends('layouts.argon.main')

@section('title', 'Job Order')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/joborders/">Job Orders</a></li>
       
          <li class="breadcrumb-item active" aria-current="page">Job Order # {{ $joborder->joborder_id }}</li>
        </ol>
      </nav>
    
  </div>

</div>
<div class="row">
    <div class="col-md-6">
        <p>Details of the Job Order</p>
        <table class="table table-condensed table-bordered table-hover">
            <tr>
                <th>Date filed</th>
            </tr>
            <tr>
                <td>{{ Carbon\Carbon::parse($joborder->created_at)->format('M d, Y') }}</td>
            </tr>
            @foreach($personnel as $item)
            <tr>
                <td>{{ $item->personnel_name }} | {{ $item->personnel_type }}</td>
            </tr>
            @endforeach
            
            <tr>
            <tr>
                <th>Personnel ID</th>
            </tr>
            @foreach($personnel as $item)
            <tr>
                <td>{{ $item->personnel_name }} | {{ $item->personnel_type }}</td>
            </tr>
            @endforeach
            
            <tr>
                <th>Summary</th>
            </tr>
            <tr>
                <td>{{ $joborder->summary }}</td>
            </tr>
           
        </table>
    </div>
</div>

@endsection



@section('scripts')
  
@endsection



