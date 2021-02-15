@extends('layouts.argon.main')

@section('title', 'Rooms Remittances')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/rooms/">{{ Session::get('property_name')}}</a></li>
     
        <li class="breadcrumb-item active" aria-current="page">Remittances</li>
      </ol>
    </nav>
    
    
  </div>

</div>

<div class="row">

  <!-- Content Column -->
  <div class="col-lg-12 mb-4">
      <div class="table">
          <form id="editUnitsForm" action="/property/{{Session::get('property_id')}}/rooms/update" method="POST">
              @csrf
              @method('PUT')
          </form>
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Building Name</th>
                      <th>Room Name/No</th>
                    <th>Room Size</th>
                    <th>Condo Dues <small>(/sqm)</small></th>
                    <th>Condo Dues <small>(/month)</small></th>
                      <th></th>
                  </tr>
              </thead>
              <tbody> 
                  <?php 
                      $ctr = 1;
                      $unit_id = 1;
                      $unit_no = 1;
                     
                      $building =1;
                      $condodues_sqm =1;
                      $condodues_mo =1;
                      $size = 1;
             
                  ?>
                  @foreach ($units as $item)
              
                      <tr>
                          <th> {{ $ctr++ }}</th>
                          <td>{{ $item->building }}</td>
                          <td>
                          {{ $item->unit_no }}
                            <input form="editUnitsForm" type="hidden" name="unit_id{{ $unit_id++  }}" id="" value="{{ $item->unit_id }}">
                          </td>
                          <td>{{ $item->size }} <b>sqm</b></td>
                          <td><input class="form-control" form="editUnitsForm" type="number" step="0.001" name="condodues_sqm{{ $condodues_sqm++  }}" id="" value="{{ $item->size }}"></td>
                          <td><input class="form-control" form="editUnitsForm" type="number" step="0.001" name="condodues_mo{{ $condodues_mo++  }}" id="" value="{{ $item->size }}" readonly></td>
   
                      </tr>
                 
                  @endforeach
              </tbody>
            
        </table>
         </div>
         <br>
         @if($units->count() <=0 )

         @else
        <p class="text-right">
                <button type="submit" form="editUnitsForm" class="btn btn-primary"  onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Update</button>
            </p>
         @endif
  
</div>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



