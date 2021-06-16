@extends('layouts.argon.main')

@section('title', $owner->name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Owner Information</h6>
    
  </div>

</div>
<div class="row">
  <form id="editInvestorForm" action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}" method="POST">
    @method('put')
    @csrf
</form>

                <div class="col">
                    <small>Name</small>
                    <input form="editInvestorForm" class="form-control" type="text" name="unit_owner" value="{{ $owner->name }}" >
                </div>
               
              <div class="col">
                <small>Mobile</small>
                <input form="editInvestorForm" class="form-control" type="number" name="investor_contact_no" value="{{ $owner->mobile }}" >
            </div>
            <div class="col">
              <small>Email</small>
              <input form="editInvestorForm" class="form-control" type="email" name="investor_email_address" value="{{ $owner->email }}" >
          </div>  
            
            </div>
            <br>
            <div class="row">
              
          <div class="col">
            <small>Address</small>
            <input form="editInvestorForm" class="form-control" type="text" name="investor_address" value="{{ $owner->address }}" >
        </div>  
             
          </div>
<br>
          <div class="row">
              
            <div class="col">
              <small>Authorized Representative</small>
              <input form="editInvestorForm" class="form-control" type="text" name="investor_representative" value="{{ $owner->representative }}" >
          </div>  
               
            </div>

            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-dark d-inline-block mb-0">Bank Information</h6>
                
              </div>
            
            </div>

            <div class="row">
              <div class="col">
                <small>Bank Name</small>
                <input form="editInvestorForm" class="form-control" type="text" name="bank_name" value="{{ $owner->bank_name }}">
            </div>

            <div class="col">
              <small>Account Name</small>
              <input form="editInvestorForm" class="form-control" type="text" name="account_name" value="{{ $owner->account_name? $owner->account_name: $owner->name }}">
          </div>

            <div class="col">
              <small>Account Number</small>
              <input form="editInvestorForm" class="form-control" type="text" name="account_number" value="{{ $owner->account_number }}">
            </div>
            </div>
          
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-dark d-inline-block mb-0">
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                  Unit Information
                  @else
                  Room Information
                  @endif
                
                </h6>
                
              </div>
            
            </div>

            <div class="row">
              
              <div class="col">
                <small>Date Purchased</small>
                <input form="editInvestorForm" class="form-control" type="date" name="date_purchased" value="{{ Carbon\Carbon::parse($owner->date_purchased)->format('Y-m-d') }}" required >
            </div>  
            
             <div class="col">
                <small>Purchase Amount</small>
                <input form="editInvestorForm" class="form-control" type="number" value="{{ $owner->price }}" min="1" step="0.01" name="price"  >
            </div>  

            <div class="col">
              <small>Payment type</small>
              <select name="payment_type" id=""  form="editInvestorForm" class="form-control" >
                  <option value="{{ $owner->payment_type }}? $owner->payment_type: ''">{{ $owner->payment_type? $owner->payment_type: 'Please select one' }}</option>
                  <option value="Full Cash">Full Cash</option>
                  <option value="Full Downpayment">Full Downpayment</option>
                  <option value="Installment">Installment</option>
              </select>
          </div>  
                 
              </div>
     <br>
         <div class="row">
         <div class="col">
          <p class="text-right">   
           
            <button type="submit" form="editInvestorForm" class="btn btn-primary btn-sm" ><i class="fas fa-check"></i> Update</button>
        </p>   
         </div>
        </div>  
  



</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



