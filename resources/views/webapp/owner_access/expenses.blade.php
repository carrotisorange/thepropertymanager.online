@extends('webapp.owner_access.template')

@section('title', 'Expenses')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Expenses for {{ Carbon\Carbon::parse($remittance->created_at)->format('M d, Y') }}</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
@if($expenses->count() <= 0 )
<p class="text-danger text-center">No expenses found!</p>
@else
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
        <?php $ctr=1;?>
        <tr>
            <th>#</th>
            <th>Date</th>
         
            <th>Particular</th>
            <th>Amount</th>
           

        </tr>    
    </thead>
    <tbody>
        @foreach ($expenses as $item)
        <tr>
            <th>{{ $ctr++ }}</th>     
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
            <td>{{ $item->expense_particular }}</td>
            <th>{{ number_format($item->expense_amt,2) }}</th>
           
        </tr>   
        @endforeach
        <tr>
            <th></th>
            <td></td>
            <td></td>
            <th>{{ number_format($expenses->sum('expense_amt'), 2) }}</th>

        </tr>
    </tbody>
</table>
   
  </div>
@endif
       

@endsection

@section('scripts')
  
@endsection



