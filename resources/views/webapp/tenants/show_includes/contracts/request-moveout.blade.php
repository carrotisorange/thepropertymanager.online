<div class="modal fade" id="requestToMoveoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terminate </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div class="modal-body">
        <form id="requestMoveoutForm" action="/property/{{Session::get('property_id')}}/home/{{ $tenant->unit_tenant_id }}/tenant/{{ $tenant->tenant_id }}/request" method="POST">
          @method('put')
           @csrf
          </form>
          <input form="requestMoveoutForm" type="hidden" name="action" value="request to moveout">
          <input type="hidden" form="requestMoveoutForm" id="unit_tenant_id" name="unit_tenant_id" value="{{ $tenant->unit_tenant_id }}"required>
          <input type="hidden" form="requestMoveoutForm" id="tenant_id" name="tenant_id" value="{{ $tenant->tenant_id }}"required>
          <div class=" row">
            <div class="col-md-8">
                <small>Moveout Date</small>
                <input class='form-control col-md-6' type="date" form="requestMoveoutForm" name="actual_move_out_date" id="actual_moveout_date" value="{{ $tenant->moveout_date }}" required>
            </div>

            <div class="col-md-4">
              <small>Select Reason of Moveout</small>
                <select class='form-control' form="requestMoveoutForm" name="reason_for_moving_out" id="reason_for_moving_out" required>
                    <option value="">Please select one</option>
                    <option value="end of contract">end of contract</option>
                    <option value="delinquent">delinquent</option>
                    <option value="force majeure">force majeure</option>
                    <option value="run away">run away</option>
                    <option value="unruly">unruly</option>
                </select>
            </div>
        </div>
        <br>
        @if($balance->count() > 1 )

    

        <div class="row">
          <div class="col">
            <small>Pending balance</small>
            <div class="table-responsive text-nowrap">
             
              <table class="table table-bordered">
                <tr>
              
                  <th>Bill No</th>
                 
                  <th>Particular</th>
                  <th>Period Covered</th>
                  <th class="text-right" colspan="3">Amount</th>
                  
                </tr>
                @foreach ($balance as $item)
                <tr>
                
                    <td>{{ $item->bill_no }}</td>
            
                    <td>{{ $item->particular }}</td>
                    <td>
                      {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                      {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                    </td>
                    <td class="text-right" colspan="3">{{ number_format($item->balance,2) }}</td>
                           </tr>
                @endforeach
          
            </table>
            <table class="table">
              <tr>
               <th>TOTAL AMOUNT PAYABLE</th>
               <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
              </tr>    
            </table>
          </div>
          </div>
          
        </div>
        <hr>
        @endif
        <div class="row">
          <div class="col">

            <p class="">
              <span id='delete_row' class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-minus fa-sm text-white-50"></i> Bill</span>
            <span id="add_row" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Bill </span>     
            </p>
              <div class="table-responsive text-nowrap">
              <table class = "table table-bordered" id="tab_logic">
                  <tr>
                      <th>Bill No</th>
                      <th>Item</th>
                      <th>Price</th>
                      <th>Qty</th>
                      <th>Amount</th>
                      
                  </tr>
                      <input form="requestMoveoutForm" type="hidden" id="no_of_charges" name="no_of_charges" >
                  <tr id='addr1'></tr>
              </table>
            </div>
          </div>
        </div>
          <br>
          
         
       </div>
       <div class="modal-footer">
         <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Close</button>
        
          <button type="submit" form="requestMoveoutForm" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i>  Terminate</button>
       
     </div>
       
  
    </div>
    </div>

</div>