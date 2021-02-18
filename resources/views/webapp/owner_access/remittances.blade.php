@extends('webapp.owner_access.template')

@section('title', 'Remittances')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Remittances</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
  @if($remittances->count() <=0 )
  <p class="text-danger text-center">No remittances found!</p>
  @else
  <table class="table">
    <thead>
        <?php $ctr=1;?>
        <tr>
            <th>#</th>
            <th>Date Prepared</th>
            <th>Period Covered</th>
            <th>Particular</th>
            <th>CV</th>
            <th>Check #</th>
         
            <th>Status</th>
            <th>Amount</th>

        </tr>    
    </thead>
    <tbody>
        @foreach ($remittances as $item)
        <tr>
            <th>{{ $ctr++ }}</th>     
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
            
            <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td>
            <td>{{ $item->particular }}</td>
            <td>{{ $item->cv_number }}</td>
            <td>{{ $item->check_number }}</td>
            
           <td>
            @if($item->remitted_at === NULL)
            <span class="badge badge-danger">pending</span>
            @else
            <span class="badge badge-success">remitted</span>
            @endif
           </td>
            <th><a href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittance/{{ $item->remittance_id }}/expenses">{{ number_format($item->amt_remitted,2) }}</a></th>
        </tr>   
        @endforeach
       
        <tr>
          <th>TOTAL</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>{{ number_format($remittances->sum('amt_remitted'),2) }}</th>
        </tr>
    
    </tbody>
</table>
  @endif
</div>
       

@endsection

@section('scripts')
  
@endsection



