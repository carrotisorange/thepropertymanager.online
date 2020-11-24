<div class="modal fade" id="addGuardian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Guardian</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="guardianForm" action="/property/{{ $property->property_id }}/tenant/{{ $tenant->tenant_id }}/guardian" method="POST">
                @csrf
            </form>

            <div class="row">
              <div class="col">
                  <label>Name</label>
                  <input type="text" form="guardianForm" class="form-control" name="name" required >
              </div>
          </div>
          <br>
            <div class="row">
                <div class="col">
                   <label>Relationship</label>
                    <select class="form-control" form="guardianForm" name="relationship" id="" required>
                      <option value="" selected>Please select one</option>
                      <option value="Cousin">Cousin</option>
                      <option value="Daughter">Daughter</option>
                      <option value="Father">Father</option>
                      <option value="Friend">Friend</option>
                      <option value="Grandfather">Grandfather</option>
                      <option value="Grandmother">Grandmother</option>
                      <option value="Husband">Husband</option>
                      <option value="Mother">Mother</option>
                      <option value="Sibling">Sibling</option>
                      <option value="Son">Son</option>
                      <option value="Wife">Wife</option>
                      
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                  <label>Mobile</label>
                  <input type="text" form="guardianForm" class="form-control" name="mobile" required >
              </div>
          </div>
          <br>
          
          <div class="row">
            <div class="col">
                <label>Email</label>
                <input type="email" form="guardianForm" class="form-control" name="email" required >
            </div>
        </div>
        
       
        

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button> 
            <button type="submit" form="guardianForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
        </div>
    </div>
    </div>
</div>