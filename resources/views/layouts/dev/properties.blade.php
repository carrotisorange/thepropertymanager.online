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
                <?php $ctr=1; ?>
                <th>#</th>
                <th>Property</th>
                <th>Property type</th>
               
                <th>Mobile</th>
                <th>Address</th>
         
              </thead>
              <tbody>
                @foreach ($properties as $item)
                <tr>
                  <th>{{ $ctr++ }}</th>
                  <td><a href="/property/{{ $item->property_id }}/view"> {{ $item->name }}</a></td>
                  <td>{{ $item->property_type }}</td>
              
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


    
<div class="modal fade" id="addPropertyType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Property Type Information</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addPropertyTypeForm" action="/propertytype/store" method="POST">
              @csrf
          </form>

          <div class="form-group">
              <label>Property type</label>
              <input form="addPropertyTypeForm" type="text" class="form-control" name="property_type" required>
              
          </div>

          <div class="form-group">
              <label>Description</label>
              <input form="addPropertyTypeForm" type="text" class="form-control" name="description" required>
              
          </div>

      </div>
      <div class="modal-footer">
        
          <button form="addPropertyTypeForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Submit</button>
          </div>
  </div>
  </div>
</div>
@endsection
