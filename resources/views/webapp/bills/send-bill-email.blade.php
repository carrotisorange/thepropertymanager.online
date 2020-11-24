

    <!-- End of Topbar -->
    <div class="container">
      <div class="row">
        <div class="col-md-10">
          <h5 class="text-black-50">{{ Auth::user()->property }}</h5>
          {{-- <p class="text-right"> <b>AR #:</b> </p> --}}
          <ul style="list-style-type: none">
            <li><b>Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->format('M d Y') }}</li>
            <li class="text-danger"><b>Due Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->addDays(7)->format('M d Y') }}</li>
            <li><b>To:</b> {{ $tenant }}</li>
            <li><b>Room:</b> {{ $unit }}</li>
          </ul>
          <p class="text-right">Statement of Accounts</p>
          <div class="table-responsive text-nowrap">
            <table class="table text-right">
              <tr>
                <th>Bill No</th>
                <th>Description</th>
                <th>Period Covered</th>
                <th>Amount</th>
              </tr>
              @foreach ($rent_bills as $item)
              <tr>
                  <td>{{ $item->billing_no }}</th>
                  <td>{{ $item->billing_desc }}</td>
                  <td>
                    @if($item->details === null)
                   -
                    @else
                    {{ $item->details }}
                    @endif
                  </td>
                  <th class="text-right" colspan="3">{{ number_format($item->billing_amt,2) }}</th>
              </tr>
              @endforeach
              @foreach ($other_bills as $item)
              <tr>
                <td>{{ $item->billing_no }}</th>
                  <td>{{ $item->billing_desc }}</td>
                  <td> 
                    @if($item->details === null)
                    -
                    @else
                    {{ $item->details }}
                    @endif
                  </td>
                  <th class="text-right" colspan="3">{{ number_format($item->billing_amt,2) }}</th>
              </tr>
              @endforeach
        
          </table>
          <table class="table" >
            <tr>
             <th>TOTAL AMOUNT PAYABLE</th>
             <th class="text-right">{{ number_format($total_bills,2) }} </th>
            </tr>
            @if($tenant_status === 'pending')

            @else
            <tr>
              <th class="text-danger">TOTAL AMOUNT PAYABLE AFTER DUE DATE (+10%)</th>
              <th class="text-right text-danger">{{ number_format($total_bills + ($total_bills * .1) ,2) }}</th>
             </tr>
            @endif  
          </table>
          </div>
         
          
          <div class="card-body">
            <p class="text-center">
                  {{ Auth::user()->note }}
            </p>
          </div>
          
          <ul style="list-style-type: none">
            <li><b>Posted by:</b> {{ Auth::user()->name }}</li>
            <li>{{ ucfirst(Auth::user()->user_type).' of '. Auth::user()->property }}</li>
          </ul>
        
        </div>
      </div>

    </div>

