@extends('layouts.argon.main')

@section('title', 'Tenant Concern Form')

@section('css')

@endsection

@section('upper-content')
{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!------ Include the above in your HEAD tag ---------->

<section class="testimonial py-3" id="testimonial">
    <div class="container">
      <h2 class="pb-2 text-center">Tenant concern form</h2>
        <div class="row ">
            {{-- <div class="col-md-4 py-5 bg-primary text-white text-center ">
                <div class=" ">
                    <div class="card-body">
                        <img src="http://www.ansonika.com/mavia/img/registration_bg.svg" style="width:30%">
                        <h2 class="py-3">Registration</h2>
                        <p>Tation argumentum et usu, dicit viderer evertitur te has. Eu dictas concludaturque usu, facete detracto patrioque an per, lucilius pertinacia eu vel.

</p>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 py-3">
              <form id="concernTenantForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/concern/store" method="POST">
                @csrf
              </form>
                
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <input form="concernTenantForm" name="reported_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" type="date" required>
                    </div>
                  </div>
                   
                    <div class="form-row">
                     
                        <div class="form-group col-md-4">
                                  
                                  <select form="concernTenantForm" name="concern_department" class="form-control" required>
                                    <option value="" selected>Concern department...</option>
                                    <option value="leasing">Leasing</option>
                                    <option value="property_management" >Property Management</option>
                                    <option value="accounting">Accounting</option>
                                
                                  </select>
                        </div>
                        <div class="form-group col-md-4">
                                  
                          <select form="concernTenantForm" name="urgency" class="form-control" required>
                            <option value="" selected>Urgency...</option>
                            <option value="emergency"> Emergency</option>
                            <option value="major_concern"> Major Concern</option>
                            <option value="minor_concern"> Minor Concern</option>
                        
                          </select>
                </div>

                <div class="form-group col-md-4">
                                  
                  <select form="concernTenantForm" id="is_warranty" class="form-control" required>
                    <option value="" selected>Warranty...</option>
                    <option value="yes"> Yes</option>
                    <option value="no"> No</option>
                 
                  </select>
        </div>
                     
                    </div>

                    <div class="form-row">
                      
                        <div class="form-group col-md-4">
                          <select form="concernTenantForm" class="form-control" name="concern_tenant_id" id="" required>
                            <option value="{{ $tenant->tenant_id }}">{{ $tenant->first_name.' '.$tenant->last_name }}</option>
                          </select>
                         
                        </div>
                        <div class="form-group col-md-4">
                          <select form="concernTenantForm" class="form-control" name="concern_unit_id" id="" required>
                            @foreach ($contracts as $item)
                            <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="form-group col-md-4">
                          <input form="concernTenantForm" name="contact_no" placeholder="Contact No" value="{{ $tenant->contact_no }}" class="form-control" type="number" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <textarea form="concernTenantForm" name="details" placeholder="Details of the concern" cols="40" rows="5" class="form-control" required></textarea>
                </div>
                       </div>
<hr>
                       <div class="form-row">
                     
                        <div class="form-group col-md-4">
                                  
                                  <select form="concernTenantForm" name="endorsed_to" class="form-control" required>
                                    <option value="" selected>Endorsed to...</option>
                                    @foreach ($users as $item)
                                    <option value="{{ $item->user_id_foreign }}">{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                        </div>

                        <div class="form-group col-md-4">
                          <input form="concernTenantForm" name="scheduled_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" type="date" required>
                        </div>
                
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <textarea form="concernTenantForm" name="action_taken" placeholder="Course of action taken..." cols="40" rows="5" class="form-control" required></textarea>
              </div>
                    </div>
<div class="row">
  <div class="col">
    <label for="">Materials used</label>
    
  </div>
  <div class="col">
    <p class="text-right">
      <span id='remove_material' class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Remove</span>
    <span id="add_material" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add</span>     
    </p>
  </div>
</div>
                    <div class="form-row">
        
                      <div class="form-group col-md-12">
                      
                        <div class="table-responsive text-nowrap">
                          <table class = "table table-hover" id="table_materials">
                             <thead>
                              <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                
                            </tr>
                             </thead>
                                  <input form="addBillForm" type="hidden" id="no_of_materials" name="no_of_materials" >
                              <tr id='bill1'></tr>
                          </table>
                        </div>
              </div>
                    </div>

                    <div class="form-row">
                      
                      <div class="form-group col-md-4">
                                  
                        <select form="concernTenantForm" name="resolved_by" class="form-control" required>
                          <option value="" selected>Resolved by...</option>
                          @foreach ($users as $item)
                          <option value="{{ $item->user_id_foreign }}">{{ $item->name }}</option>
                          @endforeach
                        </select>
              </div>

              <div class="form-group col-md-4">
                                  
                <select form="concernTenantForm" name="status" class="form-control" required>
                  <option value="" selected>Status...</option>
                 <option value="pending">pending</option>
                 <option value="active">active</option>
                 <option value="closed">closed</option>
                </select>
      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <textarea form="concernTenantForm" name="remarks" placeholder="Remarks..." cols="40" rows="5" class="form-control" required></textarea>
              </div>
                    </div>

                   

                    <div class="form-row">
                      <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}#concerns" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Cancel</a>
                      <button form="concernTenantForm" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Submit</button>
                    </div>
                
            </div>
        </div>
    </div>
</section>


@endsection



@section('scripts')
<script type="text/javascript">
  //adding moveout charges upon moveout
    $(document).ready(function(){
        var i=0;
    $("#add_material").click(function(){
        $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='requestMoveoutForm' name='particular"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='requestMoveoutForm'    oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm' name='amount"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
     $('#table_materials').append('<tr id="addr'+(i+1)+'"></tr>');
     i++;
     document.getElementById('no_of_materials').value = i;
    });
    $("#remove_material").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        document.getElementById('no_of_materials').value = i;
        }
    });
});
</script>
@endsection



