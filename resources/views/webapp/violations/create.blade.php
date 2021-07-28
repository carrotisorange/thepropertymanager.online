@extends('layouts.argon.main')

@section('title', 'Tenant Violation Form')

@section('css')

@endsection

@section('upper-content')
{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!------ Include the above in your HEAD tag ---------->

<section class="testimonial py-3" id="testimonial">
    <div class="container">
        <h2 class="pb-2 text-center">Tenant violation form</h2>
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
            <div class="col-md-12 py-3 border">
              <form id="violationTenantForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/violation/store" method="POST">
                @csrf
              </form>
                
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <input form="violationTenantForm" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" type="date" required>
                    </div>

                    <div class="form-group col-md-4">
                        <select form="violationTenantForm" class="form-control" name="tenant_id" id="" required>
                          <option value="{{ $tenant->tenant_id }}">{{ $tenant->first_name.' '.$tenant->last_name }}</option>
                        </select>
                       
                      </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <textarea form="violationTenantForm" name="summary" placeholder="Details of the violation" cols="40" rows="5" class="form-control" required></textarea>
            </div>
                   </div>
                   
                    <div class="form-row">
                     
                        <div class="form-group col-md-4">
                                  
                                  <select form="violationTenantForm" name="frequency" class="form-control" required>
                                    <option value="" selected>Frequency...</option>
                                    <option value="warning">Warning</option>
                                    <option value="1st_offence" >1st offence</option>
                                    <option value="2nd_offence">2nd offence</option>
                                    <option value="3rd_offence">3rd offence</option>
                                    <option value="nth_offence">Nth offence</option>
                                  </select>
                        </div>
                        <div class="form-group col-md-4">
                                  
                          <select form="violationTenantForm" name="severity" class="form-control" required>
                            <option value="" selected>Severity...</option>
                            <option value="major"> Major Concern</option>
                            <option value="minor"> Minor Concern</option>
                        
                          </select>
                </div>

                <div class="form-group col-md-4">
                                  
                  <select form="violationTenantForm" name="status" class="form-control" required>
                    <option value="" selected>Status...</option>
                    <option value="pending"> pending</option>
                    <option value="resolved"> resolved</option>
                    <option value="cancelled"> cancelled</option>
                  </select>
        </div>
                     
                    </div>              

                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <textarea form="violationTenantForm" name="sanction" placeholder="Sanction..." cols="40" rows="5" class="form-control" required></textarea>
              </div>
                    </div>

             

                    <div class="form-row">
                      <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}#violations" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Cancel</a>
                      <button form="violationTenantForm" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Submit</button>
                    </div>
                
            </div>
        </div>
    </div>
</section>


@endsection



@section('scripts')

@endsection



