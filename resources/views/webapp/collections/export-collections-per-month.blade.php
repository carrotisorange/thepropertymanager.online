<!doctype html>
<html lang="en">

<head>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <style>
    body {
      font: 7px monospace;
    }

    .table-condensed>thead>tr>th,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>tbody>tr>td,
    .table-condensed>tfoot>tr>td {
      padding: 3px;
    }
  </style>

</head>

<body>
  <div class="container-fluid">

    <p class="font-italic"> Collection Report</p>

    <b>Property:</b> {{ Session::get('property_name') }}
    <br>
    <b>Date:</b> {{ $date }}
    <br>
    <b># collections:</b> {{ $collections->count() }}
    <br>
    <b>Exported by:</b> {{ Auth::user()->name }}
    <br>
    <br>
    <table class="table table-condensed">
      <thead>
        <tr>
          {{-- <th>#</th> --}}
          <th>AR No</th>


          <th>Particular</th>
          <th colspan="2">Period Covered</th>
          <th>Form</th>
          <th class="text-right">Amount</th>

        </tr>
      </thead>
      <?php $ctr =1; ?>
      @foreach ($collections as $item)
      <tr>
        {{-- <th>{{ $ctr++ }}</th> --}}
        <td>{{ $item->ar_no }}</td>


        <td>{{ $item->particular }}</td>
        <td colspan="2">
          {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
          {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
        </td>

        <td>{{ $item->form }}</td>
        <td class="text-right"> {{ number_format($item->amt_paid,2) }}</td>

      </tr>
      @endforeach
      <tr>
        <th>TOTAL</th>
        <th class="text-right" colspan="8">{{ number_format($collections->sum('amt_paid'),2) }}</th>
      </tr>

    </table>


  </div>

</body>

</html>