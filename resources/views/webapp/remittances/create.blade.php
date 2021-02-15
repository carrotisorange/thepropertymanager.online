@extends('layouts.argon.main')

@section('title', $owner_info->name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/collections/">Collections</a></li>
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/remittances/">Remittances</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
      </ol>
    </nav>
   
  </div>

</div>

<div class="container card card-body">
  <div class="card-title text-center">
    Check Voucher
  </div>
<div class="row">
  <div class="col-md-6">
    <table class="table table-borderless">
      
      <tr>
          <th>Payee</th>
          <td>{{ $owner_info->name }}</td>
         
      </tr>

      <tr>
          <th>Address</th>
          <td>{{ $room_info->building.' '.$room_info->unit_no }}</td>
         
      </tr>
  
   
      <tr>
          <th>Acct No</th>
          <td>{{ $owner_info->account_number }}</td>
         
      </tr>

      <tr>
          <th>Bank</th>
          <td>{{ $owner_info->bank_name }}</td>
      </tr>
 
    </table>

  </div>
  <div class="col-md-6">
    <table class="table table-borderless">
      <tr>
        <th>CV No</th>
        <td><input type="text" name="cv_no" value=""/></td>
       
    </tr>
      <tr>
        
          <th>Date</th>
          <td><input type="date" name="date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"/></td>
         
      </tr>
 
      <tr>
        <th>Check No</th>
        <td><input type="text" name="check_no" value=""/></td>
         
      </tr>
      <tr>
        <th>Bank</th>
        <td>{{ $owner_info->bank_name }}</td>
    </tr>
    
    </table>
  </div>
</div>
<hr>
<p>Remittance of {{ Carbon\Carbon::parse($bill_info->start)->format('M d, Y').' - '.Carbon\Carbon::parse($bill_info->end)->format('M d, Y') }} collection (<span class="text-danger">monthly rent</span> and/or transient) </p>
<div class="row">
  <div class="col-md-7">
          <table class="table table-bordered">
        <tr>
          <th colspan="2" class="text-center">Particulars</th>
        </tr>
        <tr>
          <th>Tenant</th>
          <td>{{ $tenant_info->first_name.' '.$tenant_info->last_name }}</td>
        </tr>
        <tr>
          <th>Particulars</th>
          <td>{{ $bill_info->particular.' '.Carbon\Carbon::parse($bill_info->start)->format('M d, Y').' - '.Carbon\Carbon::parse($bill_info->end)->format('M d, Y') }}</td>
        </tr>
        <tr>
          <th>Date Paid</th>
          <td>{{ Carbon\Carbon::parse($payment_info->payment_created)->format('M d, Y')}}</td>
        </tr>
        <tr>
          <th>Moveout Date</th>
          <td>{{ Carbon\Carbon::parse($tenant_info->moveout_at)->format('M d, Y')}}</td>
        </tr>
        <tr>
          <th>Amount Collected</th>
          <td>{{ number_format($amount_collected, 2) }}</td>
        </tr>
       
        <tr>
          <th>Deductions</th>
          <td></td>
        </tr>
  
            <tr>
              <td>Management Fee</td>
              <td><input type="text" name="mgmt_fee_desc" value=""/></td>
              <td><input type="number" step="0.001" name="mgmt_fee_amt" value=""/></td>
            </tr>
            <tr>
              <td>Purchased Mtls/Bank Charges</td>
              <td><input type="text" name="purchased_desc" value=""/></td>
              <td><input type="number" step="0.001" name="purchased_amt" value=""/></td>
            </tr>
            <tr>
              <td>Bladder Tank</td>
              <td><input type="text" name="bladder_tank_desc" value=""/></td>
              <td><input type="number" step="0.001" name="bladder_tank_amt" value=""/></td>
            </tr>
            <tr>
              <td>Pest Control</td>
              <td><input type="text" name="pest_control_desc" value=""/></td>
              <td><input type="number" step="0.001" name="pest_control_amt" value=""/></td>
            </tr>
            <tr>
              <td>Water</td>
              <td><input type="text" name="water_desc" value=""/></td>
              <td><input type="number" step="0.001" name="water_amt" value=""/></td>
            </tr>
            <tr>
              <td>Electric</td>
              <td><input type="text" name="electric_desc" value=""/></td>
              <td><input type="number" step="0.001" name="electric_amt" value=""/></td>
            </tr>
            <tr>
              <td>Surcharge</td>
              <td><input type="text" name="surcharge_desc" value=""/></td>
              <td><input type="number" step="0.001" name="surcharge_amt" value=""/></td>
            </tr>
            <tr>
              <td>Building Insurance</td>
              <td><input type="text" name="building_insurance_desc" value=""/></td>
              <td><input type="number" step="0.001" name="building_insurance_amt" value=""/></td>
            </tr>
            <tr>
              <td>Condo Dues</td>
              <td><input type="text" name="condo_dues_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input type="number" step="0.001" name="condo_dues_amt" value=""/></td>
            </tr>
            <tr>
              <td>Unpaid Balances-Condo Corp</td>
              <td><input type="number" step="0.001" name="unpaid_balances_desc" value=""/></td>
              <td><input type="number" step="0.001" name="unpaid_balances_amt" value=""/></td>
            </tr>
            <tr>
              <th>Total Deductions</th>
              <td></td>
              <td><input type="number" step="0.001" name="total_deductions" id="total_deductions" value="" readonly/></td>
            </tr>
       
    </table>

  </div>
  <div class="col-md-5">
    <table class="table table-bordered">
      
        <tr class="text-center">
          <th>Amount</th>
        </tr>
        
    </table>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-7">
    <table class="table table-bordered">
      
      <tr class="text-left">
        <th class="">TOTAL AMOUNT TO BE REMITTED</th>
      </tr>
      
  </table>
  </div>
  <div class="col-md-5">
    <table class="table table-bordered">
      
      <tr class="text-center">
        <th class="text-center">123</th>
      </tr>
      
  </table>
  </div>
</div>
</div>
 

@endsection

@section('main-content')

@endsection

@section('scripts')
@endsection



