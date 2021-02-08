<div class="modal fade" id="addInvestor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="addInvestorForm" action="/property/{{Session::get('property_id')}}/room/{{ $home->unit_id }}/owner" method="POST">
            @csrf
        </form>
        <div class="modal-body">
            <div class="form-group">
            <label>Name</label>
            <input form="addInvestorForm" type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input form="addInvestorForm" type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input form="addInvestorForm" type="number" class="form-control" name="mobile" id="mobile">
            </div>            
        </div>
        <div class="modal-footer">
        <button type="submit" form="addInvestorForm" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add Owner</button>  
        </div>
    </div>
    </div>
  </div>