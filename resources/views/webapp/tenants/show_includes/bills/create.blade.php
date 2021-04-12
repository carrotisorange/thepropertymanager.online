
      <div class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="modal">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bill Information</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
         <div class="modal-body">
          <form id="addBillForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/create" method="POST">
             @csrf
          </form>
  
          
          <div class="row">
            <div class="col">
              Date
                {{-- <input type="date" class='form-control' form="addBillForm" class="" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required > --}}
                <input type="date" form="addBillForm" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date_posted" required >
              
            </div>
            <div class="col">
              <p class="text-right">
                <span id='delete_bill' class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Remove current row</span>
              <span id="add_bill" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add more bills</span>     
              </p>
            </div>
          </div>
         
          <br>
          <div class="row">
            <div class="col">
        
                <div class="table-responsive text-nowrap">
                <table class = "table table-condensed table-bordered" id="table_bill">
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

         <button form="addBillForm" type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check"></i> Post Bills</button>
        </div> 
        </div>
        </div>
        
        </div>