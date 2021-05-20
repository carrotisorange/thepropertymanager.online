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

<form id="remittanceForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room_info->unit_id }}/contract/{{ $contract_info->contract_id }}/tenant/{{ $tenant_info->tenant_id }}/bill/{{ $bill_info->bill_id }}/payment/{{ $payment_info->payment_id }}/remittance/store" method="POST">
  @csrf
</form>
{{-- <div class="card-title text-center">
  Check Voucher
</div> --}}
<div class="container card card-body" style="overflow-y:scroll;overflow-x:scroll;height:450px;">

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
          <td>{{ $owner_info->bank_name? $owner_info->bank_name: 'NA' }}</td>
      </tr>
 
    </table>

  </div>
  <div class="col-md-6">
    <table class="table table-borderless">
      <tr>
        <th>CV No</th>
        <td><input form="remittanceForm" type="text" name="cv_number" value=""/></td>
       
    </tr>
      <tr>
        
          <th>Date</th>
          <td><input form="remittanceForm" type="date" name="date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"/></td>
         
      </tr>
 
      <tr>
        <th>Check No</th>
        <td><input form="remittanceForm" type="text" name="check_number" value=""/></td>
         
      </tr>
      <tr>
        <th>Bank</th>
        <td><input form="remittanceForm" type="text" name="bank" value="{{ $owner_info->bank_name }}"/></td>
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
          <td><input type="number" step="0.001" name="amount_collected" id="amount_collected" value="{{ $amount_collected }}" readonly/></td>
        </tr>
       
        <tr>
          <th>Deductions</th>
          <td></td>
        </tr>
        <tr>
          <td>Bladder Tank</td>
          <td><input form="remittanceForm" type="text" name="bladder_tank_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="bladder_tank_amt" oninput="computeTotalDeductions()" id="bladder_tank_amt" value="0.00"/></td>
        </tr>
        <tr>
          <td>Building Insurance</td>
          <td><input form="remittanceForm" type="text" name="building_insurance_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="building_insurance_amt" oninput="computeTotalDeductions()" id="building_insurance_amt" value="0.00"/></td>
        </tr>
        <tr>
          <td>Cable</td>
          <td><input form="remittanceForm" type="text" name="cable_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="cable_amt" id="cable_amt" oninput="computeTotalDeductions()" value="0.00"/></td>
        </tr>
        <tr>
          <td>Condo Dues</td>
          <td><input form="remittanceForm" type="text" name="condo_dues_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="condo_dues_amt" id="condo_dues_amt" oninput="computeTotalDeductions()" value="{{ number_format($room_info->size*$room_info->condodues, 2) }}"/></td>
        </tr>
        <tr>
          <td>Contractor & Transformer</td>
          <td><input form="remittanceForm" type="text" name="contractor_and_transformer_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="contractor_and_transformer_amt" id="contractor_and_transformer_amt" oninput="computeTotalDeductions()" value="0.00"/></td>
        </tr>
        <tr>
          <td>Electric</td>
          <td><input form="remittanceForm" type="text" name="electric_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="electric_amt" oninput="computeTotalDeductions()" id="electric_amt" value="0.00"/></td>
        </tr>
        <tr>
          <td>General Cleaning</td>
          <td><input form="remittanceForm" type="text" name="general_cleaning_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="general_cleaning_amt" id="general_cleaning_amt" oninput="computeTotalDeductions()" value="0.00"/></td>
        </tr>
        <tr>
          <td>Laundry</td>
          <td><input form="remittanceForm" type="text" name="laundry_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
          <td><input form="remittanceForm" type="number" step="0.001" name="laundry_amt" id="laundry_amt" oninput="computeTotalDeductions()" value="0.00"/></td>
        </tr>
            <tr>
              <td>Management Fee</td>
              <td><input form="remittanceForm" type="text" name="mgmt_fee_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="mgmt_fee_amt" oninput="computeTotalDeductions()" id="mgmt_fee_amt"  value="0.00"/></td>
            </tr>
            <tr>
              <td>Purchased Mtls/Bank Charges</td>
              <td><input form="remittanceForm" type="text" name="purchased_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="purchased_amt" oninput="computeTotalDeductions()" id="purchased_amt" value="0.00"/></td>
            </tr>
           
            <tr>
              <td>Pest Control</td>
              <td><input form="remittanceForm" type="text" name="pest_control_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="pest_control_amt" oninput="computeTotalDeductions()" id="pest_control_amt" value="0.00"/></td>
            </tr>
           
            <tr>
              <td>Real Property Tax</td>
              <td><input form="remittanceForm" type="text" name="real_property_tax_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="real_property_tax_amt" oninput="computeTotalDeductions()" id="real_property_tax_amt" value="0.00"/></td>
            </tr>
            <tr>
              <td>Surcharge</td>
              <td><input form="remittanceForm" type="text" name="surcharge_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="surcharge_amt" oninput="computeTotalDeductions()" id="surcharge_amt" value="0.00"/></td>
            </tr>
            <tr>
              <td>Unpaid Balances-Condo Corp</td>
              <td><input form="remittanceForm" type="text" name="unpaid_balances_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="unpaid_balances_amt" id="unpaid_balances_amt" oninput="computeTotalDeductions()" value="0.00"/></td>
            </tr>
            <tr>
              <td>Water</td>
              <td><input form="remittanceForm" type="text" name="water_desc" value="{{ Carbon\Carbon::parse($bill_info->start)->format('M Y') }}"/></td>
              <td><input form="remittanceForm" type="number" step="0.001" name="water_amt" oninput="computeTotalDeductions()" id="water_amt" value="0.00"/></td>
            </tr>
            <tr>
              <th>Total Deductions</th>
              <td></td>
              <td><input type="number" step="0.001" name="total_deductions" id="total_deductions" value="0.00" readonly/></td>
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
        <th class="text-center"><input form="remittanceForm" type="number" step="0.001" name="amount_to_be_remitted" id="amount_to_be_remitted" value="{{ $amount_collected-($room_info->size*$room_info->condodues) }}" readonly/></th>
      </tr>
      
  </table>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <p class="text-right">
      <button type="submit" form="remittanceForm" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Process Remittance</button>
    </p>
  </div>
</div>
</div>
 

@endsection

@section('main-content')

@endsection

@section('scripts')
<script>
  function computeTotalDeductions(){
    var mgmt_fee_amt = document.getElementById('mgmt_fee_amt').value;
    var purchased_amt = document.getElementById('purchased_amt').value;
    var bladder_tank_amt = document.getElementById('bladder_tank_amt').value;
    var pest_control_amt = document.getElementById('pest_control_amt').value;
    var water_amt = document.getElementById('water_amt').value;
    var electric_amt = document.getElementById('electric_amt').value;
    var surcharge_amt = document.getElementById('surcharge_amt').value;
    var building_insurance_amt = document.getElementById('building_insurance_amt').value;
    var condo_dues_amt = document.getElementById('condo_dues_amt').value;
    var unpaid_balances_amt = document.getElementById('unpaid_balances_amt').value;
    var real_property_tax_amt = document.getElementById('real_property_tax_amt').value;
    var contractor_and_transformer_amt = document.getElementById('contractor_and_transformer_amt').value;
    var cable_amt = document.getElementById('cable_amt').value;
    var general_cleaning_amt = document.getElementById('general_cleaning_amt').value;
    var laundry_amt = document.getElementById('laundry_amt').value;

    var total_deductions = eval(laundry_amt) + eval(general_cleaning_amt) + eval(cable_amt) + eval(contractor_and_transformer_amt) + eval(mgmt_fee_amt) + eval(purchased_amt) + eval(bladder_tank_amt) + eval(pest_control_amt) + eval(water_amt) + eval(electric_amt) + eval(surcharge_amt) + eval(building_insurance_amt) + eval(condo_dues_amt) + eval(unpaid_balances_amt) + eval(real_property_tax_amt);

    document.getElementById('total_deductions').value = parseFloat(total_deductions, 2);

    var amount_collected = document.getElementById('amount_collected').value;

    document.getElementById('amount_to_be_remitted').value = eval(amount_collected)-eval(total_deductions);

   
  }
</script>
@endsection



