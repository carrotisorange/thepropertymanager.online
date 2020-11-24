<!doctype html>
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
    </style>

</head>
  <body>
    <div class="container-fluid">    
      
      <p class="font-italic"> Daily Collections</p> 
          
          <b>Date:</b> {{ Carbon\Carbon::now() }}
           <br>
           <b>Number of payments made:</b> {{ $collections->count() }}
          <br>

      <br>
          <table class="table table-condensed">
       <thead>
        <tr>
          <th>#</th>
            <th>AR No</th>
            <th>Bill No </th>
            <th>Description</th>
            <th colspan="2">Period Covered</th>
            <th>Form</th>
            <th class="text-right">Amount</th>
            
          </tr>
       </thead>
            <?php $ctr =1; ?>
            @foreach ($collections as $item)
            <tr>
                <th>{{ $ctr++ }}</th>
                <td>{{ $item->ar_no }}</td>
              <td>{{ $item->payment_billing_no }}</td>
            
              <td>{{ $item->billing_desc }}</td>
              <td colspan="2">
                {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
              </td>
        \
              <td>{{ $item->form_of_payment }}</td>
              <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
             
            </tr>
            @endforeach
            <tr>
                <th>Total</th>
                <th class="text-right" colspan="7">{{ number_format($collections->sum('amt_paid'),2) }}</th>
            </tr>
           
        </table>
        
      
      </div>
    
  </body>
</html>