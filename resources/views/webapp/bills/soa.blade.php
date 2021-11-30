<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <style>
    body {
      font: 9px monospace;
    }

    .table-condensed>thead>tr>th,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>tbody>tr>td,
    .table-condensed>tfoot>tr>td {
      padding: 1px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th {
      border-top: none;
    }
  </style>


</head>

<body>

  <!-- End of Topbar -->
  <div class="container">
    <div class="row text-center">
      <div class="col-md-11">
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
      <div class="col-md-11">
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
            {{-- <th class="text-right"><span class="text-danger"><b>Due Date:</b> {{
                Carbon\Carbon::now()->firstOfMonth()->addDays(7)->format('M d Y') }}</span>
            </th> --}}
            <td class="text-right"><span class="text-danger"><b> </span></td>
          </tr>
          <tr>
            <th> </th>
            <th class="text-center"><u>STATEMENT OF ACCOUNTS</u></th>
            <th></th>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-11">
        <table class="table table-condensed table-bordered">
          <tr>
            <th>Desription</th>
            <th>Particular</th>
            <th>Amount</th>
          </tr>
          @if($previous_bills->count() <= 0) <tr>
            <td>Previous Monthly Rent:</td>
            <th></th>
            <th></th>
            </tr>
            @else
            <tr>
              <td>Previous Monthly Rent:</td>
              <th></th>
              <th></th>
            </tr>
            @foreach ($previous_bills as $item)
            <tr>
              <th></th>
              <td>{{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</td>
              <td>{{ number_format($item->balance,2) }}</td>
            </tr>
            @endforeach
            @endif
            @if($previous_surcharges->count() <= 0) <tr>
              <td>Surcharges:</td>
              <th></th>
              <th></th>
              </tr>

              @else
              <tr>
                <td>Surcharges:</td>
                <th></th>
                <th></th>
              </tr>
              @foreach ($previous_surcharges as $item)
              <tr>
                <th></th>
                <td>{{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                  {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</td>
                <td>{{ number_format($item->balance,2) }}</td>
              </tr>
              @endforeach
              @endif


              @if($current_bills->count() <= 0) <tr>
                <td>Monthly Rent:</td>
                <th></th>
                <th></th>
                </tr>
                @else
                <tr>
                  <td>Monthly Rent:</td>
                  <th></th>
                  <th></th>
                </tr>
                @foreach ($current_bills as $item)
                <tr>
                  <th></th>
                  <td>{{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                    {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</td>
                  <td>{{ number_format($item->balance,2) }}</td>
                </tr>
                @endforeach
                @endif

                @if($other_bills->count() <= 0) <tr>
                  <td>Other Charges:</td>
                  <th></th>
                  <th></th>
                  </tr>
                  @else
                  <tr>
                    <td>Other Charges:</td>
                    <th></th>
                    <th></th>
                  </tr>
                  @foreach ($other_bills as $item)
                  <tr>
                    <td>{{ $item->particular }}</td>
                    <td>
                      {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}}
                      - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}</td>
                    <td>{{ number_format($item->balance,2) }}</td>
                  </tr>
                  @if($item->particular_id_foreign == '2' || $item->particular_id_foreign == '3')
                  <tr>
                    <td></td>
                    <td>
                      P({{ $item->prev_electricity_reading }}),
                      C({{ $item->curr_electricity_reading }}),
                      A({{ $item->curr_electricity_reading - $item->prev_electricity_reading }}),
                      R({{ $item->electricity_rate }}) </td>
                    <td></td>
                  </tr>
                  @else
                  <tr>
                    <td></td>
                    <td>
                    </td>
                    <td></td>
                  </tr>
                  @endif
                  @endforeach
                  @endif

                  <tr>
                    <td colspan="2">Advance Payments:</td>

                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="2">TOTAL AMOUNT PAYABLE</th>
                    {{-- <th colspan="2">TOTAL AMOUNT PAYABLE(If paid before due date)</th> --}}
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

                    <th class="text-danger">{{ number_format($total+$surcharge,2) }}</th>
                  </tr> --}}

        </table>
        <table>
          <tr>
            <td colspan="3">
              Previous Reading (P), Current Reading (C), Current Consumption (C), Rate (R)
            </td>
          </tr>
        </table>
        <table class="">
          <tr>
            <td> {!! Session::get('footer_message') !!}</td>
          </tr>
        </table>
        <table class="table table-condensed">
          <tr>
            <td> Prepared by: {{ Auth::user()->name }}
              <br>
            </td>
            <th></th>
            <td class="text-right"> Noted by:
              <br>Accounting Head
            </td>
          </tr>
        </table>
      </div>
    </div>

  </div>
</body>

</html>