@extends('layouts.argon.main')

@section('title', 'Expenses')

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/remittances/">Remittances # {{ $remittance->remittance_id }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Expenses</li>
        </ol>
      </nav>
     
    </div>
  
  </div>

@if($expenses->count() <=0 )
<p class="text-danger text-center">No expenses found!</p>

@else

<div class="table-responsive text-nowrap">
    <table class="table table-bordered table-condensed table-hover">
        <thead>
            <?php $ctr=1;?>
            <tr>
                <th>#</th>
                <th>Expense ID</th>
             
                <th>Particular</th>
                <th>Amount</th>
               
    
            </tr>    
        </thead>
        <tbody>
            @foreach ($expenses as $item)
            <tr>
                <th>{{ $ctr++ }}</th>     
                <td>{{ $item->expense_id }}</td>
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



