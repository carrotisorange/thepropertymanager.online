@extends('webapp.owner_access.template')

@section('title', 'Concerns')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
  @if($concerns->count() <=0 )
  <p class="text-danger text-center">No concerns found!</p>
  @else
    <table class="table">
      <?php $ctr = 1; ?>
      <thead>
        <tr>
          <th>#</th>
          
            <th>Date Reported</th>
           
          
           <th>Category</th>
            <th>Title</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Assigned to</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th></th>
       </tr>
      </thead>
      <tbody>
        @foreach ($concerns as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
       
          <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
            
        <td>{{ $item->category }}</td>
          
            <td>{{ $item->title }}</td>
            <td>
                @if($item->urgency === 'urgent')
                <span class="badge badge-danger">{{ $item->urgency }}</span>
                @elseif($item->urgency === 'major')
                <span class="badge badge-warning">{{ $item->urgency }}</span>
                @else
                <span class="badge badge-primary">{{ $item->urgency }}</span>
                @endif
            </td>
            <td>
                @if($item->concern_status === 'pending')
                <i class="fas fa-clock text-warning"></i> {{ $item->concern_status }}
                @elseif($item->concern_status === 'active')
                <i class="fas fa-snowboarding text-primary"></i> {{ $item->concern_status }}
                @else
                <i class="fas fa-check-circle text-success"></i> {{ $item->concern_status }}
                @endif
            </td>
            <?php $explode = explode(" ", $item->name );?>
           
            <td>{{ $item->name? $explode[0]: 'NULL' }}</td>
            <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
            <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
   @endif
  </div>
       

@endsection

@section('scripts')
  
@endsection



