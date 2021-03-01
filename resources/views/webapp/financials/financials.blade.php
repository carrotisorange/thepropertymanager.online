@extends('layouts.argon.main')

@section('title', 'Financials')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Financials</h6>
    
  </div>

</div>
</div>
<div class="table-responsive text-nowrap">
  <table class="table table-bordered table-hover">
    
        <?php $ctr=1;?>
        <thead>
          <tr class="">
         
            <th>Date</th>
            <th>Collections</th>
            <th>Expenses</th>
            <th>Income</th>
    
            
        </tr>
        </thead>
  
        <tbody>
          <tr>
            <td>{{ Carbon\Carbon::now()->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_1,2) }}</td>
            <td>{{ number_format($expenses_1,2) }}</td>
            <td>{{ number_format($collection_rate_1-$expenses_1,2) }}</td>
          </tr>
          <tr>
            <td>{{ Carbon\Carbon::now()->subMonth()->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_2,2) }}</td>
            <td>{{ number_format($expenses_2,2) }}</td>
            <td>{{ number_format($collection_rate_2-$expenses_2,2) }}</td>
          </tr>
          <tr>
            <td>{{ Carbon\Carbon::now()->subMonths(2)->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_3,2) }}</td>
            <td>{{ number_format($expenses_3,2) }}</td>
            <td>{{ number_format($collection_rate_3-$expenses_3,2) }}</td>
          </tr>
          <tr>
            <td>{{ Carbon\Carbon::now()->subMonths(3)->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_4,2) }}</td>
            <td>{{ number_format($expenses_4,2) }}</td>
            <td>{{ number_format($collection_rate_4-$expenses_4,2) }}</td>
          </tr>
          <tr>
            <td>{{ Carbon\Carbon::now()->subMonths(4)->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_5,2) }}</td>
            <td>{{ number_format($expenses_5,2) }}</td>
            <td>{{ number_format($collection_rate_5-$expenses_5,2) }}</td>
          </tr>
          <tr>
            <td>{{ Carbon\Carbon::now()->subMonths(5)->format('M Y')}}</td>
            <td>{{ number_format($collection_rate_6,2) }}</td>
            <td>{{ number_format($expenses_6,2) }}</td>
            <td>{{ number_format($collection_rate_6-$expenses_6,2) }}</td>
          </tr>
        </tbody>
        
          

  </table>
   </div>
@endsection



@section('scripts')
  
@endsection



