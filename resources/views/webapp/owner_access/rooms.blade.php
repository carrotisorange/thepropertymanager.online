@extends('webapp.owner_access.template')

@section('title', 'Rooms')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>
    
  </div>
@endsection

@section('main-content')
<div class="container-fluid mt--6">
    <div class="table-responsive text-nowrap">
      <table class="table">
        <?php $ctr = 1; ?>
       <thead>
        <tr>
          <th>#</th>
          <th>Enrollment Date</th>
          <th>Building</th>
            <th>Room</th>
            {{-- <th>Movein </th>
            <th>Moveout at</th> --}}
            <th>Status</th>
            <th>Rent(/month)</th>
            
        </tr>
       </thead>
       <tbody>
           @foreach ($rooms as $item)
               <tr>
                 <th>{{ $ctr++ }}</th>
                 <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                 <td>{{ $item->building }}</td>
                   <th><a href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/room/{{ $item->unit_id }}/contracts">{{ $item->unit_no }}</a></th>
                   {{-- <td>{{ $item->movein_at }}</td>
                   <td>{{ $item->moveout_at }}</td> --}}
                   <td>{{ $item->status }}</td>
                   <td>{{ number_format($item->rent,2) }}</td>
               </tr>
           @endforeach
       </tbody>
        
      </table>
    </div>

  </div>
@endsection

@section('scripts')
  
@endsection



