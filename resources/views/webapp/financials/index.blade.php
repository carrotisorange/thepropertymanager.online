@extends('layouts.argon.main')

@section('title', 'Financials')

@section('css')
 <style>
/*This will work on every browser*/
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>   
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Financials</h6>
    
  </div>

</div>
</div>
{{-- <div class="col-md-6">
  <table class="table table-hover">
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
</div> --}}
<div class="table-responsive text-nowrap">
  <div class="row" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
    <div class="col-md-12">
      <table class="table table-hover">
        <thead>
          <th>Date</th>
          <th>Collections</th>
          <th>Export</th>
        </thead>
         
          <tbody>
            @foreach ($collections as $item)
            <tr>
             <th>{{ Carbon\Carbon::create()->month($item->month)->format('M').', '.$item->year }}</th>
              <td> 
           
                ₱ {{ number_format($item->total_collections,2) }}
             
              </th>
           <th>
            <a title="export pdf" target="_blank" href="/property/{{ Session::get('property_id') }}/collections/month/{{ $item->month }}/year/{{ $item->year }}/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
           </th>
          </tr>
          @endforeach
          </tbody>
         
            
    </table>
    </div>
  </div>
@endsection



@section('scripts')
  
@endsection



