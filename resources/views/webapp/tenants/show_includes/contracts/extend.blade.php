<div class="modal fade" id="extendTenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Extend</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="extendTenantForm" action="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/extend" method="POST">
                @csrf
            </form>

            <div class="row">
                <div class="col-md-8">
                    <label for="movein_date">New Move in Date</label>
                    <input class='form-control' type="date" form="extendTenantForm" class="" name="movein_date" value="{{ $tenant->moveout_date }}" required>
                    <input type="hidden" form="extendTenantForm" class="" name="action" value="extend_contract" required>
                    {{-- <input type="text" form="" class="form-control" name="" value="{{ Carbon\Carbon::parse($tenant->moveout_date)->format('M d Y') }}" required readonly> --}}
                </div>

                <div class="col-md-4">
                  <label for="moveout_date">Extend Contract To</label>
                  <input class='form-control' type="number" form="extendTenantForm" min="1" class="" name="no_of_months" min="1" placeholder="enter the number of months" required >
                  <input type="hidden" form="extendTenantForm" class="form-control" name="old_movein_date" value="{{ $tenant->movein_date }}" required>
              </div>
            </div>
            <br>
        
            
            <div class="row">
                <div class="col"> 
                       <p class="">
                        <span id='remove_charges' class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-minus fa-sm text-white-50"></i> Remove</span>
                        <span id="add_charges" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</span>     
                       </p>
                    
                    
                        <table class ="table table-bordered" id="extend_table">
                            <tr>
                                <th>Bill No</th>
                                <th>Description</th>
                                <th colspan="2">Period Covered</th>
                                <th>Amount</th>
                            </tr>
                                <input form="extendTenantForm" type="hidden" id="no_of_items" name="no_of_items" >
                            
                            <tr id='row1'></tr>
                        </table>
                </div>
              </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button> --}}
            <button form="extendTenantForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
        </div>
    </div>
    </div>
</div>