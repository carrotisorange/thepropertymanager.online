<div class="modal fade" id="approveToMoveoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Moveout </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div class="modal-body">
          <form id="approveMoveoutForm" action="/property/{{ $property->property_id }}/home/{{ $tenant->unit_tenant_id }}/tenant/{{ $tenant->tenant_id }}/approve" method="POST">
            @method('put')
             {{ csrf_field() }}
            <input form ="approveMoveoutForm" type="hidden" name="action" value="approve to moveout">
          </form>
          <div class="row">
            <div class="col">
              <small>Actual Moveout Date</small>
              <input class="form-control" type="date" name="actual_move_out_date" value={{ $tenant->actual_move_out_date }}>
        
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <small>Reason for Moving Out</small>
              <select form="approveMoveoutForm" class="form-control" name="reason_for_moving_out" id="reason_for_moving_out" required>
                <option value="{{ $tenant->reason_for_moving_out }}">{{ $tenant->reason_for_moving_out }}</option>
                <option value="end of contract">end of contract</option>
                <option value="delinquent">delinquent</option>
                <option value="force majeure">force majeure</option>
                <option value="run away">run away</option>
                <option value="unruly">unruly</option>
            </select>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col">
              <small>Pending balance</small>
              <div class="table-responsive text-nowrap">
               
                <table class="table">
                  <tr>
               
                    <th>Bill No</th>
                   
                    <th>Description</th>
                    <th>Period Covered</th>
                    <th class="text-right" colspan="3">Amount</th>
                    <th>Action</th>
                  </tr>
                  @foreach ($balance as $item)
                  <tr>
                    
                      <td>{{ $item->billing_no }}</td>
              
                      <td>{{ $item->billing_desc }}</td>
                      <td>
                        {{ $item->billing_start? Carbon\Carbon::parse($item->billing_start)->format('M d Y') : null}} -
                        {{ $item->billing_end? Carbon\Carbon::parse($item->billing_end)->format('M d Y') : null }}
                      </td>
                      <td class="text-right" colspan="3">{{ number_format($item->balance,2) }}</td>
                      <td>
                        <form action="/billings/{{ $item->billing_id }}" method="POST">
                          @csrf
                          @method('delete')
                          <button title="remove this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
                        </form>
                      </td>   
                             </tr>
                  @endforeach
                  <tr>
                    <th>Total</th>
                    <th class="text-right" colspan="3">{{ number_format($balance->sum('balance'),2) }} </th>
                   </tr>  
              </table>
            
            </div>
            </div>
            
          </div>
          
       </div>
       <div class="modal-footer">
         <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button>
          <button form="approveMoveoutForm" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Approve Moveout</button>
      
     </div>
       
  
    </div>
    </div>

</div>