
      <div class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="modal">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Bill</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
         <div class="modal-body">
          <form id="addBillForm" action="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/bills/create" method="POST">
             @csrf
          </form>
  
          
          <div class="row">
            <div class="col">
                <label>Date</label>
                {{-- <input type="date" form="addBillForm" class="form-control" name="billing_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required > --}}
                <input type="date" form="addBillForm" class="" name="billing_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
            </div>
            <div class="col">
              <p class="text-right">
                <span id='delete_bill' class="btn btn-sm btn-danger"><i class="fas fa-minus fa-sm text-white-50"></i> Remove</span>
              <span id="add_bill" class="btn btn-sm btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</span>     
              </p>
            </div>
          </div>
         
          <br>
          <div class="row">
            <div class="col">
        
                <div class="table-responsive text-nowrap">
                <table class = "table" id="table_bill">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Particular</th>
                      <th colspan="2">Period Covered</th>
                      <th>Amount</th>
                      
                  </tr>
                   </thead>
                        <input form="addBillForm" type="hidden" id="no_of_bills" name="no_of_bills" >
                    <tr id='bill1'></tr>
                </table>
              </div>
            </div>
          </div>
         
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-sm text-dark-50"></i> Cancel </button>
         <button form="addBillForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
        </div> 
        </div>
        </div>
        
        </div>