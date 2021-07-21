@extends('layouts.argon.dashboard')

@section('title', 'Step 3 of 5 | The Property Manager')
@section('title-page')
<div class="row">
  <div class="col">
    <h2 class="text-left"><i class="fas fa-file-invoice-dollar"></i> Due dates, penalties, and rates</h2>
  </div>
  <div class="col">
    <h3 class="text-right">Step 3 of 5</h3>
  </div>
</div>
@endsection

@section('content')
<?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
<?php $ctr=1;?>
<form class="user" method="POST" action="/property/{{ Session::get('property_id') }}/duedates/store">
  @csrf
 
  <div class="row table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Bill</th>
          <th>Due date</th>
          <th>Penalty after due date(%)<th>
          <th>Rate</th>
    
        </tr>
      </thead>
      <tbody>
       @foreach ($bills as $item)
    
       <tr>
        <th>{{ $ctr++ }}</th>
        <td>{{ $item->particular }}</td>
        <td>
           
          <select class="" name="duedate{{ $item->property_bill_id }}">
            @for ($i = 1; $i <= 31; $i++)
                <option value={{ $i }}>
                  {{ $numberFormatter->format($i) }} day of the month
                </option>
            @endfor
          </select> 
        </td>
        <td>
          <input type="hidden"  min="0.00" name="bill{{ $item->property_bill_id }}" value="{{ $item->property_bill_id}}"/>
          <input type="number" class="" min="0.00" step="0.01" name="penalty{{ $item->property_bill_id}}"  value="10" required/>
        </td>
        <td></td>
        <td>
         @if($item->particular_id == '2')
         <input type="number" step="0.01" min="0.00" name="rate{{ $item->property_bill_id}}" value="0.00" required/> /cubic meter
         @elseif($item->particular_id == '3')
         <input type="number" step="0.01" min="0.00" name="rate{{ $item->property_bill_id}}" value="0.00" required/> /kilowatt hour
         @elseif($item->particular_id == '4')
         <input type="number" step="0.01" min="0.00" name="rate{{ $item->property_bill_id}}" value="0.00" required/> /square meter
         @elseif($item->particular_id == '1')
         <input type="number" step="0.01" min="0.00" name="rate{{ $item->property_bill_id}}"  value="0.00" required/> /month 
         @else
         <input type="number" step="0.01" min="0.00" name="rate{{ $item->property_bill_id}}"  value="0.00" required/>
         @endif
        
        </td>
      </tr>
    
       @endforeach
      </tbody>
    </table>
  </div>
  
   
  <div class="row">
    {{-- <div class="col">
      <p class="text-left">
        <a href="/property/all" class="btn btn-primary"><i class="fas fa-home"></i> Home</a>
      </p>
     </div> --}}

     <div class="col">
      <p class="text-right">
        <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Next</button>
      </p>
     </div>
   </div>
</form>  
            
@endsection

@section('scripts')
@endsection

