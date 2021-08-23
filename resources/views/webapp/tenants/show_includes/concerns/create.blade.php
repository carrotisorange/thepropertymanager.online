{{-- Modal for renewing tenant --}}
<div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Concern</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="concernForm"
                    action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/concern"
                    method="POST">
                    @csrf
                </form>

                <div class="row">
                    <div class="col">
                        <label>Date Reported</label>
                        <input type="date" form="concernForm" class="form-control" name="reported_at"
                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label>Summary</label>

                        <input type="text" form="concernForm" class="form-control" name="title"
                            placeholder="Uncessary charges to my account" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label>Category</label>
                        <select class="form-control" form="concernForm" name="category" id="" required>
                            <option value="" selected>Please select one</option>
                            <option value="billing">billing</option>
                            <option value="employee">employee</option>
                            <option value="internet">internet</option>
                            <option value="neighbour">neighbour</option>
                            <option value="noise">noise</option>
                            <option value="odours">odours</option>
                            <option value="parking">parking</option>
                            <option value="pets">pets</option>
                            <option value="repair">repair</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label>Urgency</label>
                        <select class="form-control" form="concernForm" name="urgency" id="" required>
                            <option value="" selected>Please select one</option>
                            <option value="minor and not urgent">minor and not urgent</option>
                            <option value="minor but urgent">minor but urgent</option>
                            <option value="major but not urgent">major but not urgent</option>
                            <option value="major and urgent">major and urgent</option>
                        </select>
                    </div>
                </div>
                <br>



                <div class="row">
                    <div class="col">
                        <label>Details</label>

                        <textarea form="concernForm" rows="7" class="form-control" name="details" required></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="movein_date">Assign concern to</label>
                        <select class="form-control" form="concernForm" name="concern_user_id" required>
                            <option value="" selected>Please select one</option>

                            @foreach($users as $item)
                            <option value="{{ $item->user_id_foreign }}"> {{ $item->role_id_foreign }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="concernForm" class="btn btn-primary btn-sm"><i class="fas fa-check"></i>
                    Submit</button>
            </div>
        </div>
    </div>
</div>