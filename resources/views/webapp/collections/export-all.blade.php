<!doctype html>
<html lang="en">
    <head>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
          body {
              font: 9px monospace;
              }
          .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
          padding: 1px;
          }
          .table>tbody>tr>td,
    .table>tbody>tr>th {
      border-top: none;
    }
        </style>
        
    
    </head>
  <body>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-12">
              <table class="table table-condensed table-borderless">
               
                <tr>
                  <th></th>
                  <td>ACCOUNTING DEPARTMENT</td>
                  <th></th>
                </tr>
                <tr>
                  <th></th>
                  <td>{{ Session::get('property_name').', '.Session::get('property_address') }}</td>
                  <th></th>
                </tr>
                <tr>
                  <th></th>
                  <td>Email Address: {{ Auth::user()->email }}, CP No: {{ Auth::user()->mobile }}</td>
                  <th></th>
                </tr>
              </table>
       
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-condensed table-borderless">
                <tr>
                  <td>To: {{ $tenant }}</td>
                  <th></th>
                  {{-- <th class="text-right">Date:{{ Carbon\Carbon::now()->firstOfMonth()->format('M d Y') }} </th> --}}
                  <td class="text-right">Date: {{ Carbon\Carbon::now()->format('M d Y') }} </td>
                </tr>
                <tr>
                  <td>Room: {{ $current_room }}</td>
                  <th></th>
                  {{-- <th  class="text-right"><span class="text-danger"><b>Due Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->addDays(7)->format('M d Y') }}</span></th> --}}
                  <td  class="text-right"><span class="text-danger"><b> </span></td>
                </tr>
                <tr>
                  <th> </th>
                  <th  class="text-center"><u>ACKOWLEDGEMENT RECEIPTS</u></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>
         
         
          <?php $ctr = 1; ?>
          <table class="table table-condensed table-bordered">
            <tr>
             
              {{-- <th>#</th> --}}
              <th>AR No</th>
              <th>Bill No </th>
           
           
              <th>Particular</th>
              <th colspan="2">Period Covered</th>
              <th>Form</th>
              <th">Amount</th>
              
            </tr>
            @foreach ($collections as $item)
            <tr>
             {{-- <th>{{ $ctr++ }}</th> --}}
             <td>{{ $item->ar_no }}</td>
              <td>{{ $item->payment_bill_no }}</td>
            
              <td>{{ $item->particular }}</td>
              <td>
                {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d,Y') : null}}
              
              </td>
              <td>
                {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d,Y') : null }}
              </td>
              <td>{{ $item->form }}</td>
              <td>{{ number_format($item->amt_paid,2) }}</td>
             
            </tr>
     
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-12">
              <table class="table table-condensed table-borderless">
                <tr>
                  <th>Total</th>
                  <th></th>
                 
                  <th class="text-right">{{ number_format($collections->sum('amt_paid'),2) }} </th>
                </tr>
                <tr>
                  <th>Running Balance</th>
                  <th></th>
                  {{-- <th  class="text-right"><span class="text-danger"><b>Due Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->addDays(7)->format('M d Y') }}</span></th> --}}
                  <th  class="text-right">{{ number_format($balance->sum('balance'),2) }}</th>
                </tr>
               
              </table>
              <table class="table table-condensed">
                <tr>
                 <td> Prepared by: {{ Auth::user()->name }}
                 <br>{{ Auth::user()->user_type }}</td>
                 <th></th>
                 <td  class="text-right"> Noted by: 
                   <br>Accounting Head</td>
               </tr>
                </table>
            </div>
          </div>
    
      </div>
    
  </body>
</html>