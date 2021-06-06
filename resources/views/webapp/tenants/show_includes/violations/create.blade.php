{{-- Modal for renewing tenant --}}
                <div class="modal fade" id="addViolation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Violation</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form id="concernForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/concern" method="POST">
                                @csrf
                            </form>
  
                            <div class="row">
                              <div class="col">
                                  <label>Date committed</label>
                                  <input type="date" form="concernForm" class="form-control" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
                              </div>
                          </div>
                          <br>
                         
                            <div class="row">
                                <div class="col">
                                   <label>Violation</label>
                                    <select class="form-control" form="concernForm" name="category" id="" required>
                                      <option value="" selected>Please select one</option>
                                      @foreach($violations_type as $item)
                                      <option value="{{ $item->violation_type_id }}">{{ $item->title }} - {{ $item->description }}</option>      
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col">
                                 <label>Frequency</label>
                                  <select class="form-control" form="concernForm" name="urgency" id="" required>
                                    <option value="" selected>Please select one</option>
                                    <option value="warning">warning</option>
                                    <option value="1st offense">1st offence</option>
                                    <option value="2nd offense">2nd offence</option>
                                    <option value="3rd offence">3rd offence</option>
                                    <option value="nth offence">nth offence</option>
                                  </select>
                              </div>
                          </div>
                          <br>
                            <div class="row">
                              <div class="col">
                                 <label>Severity</label>
                                  <select class="form-control" form="concernForm" name="urgency" id="" required>
                                    <option value="" selected>Please select one</option>
                                    <option value="minor">minor</option>
                                    <option value="major">major</option>
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
                                  <label>Sanction</label>
                                  
                                  <textarea form="concernForm" rows="7" class="form-control" name="details" required></textarea>
                              </div>
                          </div>
                         
                        </div>
                        <div class="modal-footer">
                            <button type="submit" form="concernForm" class="btn btn-primary btn-sm" ><i class="fas fa-check"></i> Submit</button>
                        </div>
                    </div>
                    </div>
                </div>