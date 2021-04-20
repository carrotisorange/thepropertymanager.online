<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
      body {
          font: 7px monospace;
          }
      .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
      padding: 3px;
      }
      .table>tbody>tr>td,
.table>tbody>tr>th {
  border-top: none;
}
    </style>

</head>

<body>

    <!-- End of Topbar -->
    <div class="container-fluid">
        <div class="row text-center">
          <div class="col-md-12">
            <table class="table table-condensed table-borderless">
              <tr>
                <th></th>
                <th>{{ Session::get('property_name') }}</th>
                <th></th>
              </tr>
              <tr>
                <th></th>
                <th>ACCOUNTING DEPARTMENT</th>
                <th></th>
              </tr>
              <tr>
                <th></th>
                <th>{{ Session::get('property_address') }}</th>
                <th></th>
              </tr>
              <tr>
                <th></th>
                <th>Email Address: {{ Auth::user()->email }}, CP No: {{ Auth::user()->mobile }}</th>
                <th></th>
              </tr>
            </table>
     
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-condensed table-borderless">
              <tr>
                <th>Name:
                @foreach ($tenant as $item)
                {{ $item->first_name.' '.$item->last_name }}
                @endforeach
              </th>
                <th></th>
                <th class="text-right">Date: {{ Carbon\Carbon::now()->format('M d Y') }} </th>
              </tr>
              <tr>
                <th> <b>Room:</b> {{ $current_room }}</th>
                <th></th>
                <th  class="text-right"><span class="text-danger"></th>
              </tr>
              <tr>
                <th> </th>
                <th  class="text-center"><u>STATEMENT OF ACCOUNTS</u></th>
                <th></th>
              </tr>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-condensed table-bordered">
              <tr>
                <th></th>
                <th></th>
                <th>Amount</th>
              </tr>
             @if($previous_bills->count() <= 0)
             <tr>
              <th>Previous Monthly Rent:</th>
              <th></th>
              <th></th>
            </tr>
            @else
            <tr>
              <th>Previous Monthly Rent:</th>
              <th></th>
              <th></th>
            </tr>
            @foreach ($previous_bills as $item)
            <tr>
              <th></th>
              <th>{{  $item->particular }} {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</th>
              <th>{{ number_format($item->balance,2) }}</th>
            </tr>
            @endforeach
             @endif
             @if($previous_surcharges->count() <= 0)
             
             <tr>
              <th>Previous Surcharges:</th>
              <th></th>
              <th></th>
            </tr>
            
             @else
             <tr>
              <th>Previous Surcharges:</th>
              <th></th>
              <th></th>
            </tr>
             @foreach ($previous_surcharges as $item)
             <tr>
               <th></th>
               <th>{{  $item->particular }} {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</th>
               <th>{{ number_format($item->balance,2) }}</th>
             </tr>
             @endforeach
              @endif
             
  
              @if($current_bills->count() <= 0)
              <tr>
               <th>Monthly Rent:</th>
               <th></th>
               <th></th>
             </tr>
             @else
             <tr>
              <th>Monthly Rent:</th>
              <th></th>
              <th></th>
            </tr>
             @foreach ($current_bills as $item)
             <tr>
               <th></th>
               <th>{{  $item->particular }} {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</th>
               <th>{{ number_format($item->balance,2) }}</th>
             </tr>
             @endforeach
              @endif
             
              @if($other_bills->count() <= 0)
              <tr>
               <th>Other Charges:</th>
               <th></th>
               <th></th>
             </tr>
             @else
             <tr>
              <th>Other Charges:</th>
              <th></th>
              <th></th>
            </tr>
             @foreach ($other_bills as $item)
             <tr>
               <th></th>
               <th>{{  $item->particular }} {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</th>
               <th>{{ number_format($item->balance,2) }}</th>
             </tr>
             @endforeach
              @endif
          
              <tr>
                <th colspan="2">Advance Payments</th>
                
                <th></th>
              </tr>
              <tr>
                <th colspan="2">TOTAL AMOUNT PAYABLE</th>
                <?php $total = $current_bills->sum('balance')+$previous_bills->sum('balance')+$previous_surcharges->sum('balance')+$other_bills->sum('balance'); ?>  
                <?php $surcharge = $total*.1; ?>
                <th>{{ number_format($total,2) }}</th>
              </tr>
              {{-- <tr>
                <th colspan="2">ADD 10% surcharge ON RENT if not paid on due date</th>
                
                <th>{{ number_format($surcharge,2) }}</th>
              </tr>
              <tr>
                <th class="text-danger" colspan="2">TOTAL AMOUNT PAYABLE AFTER DUE DATE</th>
                
                <th class="text-danger" >{{ number_format($total+$surcharge,2) }}</th>
              </tr> --}}
       
           </table>
           <table class="table table-condensed table-bordered">
            <tr>
              <th> {!! Session::get('footer_message') !!}</th>
            </tr>
            </table>
            <table class="table table-condensed">
              <tr>
               <th> Prepared by: {{ Auth::user()->name }}
               <br>{{ Auth::user()->user_type }}</th>
               <th></th>
               <th> Noted by: 
                 <br>Accounting Head</th>
             </tr>
              </table>
          </div>
        </div>
     <div class="row">
       <div class="col-md-12">
       
       </div>
      
     </div>
     <div class="row">
      <div class="col-md-12">
      
      </div>
     
    </div>
     </div>
</body>

</html>
