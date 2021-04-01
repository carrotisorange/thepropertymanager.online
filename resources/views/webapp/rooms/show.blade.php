@extends('layouts.argon.main')

@section('title', $home->building.' '.$home->unit_no)

@section('upper-content')
{{-- <div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/rooms/">{{ Session::get('property_name') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $home->building.' '.$home->unit_no }}</li>
      </ol>
    </nav>
    
    
  </div>
</div> --}}
<br>
  <div class="row">
    <div class="col-md-12">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="nav-room" aria-selected="true"><i class="fas fa-home text-indigo"></i> Room</a>
          @if($tenants->count()<=0)
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users text-green"></i> Tenants <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-tenant-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users text-green"></i> Tenants <span class="badge badge-success badge-counter">{{ $tenants->count() }}</span></a>
          @endif
         
          @if($owners->count()<=0)
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie text-teal"></i> Owners <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-owners-tab" data-toggle="tab" href="#owners" role="tab" aria-controls="nav-owners" aria-selected="false"><i class="fas fa-user-tie text-teal"></i> Owners <span class="badge badge-success badge-counter">{{ $owners->count() }}</span></a>
          @endif

          @if($remittances->count()<=0)
          <a class="nav-item nav-link" id="nav-remittances-tab" data-toggle="tab" href="#remittances" role="tab" aria-controls="nav-remittances" aria-selected="false"><i class="fas fa-hand-holding-usd text-teal"></i> Remittances <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-remittances-tab" data-toggle="tab" href="#remittances" role="tab" aria-controls="nav-remittances" aria-selected="false"><i class="fas fa-hand-holding-usd text-teal"></i> Remittances <span class="badge badge-success badge-counter">{{ $remittances->count() }}</span></a>
          @endif

          @if($expenses->count()<=0)
          <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="nav-expenses" aria-selected="false"><i class="fas fa-file-export text-danger"></i> Expenses <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="nav-expenses" aria-selected="false"><i class="fas fa-file-export text-danger"></i> Expenses <span class="badge badge-success badge-counter">{{ $expenses->count() }}</span></a>
          @endif

          @if($concerns->count()<=0)
          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-cyan"></i> Concerns <i class="fas fa-exclamation-triangle text-danger"></i></a>
          @else
          <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-cyan"></i> Concerns <span class="badge badge-success badge-counter">{{ $concerns->count() }}</span></a>
          @endif
        </div>
      </nav>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content" id="nav-tabContent">
     
        <div class="tab-pane fade show active" id="room" role="tabpanel" aria-labelledby="nav-room-tab">
    
          <p class="text-left">
            <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUnit" data-whatever="@mdo"><i class="fas fa-edit"></i> Edit room</button> 
            {{-- <button type="button" title="edit room" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadImages" data-whatever="@mdo"><i class="fas fa-upload"></i> Upload Image</button>  --}}
          </p>
          <div class="row">
          <div class="col-md-6">
            <div class="card">
              {{-- <div class="card-header">
                Room Information
              </div> --}}
              <div class="card-body">
                
                <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
                <div class="table-responsive text-left">
              <table class="table  table-condensed table-bordered table-hover">
                 <thead>
                  <tr>
                    <th>Room</th>
                    <td>{{ $home->unit_no }}</td>
               </tr>
               <tr>
                <th>Size</th>
                <td>{{ $home->size }} <b>sqm</b></td>
           </tr>
                 </thead>
                  <thead>
                    <tr>
                      <th>Building</th>
                      <td>{{ $home->building }}</td>
                 </tr>
                  </thead>
                   <thead>
                    <tr>
                      <th>Floor</th>
               
                      <td>
                        @if($home->floor <= 0)
                        {{ $numberFormatter->format($home->floor * -1) }} basement
                        @else
                        {{ $numberFormatter->format($home->floor) }} floor
                        @endif
                        
                      </td>
                 </tr>
                   </thead>
                  <thead>
                    <tr>
                      <th>Type</th>
                      <td>{{ $home->type }}</td>
                 </tr>
                  </thead>
                  <thead>
                    <tr>
                      <th>Occupancy</th>
                      <td>{{ $home->occupancy? $home->occupancy: 0 }} <b>pax</b></td>
                    </tr>
                  </thead>
                 <thead>
                  <tr>
                    <th>Status</th>
                    <td>{{ $home->status }}</td>
                </tr>
                 </thead>
                   <thead>
                    <tr>
                      <th>Rent</th> 
                      <td>{{ number_format($home->rent,2) }}/month</td>
                  </tr>
                   </thead>
                   <thead>
                    <tr>
                      <th>Enrollment Date</th> 
                      <td>{{ Carbon\Carbon::parse($home->created_at)->format('M d, Y') }} </td>
                  </tr>
                   </thead>
                
               </table>
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>
       
        </div>
        <div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="nav-expenses-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            @if($expenses->count() <=0)
            <br>
            <p class="text-danger text-center">No expenses found!</p>
            @else
            <p>Total expenses deducted to remittance: {{ number_format($expenses->sum('expense_amt'), 2) }}</p>
            <table class="table table-condensed table-bordered table-hover">
              <thead>
                  <?php $ctr=1;?>
                  <tr>
                      <th>#</th>
                      <th>Date deducted</th>
                      {{-- <th>Period Covered</th> --}}
                      <th>Particular</th>
                      <th>Amount</th>
                  </tr>    
              </thead>
              <tbody>
                  @foreach ($expenses as $item)
                  <tr>
                      <th>{{ $ctr++ }}</th>     
                      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                      {{-- <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td> --}}
                      <td>{{ $item->expense_particular }}</td>
                      <th>{{ number_format($item->expense_amt,2) }}</th>
                     
                  </tr>   
                  @endforeach
                
              </tbody>
          </table>
          @endif
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="remittances" role="tabpanel" aria-labelledby="nav-remittances-tab">
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            @if($remittances->count() <=0)
            <br>
            <p class="text-danger text-center">No remittances found!</p>
            @else
            <p>Total remittances remitted: {{ number_format($remittances->sum('amt_remitted'), 2) }}</p>
            <table class="table  table-condensed table-bordered table-hover">
              <thead>
                  <?php $ctr=1;?>
                  <tr>
                      <th>#</th>
                      <th>Date Prepared</th>
                      <th>Period Covered</th>
                      <th>Particular</th>
                      <th>CV</th>
                      <th>Check #</th>
                   
                      <th>Status</th>
                      <th>Amount</th>
          
                  </tr>    
              </thead>
              <tbody>
                  @foreach ($remittances as $item)
                  <tr>
                      <th>{{ $ctr++ }}</th>     
                      <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                      
                      <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td>
                      <td>{{ $item->particular }}</td>
                      <td>{{ $item->cv_number }}</td>
                      <td>{{ $item->check_number }}</td>
                      
                     <td>
                      @if($item->remitted_at === NULL)
                      <span class="badge badge-danger">pending</span>
                      @else
                      <span class="badge badge-success">remitted</span>
                      @endif
                     </td>
                      <th><a href="/property/{{ Session::get('property_id') }}/remittance/{{ $item->remittance_id }}/expenses">{{ number_format($item->amt_remitted,2) }}</a></th>
                  </tr>   
                  @endforeach
              </tbody>
          </table>
          @endif
           
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="tenants" role="tabpanel" aria-labelledby="nav-tenants-tab">
          <div class="col-md-12 mx-auto">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" data-toggle="tab" href="#addtenant" role="tab" aria-controls="nav-add-tenant" aria-selected="true"><i class="fas fa-user-plus"></i> Add </a>
             @if($tenant_active->count()<=0)
             <a class="nav-item nav-link" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="false"><i class="fas fa-user-check text-primary"></i> Active</a>
             @else
             <a class="nav-item nav-link" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="false"><i class="fas fa-user-check text-primary"></i> Active  <span class="badge badge-success">{{ $tenant_active->count() }}</span></a>
             @endif

             @if ($tenant_reserved->count() <=0)
             <a class="nav-item nav-link"  data-toggle="tab" href="#reserved" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-user-clock text-warning"></i> Reserved</a>   
             @else
             <a class="nav-item nav-link"  data-toggle="tab" href="#reserved" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-user-clock text-warning"></i> Reserved <span class="badge badge-success">{{ $tenant_reserved->count() }}</a>  
             @endif
             
            @if ($tenant_movingout->count()<=0)
            <a class="nav-item nav-link"  data-toggle="tab" href="#movingout" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-sign-out-alt text-success"></i> Moving Out</a>   
            @else
            <a class="nav-item nav-link"  data-toggle="tab" href="#movingout" role="tab" aria-controls="nav-tenant" aria-selected="false"><i class="fas fa-sign-out-alt text-success"></i> Moving Out <span class="badge badge-success">{{ $tenant_movingout->count() }}</a>
            @endif
            
            @if ($tenant_inactive->count()<=0)
            <a class="nav-item nav-link"  data-toggle="tab" href="#inactive" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-user-times text-danger"></i> Inactive</a>    
            @else
            <a class="nav-item nav-link"  data-toggle="tab" href="#inactive" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-user-times text-danger"></i> Inactive <span class="badge badge-success">{{ $tenant_inactive->count() }}</span></a>    
            @endif
              </div>
          </nav>
          <br>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="addtenant" role="tabpanel" aria-labelledby="nav-addtenant-tab">
             <div class="row">
              <div class="col-md-12">
                <div class="card card-body">
                
                    <h1 class="text-center">Tenant Information Sheet</h1>
                    <form id="addTenantForm1" action="/property/{{Session::get('property_id')}}/room/{{ $home->unit_id }}/tenant/" method="POST">
                      {{ csrf_field() }}
                      </form>
                      <table class="table table-condensed">
                        <tr>
                      <th style="text-align: center;" colspan="2"></th>
                          <th style="text-align: center;">Unit No: {{ $home->building.' '.$home->unit_no }}</th>
                          <th style="text-align: center;">Beds: {{ $home->occupancy? $home->occupancy: 0 }} <b>pax</b> </th>
                          
                        </tr>
            
                      </table>
                      <br>
                    <table class="table table-condensed">
        
                      <tr>
                        <th style="text-align: left;">
                          Last name:
                          <input form="addTenantForm1" type="text" class="@error('last_name') is-invalid @enderror" name="last_name" id="last_name"  value="{{ old('last_name') }}" required>
                          @error('last_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </th>
                        <th style="text-align: left;"> First name:
                          <input form="addTenantForm1" type="text" class="@error('first_name') is-invalid @enderror" name="first_name" id="first_name"  value="{{ old('first_name') }}" required>
                             @error('first_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </th>
                        <th style="text-align: left;">
                         Middle name:
                            <input form="addTenantForm1" type="text" class="@error('middle_name') is-invalid @enderror" name="middle_name" id="middle_name"  value="{{ old('middle_name') }}">
                            @error('middle_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                      </th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">
                          Birthdate:
                          <input form="addTenantForm1" type="date" class="@error('birthdate') is-invalid @enderror" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
    
                          @error('birthdate')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </th>
                        {{-- <th>
                          Age:
                          <input form="addTenantForm1" type="number" name="age" id="age" value="" readonly>
    
                        </th> --}}
                        <th style="text-align: left;">
                          Gender:
                          <select form="addTenantForm1"  id="gender" name="gender" required>        
                            <option value="{{ old('gender')? old('gender'): '' }}" selected>{{ old('gender')? old('gender'): 'Please select one' }} </option>
                            <option value="male">male</option>
                            <option value="female">female</option>
                        </select>
                
                        @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </th>
                        <th style="text-align: left;">
                          Civil status:
                          <select form="addTenantForm1"  id="civil_status" name="civil_status" required>
                            <option value="{{ old('civil_status')? old('civil_status'): '' }}" selected>{{ old('civil_status')? old('civil_status'): 'Please select one' }} </option>
                              <option value="single">single</option>
                              <option value="married">married</option>
                          </select>
                
                          @error('civil_status')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </th>
                      </tr>
                      <tr>
                       <th style="text-align: left;">
                        Nationality:
                        <input form="addTenantForm1" type="text" class="@error('nationality') is-invalid @enderror" name="nationality" id="nationality"  value="{{ old('nationality') }}" required>
                        @error('nationality')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                       </th>
                       <th style="text-align: left;">
                        Ethnicity:
                        <input form="addTenantForm1" type="text" class="@error('ethnicity') is-invalid @enderror" name="ethnicity" id="ethnicity"  value="{{ old('ethnicity') }}">
                        @error('ethnicity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                       </th>
                     <th style="text-align: left;">
                      ID presented/ID number:
                      <input form="addTenantForm1" type="text" class="@error('id_number') is-invalid @enderror" name="id_number" id="id_number" value="{{ old('id_number') }}" required>

                      @error('id_number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                     </th>
                      </tr>
                      <tr>
                        <th colspan="4" style="text-align: left;">
                          Provincial address:
                          <input form="addTenantForm1" type="text" class="@error('provincial_address') is-invalid @enderror" name="provincial_address" id="provincial_address" value="{{ old('provincial_address') }}" style="width: 800px;" required>
    
                          @error('provincial_address')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                         </th>
                      </tr>
                      <tr>
                        <th style="text-align: left;" colspan="2">
                          Contact number:
                          <input form="addTenantForm1" type="number" class="@error('contact_no') is-invalid @enderror" name="contact_no" id="contact_no"  value="{{ old('contact_no') }}">
                    
                          @error('contact_no')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </th>
                        <th style="text-align: left;">
                          Email address:
                          <input form="addTenantForm1" type="email" class="@error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                          <br>
                          @error('email')
                          
                          <strong class="text-danger">{{ $message }}</strong>
                    
                         @enderror
                        </th>
                        <th>
                          
                        </th>
                      </tr>
                     
                    </table>
                    
                    {{-- <br>
                    <small>In case of emergency </small>
                    <table class="table table-condensed">
                      <tr>
                        <th>Name: <input form="addTenantForm1" type="text" class="@error('guardian_name') is-invalid @enderror" name="guardian_name_1" id="guardian_name_1"  value="{{ old('guardian_name') }}" required></th>
                        <th>Relationship: <input form="addTenantForm1" type="text" class="@error('guardian_relationship') is-invalid @enderror" name="guardian_relationship_1" id="guardian_relationship_1"  value="{{ old('guardian_relationship') }}" required></th>
                        <th>Contact number:  <input form="addTenantForm1" type="text" class="@error('guardian_contact') is-invalid @enderror" name="guardian_contact_1" id="guardian_contact_1"  value="{{ old('guardian_contact') }}" required></th>
                      </tr>
                      <tr>
                        <th>Name: <input form="addTenantForm1" type="text" class="@error('guardian_name') is-invalid @enderror" name="guardian_name_2" id="guardian_name_2"  value="{{ old('guardian_name') }}"></th>
                        <th>Relationship: <input form="addTenantForm1" type="text" class="@error('guardian_relationship') is-invalid @enderror" name="guardian_relationship_2" id="guardian_relationship_2"  value="{{ old('guardian_relationship') }}"></th>
                        <th>Contact number:  <input form="addTenantForm1" type="text" class="@error('guardian_contact') is-invalid @enderror" name="guardian_contact_2" id="guardian_contact_2"  value="{{ old('guardian_contact') }}"></th>
                      </tr>
                      <tr>
                        <th>Name: <input form="addTenantForm1" type="text" class="@error('guardian_name') is-invalid @enderror" name="guardian_name_3" id="guardian_name_3"  value="{{ old('guardian_name') }}"></th>
                        <th>Relationship: <input form="addTenantForm1" type="text" class="@error('guardian_relationship') is-invalid @enderror" name="guardian_relationship_3" id="guardian_relationship_3"  value="{{ old('guardian_relationship') }}"></th>
                        <th>Contact number:  <input form="addTenantForm1" type="text" class="@error('guardian_contact') is-invalid @enderror" name="guardian_contact_3" id="guardian_contact_3"  value="{{ old('guardian_contact') }}"></th>
                      </tr>
                    </table> --}}
                    <br>
                    <table class="table table-condensed">
                      <tr>
                        <th style="text-align: left;">Studying <input form="addTenantForm1" form="filter" type="radio" name="type_of_tenant" value="studying" id="exampleCheck1"></th>
                        <th style="text-align: left;">Working <input form="addTenantForm1" form="filter" type="radio" name="type_of_tenant" value="working" id="exampleCheck1"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">High school: <input form="addTenantForm1" type="text" class="@error('high_school') is-invalid @enderror" name="high_school" id="high_school"  value="{{ old('high_school') }}"></th>
                        <th style="text-align: left;">Employer's name/business: <input form="addTenantForm1" type="text" class="@error('employer') is-invalid @enderror" name="employer" id="employer"  value="{{ old('employer') }}"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">High school address: <input form="addTenantForm1" type="text" class="@error('high_school_address') is-invalid @enderror" name="high_school_address" id="high_school_address"  value="{{ old('high_school_address') }}"></th>
                        <th style="text-align: left;">Employer address: <input form="addTenantForm1" type="text" class="@error('employer_address') is-invalid @enderror" name="employer_address" id="employer_address"  value="{{ old('employer_address') }}"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">College/Universtity: <input form="addTenantForm1" type="text" class="@error('college_school') is-invalid @enderror" name="college_school" id="college_school"  value="{{ old('college_school') }}"></th>
                        <th style="text-align: left;">Position: <input form="addTenantForm1" type="text" class="@error('job') is-invalid @enderror" name="job" id="job"  value="{{ old('job') }}"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">School address: <input form="addTenantForm1" type="text" class="@error('college_school_address') is-invalid @enderror" name="college_school_address" id="college_school_address"  value="{{ old('college_school_address') }}"></th>
                        <th style="text-align: left;">Years of employment: <input form="addTenantForm1" type="text" class="@error('years_of_employment') is-invalid @enderror" name="years_of_employment" id="years_of_employment"  value="{{ old('years_of_employment') }}"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">Course: <input form="addTenantForm1" type="text" class="@error('course') is-invalid @enderror" name="course" id="course"  value="{{ old('course') }}"></th>
                        <th style="text-align: left;">Contact number: <input form="addTenantForm1" type="text" class="@error('employer_contact_no') is-invalid @enderror" name="employer_contact_no" id="employer_contact_no"  value="{{ old('employer_contact_no`') }}"></th>
                      </tr>
                      <tr>
                        <th style="text-align: left;">Year level: <input form="addTenantForm1" type="text" class="@error('year_level') is-invalid @enderror" name="year_level" id="year_level"  value="{{ old('year_level') }}"></th>
                        <th style="text-align: left;">Telephone: <input form="addTenantForm1" type="text" class="@error('business_telephone') is-invalid @enderror" name="business_telephone" id="business_telephone"  value="{{ old('business_telephone`') }}"></th>
                      </tr>
                    </table>
                    <br>
                    <small>Source of awareness</small>
                    <table class="table table-condensed">
                      <tr>
                        <th style="text-align: left;">Referrer:
                          <select form="addTenantForm1" name="referrer_id" id="referrer_id">
                            <option value="">Please select one</option>
                            @foreach ($users as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                           </select>
                        </th>
                        <th style="text-align: left;">Source:
                          <select form="addTenantForm1" name="form_of_interaction" id="form_of_interaction" required>
                            <option value="{{ old('form_of_interaction')? old('form_of_interaction'): '' }}" selected>{{ old('form_of_interaction')? old('form_of_interaction'): 'Please select one' }} </option>
                             <option value="Facebook">Facebook</option>
                             <option value="Flyers">Flyers</option>
                             <option value="In house">In house</option>
                             <option value="Instagram">Instagram</option>
                             <option value="Website">Website</option>
                             <option value="Walk in">Walk in</option>
                             <option value="Word of mouth">Word of mouth</option>
                          </select>
                        </th>
                      </tr>
                    </table>
                   <br>
                    <p class="text-right">
                      <button type="submit" form="addTenantForm1" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
                    </p>

           
                </div>
              </div>
             </div>
            </div>
            <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="table-responsive text-nowrap">
              <table class="table  table-condensed table-bordered table-hover">
                @if($tenant_active->count() <= 0)
                <tr>
                    <br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Movein</th>   
                    <th>Moveout</th>
                    <th>Term</th>
                    <th>Rent</th>
                    <th>Source</th>
                </tr>
              </thead>
                <?php $ctr = 1; ?>   
            @foreach ($tenant_active as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
                    <td>{{ $item->contract_term }}</td>
                    {{-- <td title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->moveout_date), false) }} days left">{{ Carbon\Carbon::parse($item->movein_at)->format('M d Y').'-'.Carbon\Carbon::parse($item->moveout_date)->format('M d Y') }}</> --}}
                      <td>{{ number_format($item->contract_rent, 2) }}</td>
                      <td>{{ $item->form_of_interaction }}</td>
                    </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="reserved" role="tabpanel" aria-labelledby="nav-tenant-tab">
              <div class="table-responsive text-nowrap">
              <table class="table  table-condensed table-bordered table-hover">
                @if($tenant_reserved->count() <= 0)
                <tr>
                    <br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Reserved Via</th>
                    <th>Source</th>
                    <th>Reserved</th>
                    <th>Days before for forfeiture</th>   
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_reserved as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    @if($item->type_of_tenant === 'online')
                    <td><a class="badge badge-success">{{ $item->type_of_tenant }}</td>
                    @else
                    <td><a class="badge badge-warning">{{ $item->type_of_tenant }}</td>
                    @endif
                    <td>{{ $item->form_of_interaction }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    <td>{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($item->created_at)->addDays(7), false) }}</td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="movingout" role="tabpanel" aria-labelledby="nav-tenant-tab">
              <div class="table-responsive text-nowrap">
              <table class="table  table-condensed table-bordered table-hover">
                @if($tenant_movingout->count() <= 0)
                <tr>
                    <br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Moveout</th>
                     
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_movingout as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    <td>{{Carbon\Carbon::parse($item->moveout_at)->format('M d Y')}} <span class="text-danger">({{ Carbon\Carbon::parse($item->moveout_at)->diffForHumans() }})</span></td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
            <div class="tab-pane fade" id="inactive" role="tabpanel" aria-labelledby="nav-contact-tab">
              <div class="table-responsive text-nowrap">
              <table class="table  table-condensed table-bordered table-hover">
                @if($tenant_inactive->count() <= 0)
                <tr>
                    <br><br>
                    <p class="text-center text-danger">No tenants found!</p>
                </tr>
                @else
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    
                    <th>Inactive since</th>   
                    <th>Reason for moving out</th>
                    <th></th>
                </tr>
                </thead>
                <?php
                    $ctr = 1;
                ?>   
            @foreach ($tenant_inactive as $item)
                <tr>
                    <th class="text-center">{{ $ctr++ }}</th>
                    <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} </a></th>
                    
                    <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d Y') }}</td>
                    <td>{{ $item->moveout_reason }}</td>
                </tr>
            @endforeach
                @endif                        
            </table>
              </div>
            </div>
          </div>
        </div>
        </div>
  
        <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">
          <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus"></i> Add Concern</a>  
          <br><br>
          <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            @if($concerns->count() <=0)
            <br>
            <p class="text-danger text-center">No concerns found!</p>
            @else
            <table class="table  table-condensed table-bordered table-hover" >
            <thead>
            <tr>
              <?php $ctr=1; ?>
               <th>#</th>
               
                 <th>Date Reported</th>
                
               
    
                 <th>Title</th>
                 <th>Urgency</th>
                 <th>Status</th>
                 <th>Assigned to</th>
                 <th>Rating</th>
                 <th>Feedback</th>
            </tr>
            </thead>
            <tbody>
             @foreach ($concerns as $item)
             <tr>
              <th>{{ $ctr++ }}</th>
           
              <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                
  
               
                <th><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></th>
                <td>
                    @if($item->urgency === 'urgent')
                    <span class="badge badge-danger">{{ $item->urgency }}</span>
                    @elseif($item->urgency === 'major')
                    <span class="badge badge-warning">{{ $item->urgency }}</span>
                    @else
                    <span class="badge badge-primary">{{ $item->urgency }}</span>
                    @endif
                </td>
                <td>
                  @if($item->concern_status === 'pending')
                  <i class="fas fa-clock text-warning"></i> {{ $item->concern_status }}
                  @elseif($item->concern_status === 'active')
                  <i class="fas fa-snowboarding text-primary"></i> {{ $item->concern_status }}
                  @else
                  <i class="fas fa-check-circle text-success"></i> {{ $item->concern_status }}
                  @endif
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
                <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td>
            </tr>
             @endforeach
            </tbody>
            </table>
            @endif
  
            </div>
        </div>
        </div>
        
        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="nav-owners-tab">
        
     <a  data-toggle="modal" data-target="#addInvestor" data-whatever="@mdo" type="button" class="btn btn-primary text-white btn-sm">
      <i class="fas fa-user-plus text-white"></i> Add Owner
    </a>   
  <br>
     <br>
        <div class="col-md-12 mx-auto">
          @if($owners->count()<=-0)
          <p class="text-center text-danger">No owners found!</p>
          @else
          <div class="table-responsive text-nowrap">
            <table class="table  table-condensed table-bordered table-hover">
              <?php $ctr=1;?>
              <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Representative</th>
              
                  </tr>
                </thead>
                  @foreach ($owners as $item)
                  <tr>
                    <th>{{ $ctr++ }}</th>
                     <th><a href="/property/{{Session::get('property_id')}}/owner/{{ $item->owner_id }}">{{ $item->name }} </a></thf>
              
                    <td>{{ $item-> email}}</td>
                    <td>{{ $item->mobile }}</td>
                    <td>{{ $item->representative }}</td>
                    
                  </tr>
                  @endforeach
                
            </table>
    
           
          </div>
          @endif
         
        </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Room Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="editUnitForm" action="/property/{{ Session::get('property_id') }}/room/{{ $home->unit_id}}/update" method="POST">
            @method('put')
            @csrf
        </form>
        <div class="modal-body">
            <div class="form-group">
            <label>Room</label>
            <input form="editUnitForm" type="text" value="{{ $home->unit_no }}" name="unit_no" class="form-control" id="unit_no" >
            </div>
            <div class="form-group">
              <label>Size <small>(sqm)</small></label>
              <input form="editUnitForm" type="text" value="{{ $home->size }}" name="size" class="form-control" id="size" >
              </div>
            
            <div class="form-group">
            <label>Floor</label>
            <select form="editUnitForm" id="floor" name="floor" class="form-control">
                <option value="{{ $home->floor }}" readonly selected class="bg-primary">{{ $home->floor }}</option>
                <option value="-5">5th basement</option>
                <option value="-4">4th basement</option>
                <option value="-3">3rd basement</option>
                <option value="-2">2nd basement</option>
                <option value="-1">1st basement</option>
                
                <option value="1">1st floor</option>
                <option value="2">2nd floor</option>
                <option value="3">3rd floor</option>
                <option value="4">4th floor</option>
                <option value="5">5th floor</option>
                <option value="6">6th floor</option>
                <option value="7">7th floor</option>
                <option value="8">8th floor</option>
                <option value="9">9th floor</option>
            </select>
            </div>
            <div class="form-group">
                <label>Building <small>(Optional)</small></label>
                <input form="editUnitForm" type="text" value="{{ $home->building }}" name="building" class="form-control"> 
              </div>
            <div class="form-group">
            <label>Type</label>
            <select form="editUnitForm" id="type" name="type" class="form-control">
                <option value="{{ $home->type }}" readonly selected class="bg-primary">{{ $home->type }}</option>
                <option value="commercial">commercial</option>
                <option value="residential">residential</option>
            </select>
            </div>
            <input  form="editUnitForm"  type="hidden" name="property_id" value="{{Session::get('property_id')}}">
            <div class="form-group">
              <label>Occupancy <small>(Numner of tenants allowed)</small></label>
              <input  oninput="this.value = Math.abs(this.value)" form="editUnitForm" type="number" value="{{ $home->occupancy? $home->occupancy: 0 }}" name="occupancy" class="form-control"> 
            </div>
            <div class="form-group">
            <label>Status</label>
            <select form="editUnitForm" id="status" name="status" class="form-control">
                <option value="{{ $home->status }}" readonly selected class="bg-primary">{{ $home->status }}</option>
                <option value="dirty">dirty</option>
                <option value="occupied">occupied</option>
                <option value="reserved">reserved</option>
                <option value="vacant">vacant</option>
            </select>
            </div>
            <div class="form-group">
                <label>Rent <small>(/month)</small></label>
                <input form="editUnitForm"  oninput="this.value = Math.abs(this.value)" step="0.01" type="number" value="{{ $home->rent? $home->rent: 0 }}" name="rent" class="form-control">
                </div>
            <div class="form-group">
                <label>Enrollment Date</label>
                <input form="editUnitForm" type="date" value="{{ Carbon\Carbon::parse($home->created_at)->format('Y-m-d') }}" name="created_at" class="form-control">
            </div>
      
        </div>
        <div class="modal-footer">
        <button type="submit" form="editUnitForm" class="btn btn-primary" this.disabled = true;> Update</button>  
        </div>
    </div>
    </div>
  </div>

                     {{-- Modal for renewing tenant --}}
                     <div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
                      <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Concern Information</h5>
                  
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                          <div class="modal-body">
                              <form id="concernForm" action="/property/{{Session::get('property_id')}}/home/{{ $home->unit_id }}/concern" method="POST">
                                  @csrf
                              </form>
    
                              <div class="row">
                                <div class="col">
                                    <label>Date Reported</label>
                                    <input type="date" form="concernForm" class="form-control" name="reported_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
                                </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col">
                                  <label>Title</label>
                                
                                  <input type="text" form="concernForm" class="form-control" name="title" required >
                              </div>
                            </div>  
                            <br>
                            
                            <div class="row">
                              <div class="col">
                                  <label>Reported By</label>
                                  <select class="form-control" form="concernForm" name="reported_by" id="" required>
                                    <option value="">Please select one</option>
                                    @foreach ($reported_by as $item)
                                    <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} (tenant)</option>
                                    @endforeach
                                   
                                  </select>
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
                                        <option value="{{ $item->id }}"> {{ $item->user_type }}</option>
                                    @endforeach   
                                  </select>
                              </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            
                              <button type="submit" form="concernForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add Concern</button>
                          </div>
                      </div>
                      </div>
                  </div>

                  <div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form  method="POST" id="uploadImagesForm" action="/property/{{Session::get('property_id')}}/room/{{ $home->unit_id }}/upload" enctype="multipart/form-data">
                            @csrf
                        </form>
                        <div class="modal-body">
                          <input form="uploadImagesForm" class="form-control" type="file" name="file[]" accept="image/*" multiple required/>
                          <br><br>
                          <div class="progress">
                            <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                0%
                            </div>
                          </div>
                          <br><br>
                          <div id="success" class="row">

                          </div>

                        </div>
                        <div class="modal-footer">
                        <button type="submit" form="uploadImagesForm" class="btn btn-primary" this.disabled = true;> Upload</button>  
                        </div>
                    </div>
                    </div>
                  </div>
  @include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')
  @include('webapp.tenants.show_includes.owners.create')
@endsection



@section('scripts')


   
@endsection



