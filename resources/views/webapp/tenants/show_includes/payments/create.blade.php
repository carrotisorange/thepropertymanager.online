

<div class="modal fade" id="acceptPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="acceptPaymentForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/collection" method="POST">
            @csrf
            </form>
            
            <div class="row">
                <div class="col-md-3">Date
           {{-- <input type="date" form="acceptPaymentForm" class="" name="payment_created" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required> --}}
                <input type="date" class='form-control' form="acceptPaymentForm" class="" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="payment_created" required >
                </div>
                <div class="col">
                    <p class="text-right">
                        <a href="#/" id='delete_payment' class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Remove</a>
                      <a href="#/" id="add_payment" class="btn btn-sm btn-primary" ><i class="fas fa-plus"></i> New</a>     
                      </p>
                </div>
                
              
            </div>
          
    <br>
            <div class="row">
              <div class="col">
                  <div class="table-responsive text-nowrap">
                  <table class = "table table-hover" id="payment">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Bill</th>
                            <th>Payment mode</th>
                            <th>Amount</th>
                            <th>Bank Name</th>
                            <th>Cheque No</th>
                        </tr>
                     </thead>
                          <input form="acceptPaymentForm" type="hidden" id="no_of_payments" name="no_of_payments" >
                      <tr id='payment1'></tr>
                  </table>
                </div>
              </div>
            </div>        
          
        </div>
        <div class="modal-footer">
            <button form="acceptPaymentForm" id ="addPaymentButton" type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check"></i> Submit</button>
        </div>
    
    </div>
    </div>
    
    
    </div>