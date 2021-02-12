@extends('layouts.material.template')

@section('title', 'Properties')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
         
      <div class="col-lg-12 col-md-12">
        <div class="card">
       
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-primary">
                
                <th>Name</th>
                <th>Type</th>
                <th>Ownership</th>
                <th>Mobile</th>
                <th>Address</th>
         
              </thead>
              <tbody>
                @foreach ($properties as $item)
                <tr>
                  <td><a href="/property/{{ $item->property_id }}/edit"> {{ $item->name }}</a></td>
                  <td>{{ $item->type }}</td>
                  <td>{{ $item->ownership }}</td>
                  <td>{{ $item->mobile }}</td>
                  <td>{{ $item->address.', '.$item->country.', '.$item->zip }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
@endsection
