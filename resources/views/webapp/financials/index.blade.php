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
  <div class="row">
    <div class="col-md-6">
      <table class="table table-bordered table-hover">
        <thead>
          <th>Date</th>
          <th>Collections</th>
          <th>Export</th>
        </thead>
          @foreach ($collections as $item)
          <tbody>
            <tr>
             <th>{{ Carbon\Carbon::create()->month($item->month)->format('M').', '.$item->year }}</th>
              <td> 
           
                ₱ {{ number_format($item->total_collections,2) }}
             
              </th>
           <th class="text-center">
            <a title="export pdf" target="_blank" href="/property/{{ Session::get('property_id') }}/collections/month/{{ $item->month }}/year/{{ $item->year }}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
           </th>
          </tr>
          </tbody>
          @endforeach
            
    </table>
    </div>
    <div class="col-md-6">
      <table class="table table-bordered table-hover">
        <thead>
          <th>Date</th>
          <th>Expenses</th>
        </thead>

          @foreach ($expenses as $item)
        <tbody>
          <tr>
           <th>{{ Carbon\Carbon::create()->month($item->month)->format('M').', '.$item->year }}</th>
            <td> 
         
             <span class="text-danger"> ₱ -{{ number_format($item->total_expenses,2) }}</span>
           
            </th>
  
         
          </tr>
          </tbody>
          @endforeach
            
    </table>
    </div>
    {{-- <div class="col-md-4">
      <table class="table table-bordered table-hover">
        <thead>
          <th>Date</th>
          <th>Collections</th>
          <th>Expenses</th>
          <th>Income</th>
        </thead>
          @foreach ($incomes as $item)
          <tbody>
            <tr>
             <th>{{ Carbon\Carbon::create()->month($item->month)->format('M').', '.$item->year }}</th>
              <td> 
           
                ₱ {{ number_format($item->total_collections,2) }}
             
              </th>
    
              <td> 
           
                ₱ {{ number_format($item->total_expenses,2) }}
             
              </th>
           
          </tr>
          </tbody>
          @endforeach
            
    </table>
    </div> --}}
  </div>
</div>
@endsection



@section('scripts')
  
@endsection



