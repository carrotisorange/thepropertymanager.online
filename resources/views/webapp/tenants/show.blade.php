@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('css')
<style>
  /*This will work on every browser*/
  thead tr:nth-child(1) th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 10;
  }
</style>
@endsection

@section('upper-content')
<?php   $diffInDays =  number_format(Carbon\Carbon::now()->DiffInDays(Carbon\Carbon::parse($tenant->moveout_date), false)) ?>
{{-- <div class="row align-items-center py-4">
  
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">
      {{ $tenant->first_name.' '.$tenant->last_name }}


@if($tenant->type_of_tenant === 'studying')

<span class="text-primary"><i class="fas fa-user-circle"></i> {{ $tenant->type_of_tenant }}</span>
@else
<span class="text-warning"><i class="fas fa-user-tie"></i> {{ $tenant->type_of_tenant }}</span>
@endif
</h6>
</div>

</div> --}}
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">
      {{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}</h6>
  </div>
</div>
<div class="row">
  <div class="col">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissable custom-danger-box">

      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      @foreach ($errors->all() as $error)
      <strong><i class="fas fa-exclamation-triangle"></i> {{ $error }}</strong>
      @endforeach

    </div>
    @endif
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @if($tenant->contact_no === null)
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab"
          aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user text-green"></i> Profile <i
            class="fas fa-exclamation-triangle text-danger"></i></a>
        @else
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab"
          aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user text-green"></i> Profile</a>
        @endif

        @if($access->count() <=0 ) <a class="nav-item nav-link" id="nav-credentials-tab" data-toggle="tab"
          href="#credentials" role="tab" aria-controls="nav-credentials" aria-selected="true"><i
            class="fas fa-key text-dark"></i> Credentials <i class="fas fa-exclamation-triangle text-danger"></i> </a>
          @else
          <a class="nav-item nav-link" id="nav-credentials-tab" data-toggle="tab" href="#credentials" role="tab"
            aria-controls="nav-credentials" aria-selected="true"><i class="fas fa-key text-dark"></i> Credentials </a>
          @endif

          {{-- @if($contracts->count() <= 0)
        <a class="nav-item nav-link" id="nav-contracts-tab" data-toggle="tab" href="#contracts" role="tab" aria-controls="nav-contracts" aria-selected="false"><i class="fas fa-file-signature"></i> Contracts <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i></span></a>
         @else --}}
          <a class="nav-item nav-link" id="nav-contracts-tab" data-toggle="tab" href="#contracts" role="tab"
            aria-controls="nav-contracts" aria-selected="false"><i class="fas fa-file-signature text-indigo"></i>
            Contracts</a>
          {{-- @endif  --}}

          @if($guardians->count() <=0 ) <a class="nav-item nav-link" id="nav-guardians-tab" data-toggle="tab"
            href="#guardians" role="tab" aria-controls="nav-guardians" aria-selected="false"><i
              class="fas fa-user-friends text-primary"></i> Guardians <i
              class="fas fa-exclamation-triangle text-danger"></i></a>
            @else
            <a class="nav-item nav-link" id="nav-guardians-tab" data-toggle="tab" href="#guardians" role="tab"
              aria-controls="nav-guardians" aria-selected="false"><i class="fas fa-user-friends text-primary"></i>
              Guardians </a>
            @endif
            @if($bills->count() <= 0) <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills"
              role="tab" aria-controls="nav-bills" aria-selected="false"><i
                class="fas fa-file-invoice-dollar text-pink"></i> Bills </a>
              @else
              <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab"
                aria-controls="nav-bills" aria-selected="false"><i class="fas fa-file-invoice-dollar text-pink"></i>
                Bills <i class="fas fa-exclamation-triangle text-danger"></i> {{ $bills->count() }}</a>
              @endif
              <a class="nav-item nav-link" id="nav-payments-tab" data-toggle="tab" href="#payments" role="tab"
                aria-controls="nav-payments" aria-selected="false"><i class="fas fa-coins text-yellow"></i> Payments
              </a>
              {{-- <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab"
                aria-controls="nav-concern" aria-selected="false"><i class="fas fa-tools text-cyan"></i> Concerns</a> --}}
              @if($violations->count() <= 0) <a class="nav-item nav-link" id="nav-violations-tab" data-toggle="tab"
                href="#violations" role="tab" aria-controls="nav-violation" aria-selected="false"> <i
                  class="fas fa-smoking-ban text-primary"></i> Violations</a>
                @else
                <a class="nav-item nav-link" id="nav-violations-tab" data-toggle="tab" href="#violations" role="tab"
                  aria-controls="nav-violation" aria-selected="false"> <i class="fas fa-smoking-ban text-primary"></i>
                  Violations <i class="fas fa-exclamation-triangle text-danger"></i> {{ $violations->count() }}</a>
                @endif

      </div>
    </nav>

  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">

        <div class="row">
          <div class="col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-primary"><i
              class="fas fa-arrow-left"></i> Back</a>

            {{-- <a href="/asa/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}" class="btn
            btn-primary"><i class="fas fa-user"></i> Change property </a> --}}


            @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
            <a href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/edit"
              class="btn btn-primary"><i class="fas fa-user-edit"></i> Edit</a>
            @endif

            <br><br>
            @if($tenant->contact_no === null)
            <small class="text-danger">Email address or mobile is missing!</small>
            @endif
            <div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Tenant ID</th>
                    <td>{{ $tenant->tenant_unique_id }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Name</th>
                    <td>{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }} </td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Type of tenant</th>
                    <td>
                      {{ $tenant->type_of_tenant }}
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Mobile</th>
                    <td>{{ $tenant->contact_no }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Email</th>
                    <td>{{ $tenant->email }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Gender</th>
                    <td>{{ $tenant->gender }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Birthdate</th>
                    <td>{{ Carbon\Carbon::parse($tenant->birthdate)->format('M d Y') }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Civil Status</th>
                    <td>{{ $tenant->civil_status }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>ID/ID Number</th>
                    <td>{{ $tenant->id_number }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Address</th>
                    <td>
                      {{ $tenant->barangay.', '.$tenant->city.', '.$tenant->province.', '.$tenant->country.', '.$tenant->zip_code }}
                    </td>
                  </tr>
                </thead>
              </table>
              @if($tenant->type_of_tenant === 'studying')
              <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button"
                  aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fas fa-eye"></i> View tenant's
                  educational background</a>

              </p>
              @else
              <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button"
                  aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fas fa-eye"></i> View tenant's
                  employment information</a>

              </p>
              @endif
              <div class="row">
                @if($tenant->type_of_tenant === 'studying')
                <div class="col">
                  <div class="collapse multi-collapse" id="multiCollapseExample1">

                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>High School</th>
                          <td>{{ $tenant->high_school.', '.$tenant->high_school_address }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>College/University</th>
                          <td>{{ $tenant->college_school.', '.$tenant->college_school_address }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>Course/Year</th>
                          <td>{{ $tenant->course.', '.$tenant->year_level }}</td>
                        </tr>
                      </thead>
                    </table>

                  </div>
                </div>

                @else
                <div class="col">
                  <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Employer</th>
                          <td>{{ $tenant->employer? $tenant->employer: 'NOT AVAILABLE' }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>Address</th>
                          <td>{{ $tenant->employer_address? $tenant->employer_address: 'NOT AVAILABLE' }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>Mobile</th>
                          <td>{{ $tenant->employer_contact_no? $tenant->employer_contact_no: 'NOT AVAILABLE' }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>Job description</th>
                          <td>{{ $tenant->job? $tenant->job: 'NOT AVAILABLE' }}</td>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th>Employment length</th>
                          <td>
                            {{ $tenant->years_of_employment? $tenant->years_of_employment.' years': 'NOT AVAILABLE'  }}
                          </td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                @endif

              </div>


            </div>
          </div>
          <div class="col-md-4">

            <img
              src="{{ $tenant->tenant_img? asset('storage/img/tenants/'.$tenant->tenant_img): asset('/arsha/assets/img/no-image.png') }}"
              alt="image of the tenant" class="img-thumbnail">

            <form id="uploadImageForm"
              action="/property/{{ Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/upload/img"
              method="POST" enctype="multipart/form-data">
              @method('put')
              @csrf
            </form>
            <br>

            <input type="file" form="uploadImageForm" name="tenant_img"
              class="form-control @error('tenant_img') is-invalid @enderror">
            @error('tenant_img')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
            <br>

            <button class="btn btn-primary shadow-sm btn-user btn-block" form="uploadImageForm"><i
                class="fas fa-upload fa-sm text-white-50"></i> Upload tenant image </button>

          </div>

        </div>
      </div>

      <div class="tab-pane fade" id="guardians" role="tabpanel" aria-labelledby="nav-guardians-tab">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addGuardian" data-whatever="@mdo"><i
            class="fas fa-plus"></i> New</a>
        <br><br>

        @if($guardians->count() < 1) <p class="text-danger text-center">No guardians found!</p>
          @else
          <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                  <thead>
                    <?php $ctr = 1; ?>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Relationship</th>
                      <th>Mobile</th>
                      <th>Email</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($guardians as $item)
                    <tr>
                      <th>{{ $ctr++ }}</th>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->relationship }}</td>
                      <td>{{ $item->mobile }}</td>
                      <td>{{ $item->email }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          @endif

      </div>

      {{-- <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab"> --}}
        {{-- <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus"></i> New</a>   --}}
        {{-- <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/concern/create"
          class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
        <br><br> --}}
        {{-- @if($concerns->count() < 1)
        <p class="text-danger text-center">No concerns found!</p>
        @else --}}
        {{-- <div class="row">
          <div class="col-md-12">
            <table class="table table-hover">
              
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date Reported</th>
                  <th>Urgency</th>
                  <th>Status</th>
                  <th>Assigned to</th>
                  <th>Rating</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($concerns as $item)
                <tr>
                  <th>{{ $ctr++ }}</th>
                  <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
                  <td>
                    @if($item->urgency === 'major and urgent')
                    <span class="badge badge-danger">{{ $item->urgency }}</span>
                    @elseif($item->urgency === 'major but nor urgent')
                    <span class="badge badge-warning">{{ $item->urgency }}</span>
                    @else
                    <span class="badge badge-primary">{{ $item->urgency }}</span>
                    @endif
                  </td>
                  <td>
                    @if($item->status === 'pending')
                    <i class="fas fa-clock text-warning"></i> {{ $item->status }}
                    @elseif($item->status === 'active')
                    <i class="fas fa-snowboarding text-primary"></i> {{ $item->status }}
                    @else
                    <i class="fas fa-check-circle text-success"></i> {{ $item->status }}
                    @endif
                  </td>
                  <td>{{ $item->name? $item->name: 'NULL' }}</td>
                  <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
                  <td>
                    <form
                      action="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/concern/action"
                      method="GET" onchange="submit();">
                      <select class="" name="concern_action" id="">
                        <option value="" selected>Select your action</option>
                        <option value="view">View</option>
                        <option value="edit">Edit</option>
                      </select>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div> --}}


      <div class="tab-pane fade" id="violations" role="tabpanel" aria-labelledby="nav-violations-tab">
        <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/violation/create"
          class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
        <br><br>
        @if($violations->count() < 1) <p class="text-danger text-center">No violations found!</p>
          @else
          <div class="row">
            <div class="col-md-12">
              <table class="table table-hover">
                <?php $violation_ctr = 1; ?>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date committed</th>
                    <th>Violation</th>
                    <th>Frequency</th>
                    <th>Severity</th>
                    <th>Status</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach ($violations as $item)
                  <tr>
                    <th>{{ $violation_ctr++ }}</th>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    <td>{{ $item->summary }}</td>
                    <td>{{ $item->frequency }}</td>
                    <td>{{ $item->severity }}</td>
                    <td>
                      @if($item->status === 'received')
                      <i class="fas fa-clock text-warning"></i> {{ $item->status }}
                      @elseif($item->status === 'pending')
                      <i class="fas fa-snowboarding text-primary"></i> {{ $item->status }}
                      @else
                      <i class="fas fa-check-circle text-success"></i> {{ $item->status }}
                      @endif
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
      </div>


      <div class="tab-pane fade" id="contracts" role="tabpanel" aria-labelledby="nav-contracts-tab">

        <p class="text-left"> <a href="/property/{{ Session::get('property_id') }}/contract/room/select" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> New</a> </p>

        <div style="display:none" id="showSelectedContract" class="col-md-6 p-0 m-0 mx-auto text-center">
          <div class="alert alert-success alert-dismissable custom-success-box">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="showNumberOfSelectedContract"></strong>
          </div>
        </div>
        <div class="row">
          <form action="" method="POST">
            @csrf
            @method('put')
          </form>
          <div class="col-md-12 mx-auto">
            <table class="table table-hover">
              <thead>
                <?php $ctr = 1; ?>
                <tr>

                  </th>
                  <th>#</th>

                  <th>Room</th>
                  <th>Status</th>
                  <th>Contract</th>
                  <th>Rent</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contracts as $item)
                <tr>

                  <th>{{ $ctr++ }}</th>

                  <th><a
                      href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id_foreign }}">{{  $item->building.' '.$item->unit_no }}</a>
                  </th>
                  <td>
                    @if($item->contract_status === 'active')
                    <span class="text-success"><i class="fas fa-check-circle"></i> {{ $item->contract_status }}</span>
                    @else
                    <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>

                    @endif
                  </td>
                  <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }} -
                    {{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }} ({{ $item->contract_term }})</td>

                  <td>{{ number_format($item->rent, 2) }}</td>
                  <th>
                    <form
                      action="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id_foreign }}/tenant/{{ $tenant->tenant_id }}/contract/{{ $item->contract_id }}/balance/{{ $balance->sum('balance') }}/action"
                      method="GET" onchange="submit();">
                      <select class="" name="contract_option" id="">
                        <option value="">Select your option</option>
                        <option value="edit">Edit</option>
                        @if($item->contract_status=='active')
                        <option value="transfer">Transfer</option>
                        @endif
                        @if(!$item->terminated_at)
                        <option value="terminate">Terminate</option>
                        @endif
                        @if($item->contract_status=='preparing to moveout')
                        <option value="moveout">Moveout</option>
                        @endif
                        <option value="delete">Delete</option>
                      </select>

                    </form>
                    {{--
                  <a title="delete this contract" class="btn btn-primary btn-sm" href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}/delete"><i
                      class="fas fa-trash"></i></a>
                    <a title="edit contract" class="btn btn-primary btn-sm"
                      href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}/edit"><i
                        class="fas fa-edit"></i></a>
                    @if(!$item->terminated_at)
                    @if($balance->count() > 0)
                    <a title="terminate this contract" class="btn btn-primary btn-sm text-white" data-toggle="modal"
                      data-target="#pendingBalance"><i class="fas fa-times"></i> </a>
                    @else
                    <a title="terminate this contract" class="btn btn-primary btn-sm"
                      href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}/preterminate"><i
                        class="fas fa-times"></i> </a>
                    @endif

                    @endif
                    @if($item->terminated_at)
                    @if($balance->count()>0)
                    <a title="proceed to moveout" href="#" data-toggle="modal" data-target="#pendingBalance"
                      class="btn btn-sm btn-primary text-white"><i class="fas fa-sign-out-alt"></i></a>
                    @else
                    @if($item->status != 'inactive')
                    <a title="proceed to moveout" class="btn btn-success btn-sm text-white"
                      href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}/moveout"><i
                        class="fas fa-sign-out-alt"></i> </a>
                    @endif
                    @endif
                    @endif

                    <a title="extend this contract" class="btn btn-primary btn-sm"
                      href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}/extend"><i
                        class="fas fa-external-link-alt"></i> </a>
                    <a title="view this contract" class="btn btn-primary btn-sm"
                      href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id_foreign }}/contract/{{ $item->contract_id }}"><i
                        class="fas fa-book-open"></i> </a> --}}

                  </th>

                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="credentials" role="tabpanel" aria-labelledby="nav-credentials-tab">
        @if(!$access->count())
        <a href="{{ route('create-credentials', ['property_id' => Session::get('property_id'), 'tenant_id' => $tenant->tenant_id ]) }}"
          class="btn btn-primary"><i class="fas fa-key fa-sm"></i> Generate</a>
        @endif
        <div class="table-responsive text-nowrap">
          @foreach ($access as $item)
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Email</th>
                <td>{{ $item->email }}</td>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Password</th>
                <td>{{ $item->unhashed_password }}</td>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Created</th>
                <td>{{ $item->created_at? $item->created_at: 'NOT AVAILABLE' }}</td>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Verified</th>
                <td>{{ $item->updated_at? $item->updated_at: 'NOT AVAILABLE' }}</td>
              </tr>
            </thead>
          </table>
          @endforeach
        </div>

      </div>

      <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
        {{-- <a href="#" data-toggle="modal" data-target="#addBill" class="btn btn-primary"><i class="fas fa-plus"></i> New</a>  --}}
        <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/create/bill"
          class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
        {{-- @if(Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
          <a href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/edit" class="btn
        btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
        @endif --}}
        @if($balance->count() > 0)
        <a target="_blank" href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/export"
          class="btn btn-primary"><i class="fas fa-download"></i> Export</span></a>
        {{-- @if($tenant->email_address !== null)
          <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/send"
        class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</span></a>
        @endif --}}
        @endif



        <br>
        <br>
      
            <table class="table table-hover">
              <?php $ctr=1; ?>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date posted</th>
                  <th>Bill no</th>
                  <th>Particular</th>
                  <th>Period covered</th>
                  <th>Bill Amount</th>
                  <th>Amount Paid</th>
                  <th>Balance</th>
                  <th></th>
               
                </tr>
              </thead>
              @foreach ($balance as $item)
              <tr>
                <th>{{ $ctr++ }}</th>
                <td>{{Carbon\Carbon::parse($item->date_posted)->format('M d Y')}}</td>
                <td>{{ $item->bill_no }}</td>
                <td>{{ $item->particular }}</td>
                <td>
                  {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                  {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                </td>
                <td>{{ number_format($item->amount,2) }}</td>
                <td>{{ number_format($item->amt_paid,2) }}</td>
                <td>
                  @if($item->balance > 0)
                  <span class="text-danger">{{ number_format($item->balance,2) }}</span>
                  @else
                  <span>{{ number_format($item->balance,2) }}</span>
                  @endif
                </td>
                <td><a class="text-danger" href="/bill/{{ $item->bill_id }}/delete/bill"><i class="fas fa-times"></i>
                    Remove</a></td>
              </tr>
              @endforeach
              <tr>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ number_format($balance->sum('amount'),2) }}</th>
                <th>{{ number_format($balance->sum('amt_paid'),2) }}</th>
                <th class="text-danger">
                  @if($balance->sum('balance') > 0)
                  <span class="text-danger">{{ number_format($balance->sum('balance'),2) }}</span>
                  @else
                  <span>{{ number_format($balance->sum('balance'),2) }}</span>
                  @endif
                </th>
                {{-- <th>Action</th> --}}
              </tr>

            </table>


      </div>
      <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="nav-payments-tab">
        @if(Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign
        === 1)
        @if($balance->count() > 0)
        <a href="#" data-toggle="modal" data-target="#acceptPayment" class="btn btn-primary"><i class="fas fa-plus"></i>
          New</a>
        @endif
        @endif
        <a target="_blank"
          href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/payments/export"
          class="btn btn-primary"><i class="fas fa-download"></i> Export</span></a>
        <br><br>
        @if($payments->count() < 1) <p class="text-danger text-center">No payments found!</p>
          @else

          <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
            <table class="table table-hover">
              <thead>
                <tr>
                  <?php $ctr = 1; ?>
                  <th class="text-center">#</th>
                  <th>Date</th>
                  <th>AR No</th>
                  <th>Bill No</th>
                  {{-- <th>Room</th>   --}}
                  <th>Particular</th>
                  <th colspan="2">Period Covered</th>
                  <th>Form</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              @foreach ($payments as $item)
              <tr>
                <th class="text-center">{{ $ctr++ }}</th>
                <td>{{ Carbon\Carbon::parse($item->payment_created)->format('M d, Y') }}</td>
                <td> {{ $item->ar_no }}</td>
                <td>{{ $item->payment_bill_no }}
                </td>
                <td>{{ $item->particular }}</td>
                <td colspan="2">
                  {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                  {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                </td>
                <td>{{ $item->form }}</td>
                <td>{{ number_format($item->amt_paid,2) }}</td>
                <td>
                  @if($item->form=='Credit memo')

                  @else
                  <form
                    action="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/contract/{{ $item->contract_id }}/tenant/{{ $item->bill_tenant_id }}/bill/{{ $item->bill_id }}/payment/{{ $item->payment_id }}/action"
                    method="GET" onchange="submit();">
                    <select class="" name="collection_option" id="">
                      <option value="">Select your action</option>
                      <option value="Credit memo">Credit memo</option>
                      <option value="export">Export</option>
                      <option value="remit">Remit</option>
                    </select>
                  </form>
                  @endif
                </td>
              </tr>
              @endforeach
            </table>
          </div>

          @endif
      </div>
    </div>
  </div>
</div>

@include('webapp.tenants.show_includes.contracts.create')

@include('webapp.tenants.show_includes.contracts.moveout')

@include('webapp.tenants.show_includes.contracts.extend')

@include('webapp.tenants.show_includes.contracts.pending-balance')

@include('webapp.tenants.show_includes.contracts.request-moveout')

@include('webapp.tenants.show_includes.contracts.approve-moveout')

@include('webapp.tenants.show_includes.guardians.create')

@include('webapp.tenants.show_includes.tenants.upload-img')

@include('webapp.tenants.show_includes.bills.create')

@include('webapp.tenants.show_includes.payments.create')

@include('webapp.tenants.show_includes.rooms.warning-exceeds-limit')

@include('webapp.tenants.show_includes.concerns.create')

@include('webapp.tenants.show_includes.violations.create')



{{-- Modal for warning message --}}
<div class="modal fade" id="sendNotice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Notice</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="text-justify">
          <h5>Hello, {{ $tenant->first_name }}!</h5>

          <p>Your contract in <b></b> is set to expire on
            <b>{{ Carbon\Carbon::parse($tenant->moveout_date)->format('M d Y') }}</b>, exactly <b>{{ $diffInDays }} days
            </b> from now.

            Would you like to extend your contract?If yes, for how long? </p>

          <p><b>This is a system generated message, and we do not receive emails from this account. Please let us know
              your response atleast a week before your moveout date through this email {{ Auth::user()->email }}
              instead. </b></p>

          Sincerely,
          <br>
          {{ Auth::user()->property }}
        </span>
        <hr>

        <form action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/alert/contract">
          @csrf
          <span>
            <p class="text-right">
              <button type="button" class="d-none d-sm-inline-block btn btn-secondary shadow-sm" data-dismiss="modal"><i
                  class="fas fa-times fa-sm text-white-50"></i> Close</button>
              <button class="btn btn-primary btn btn-primary" title="for manager and admin access only" type="submit"
                onclick="this.form.submit(); this.disabled = true;"><i
                  class="fas fa-paper-plane fa-sm text-white-50"></i> Send</button>
            </p>
        </form>
        </p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="pendingBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Balance</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-danger">Tenant needs to pay the balance to moveout.</p>
        <div class="row">
          <div class="col">

            <div class="table-responsive text-nowrap">

              <table class="table">
                <thead>
                  <tr>

                    <th>Bill No</th>

                    <th>Particular</th>
                    <th>Period Covered</th>
                    <th class="text-right" colspan="3">Amount</th>

                  </tr>
                </thead>
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
                  <th>TOTAL</th>
                  <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
                </tr>
              </table>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" aria-label="Close" class="btn btn-primary"> Dismiss</a>
      </div>

    </div>
  </div>
</div>
@endsection



@section('scripts')
<script type="text/javascript">
  //adding moveout charges upon moveout
    $(document).ready(function(){
        var i=1;
    $("#add_row").click(function(){
        $('#addr'+i).html("<th id='value'>"+ (i) +"</th><td><input class='form-control' form='requestMoveoutForm' name='particular"+i+"' id='desc"+i+"' type='text' required></td><td><input class='form-control' form='requestMoveoutForm'    oninput='autoCompute("+i+")' name='price"+i+"' id='price"+i+"' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm'  oninput='autoCompute("+i+")' name='qty"+i+"' id='qty"+i+"' value='1' type='number' min='1' required></td><td><input class='form-control' form='requestMoveoutForm' name='amount"+i+"' id='amt"+i+"' type='number' min='1' required readonly value='0'></td>");
     $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
     i++;
     document.getElementById('no_of_charges').value = i;
    });
    $("#delete_row").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        document.getElementById('no_of_charges').value = i;
        }
    });
        var j=1;
    $("#add_charges").click(function(){
      $('#row'+j).html("<th>"+ (j) +"</th><td><select class='form-control' name='particular"+j+"' form='extendTenantForm' id='particular"+j+"'><option value='Security Deposit (Rent)'>Security Deposit (Rent)</option><option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option><option value='Advance Rent'>Advance Rent</option><option value='Rent'>Rent</option><option value='Electric'>Electric</option><option value='Water'>Water</option></select> <td><input class='form-control' form='extendTenantForm' name='start"+j+"' id='start"+j+"' type='date' value='{{ $tenant->moveout_date }}' required></td> <td><input class='form-control' form='extendTenantForm' name='end"+j+"' id='end"+j+"' type='date' required></td> <td><input class='form-control' form='extendTenantForm'   name='amount"+j+"' id='amount"+j+"' type='number' min='1' step='0.01' required></td>");
     $('#extend_table').append('<tr id="row'+(j+1)+'"></tr>');
     j++;
     
        document.getElementById('no_of_items').value = j;
 });
    $("#remove_charges").click(function(){
        if(j>1){
        $("#row"+(j-1)).html('');
        j--;
        
        document.getElementById('no_of_items').value = j;
        }
    });
    var k=1;
    $("#add_bill").click(function(){
      $('#bill'+k).html("<th>"+ (k) +"</th><td><select class='form-control' name='particular"+k+"' form='addBillForm' id='particular"+k+"' required><option value='' selected>Please select one</option>@foreach($property_bills as $item)<option value='{{$item->particular_id}}'>{{ $item->particular }}</option>@endforeach</select> <td><input class='form-control' form='addBillForm' name='start"+k+"' id='start"+k+"' type='date' value='{{ $tenant->movein_date }}' required></td> <td><input class='form-control' form='addBillForm' name='end"+k+"' id='end"+k+"' type='date' value='{{ $tenant->moveout_date }}' required></td> <td><input class='form-control' form='addBillForm' name='amount"+k+"' id='amount"+k+"' type='number' min='1' step='0.01' required></td>");
     $('#table_bill').append('<tr id="bill'+(k+1)+'"></tr>');
     k++;
     
        document.getElementById('no_of_bills').value = k;
 });
    $("#delete_bill").click(function(){
        if(k>1){
        $("#bill"+(k-1)).html('');
        k--;
        
        document.getElementById('no_of_bills').value = k;
        }
    });
});
</script>

<script>
  function autoCompute(val) {
    price = document.getElementById('price'+val).value;
    qty = document.getElementById('qty'+val).value;
    
    amt = document.getElementById('amt'+val).value =  parseFloat(price) *  parseFloat(qty);
   
  }
</script>

<script type="text/javascript">
  //adding moveout charges upon moveout
    $(document).ready(function(){
    var j=1;
    $("#add_payment").click(function(){
        $('#payment'+j).html("<th>"+ (j) +"</th><td><select class='form-control' form='acceptPaymentForm' name='bill_no"+j+"' id='bill_no"+j+"' required><option >Please select one</option> @foreach ($bills as $item)<option value='{{ $item->bill_no.'-'.$item->bill_id }}'> Bill No {{ $item->bill_no }} | {{ $item->particular }} | {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }} | {{ number_format($item->balance,2) }} </option> @endforeach </select></td><td><select class='form-control' form='acceptPaymentForm' name='form"+j+"' required><option value=''>Please select one</option><option value='Cash'>Cash</option><option value='Bank Deposit'>Bank Deposit</option><option value='Cheque'>Cheque</option></select></td><td><input class='form-control' form='acceptPaymentForm' name='amt_paid"+j+"' id='amt_paid"+j+"' type='number' step='0.001' min='0' required></td><td>  <input class='form-control' form='acceptPaymentForm' type='text' name='bank_name"+j+"'></td><td><input class='form-control' form='acceptPaymentForm' type='text' name='cheque_no"+j+"'></td>");
  
  
     $('#payment').append('<tr id="payment'+(j+1)+'"></tr>');
     j++;
     document.getElementById('no_of_payments').value = j;
  
    });
  
    $("#delete_payment").click(function(){
        if(j>1){
        $("#payment"+(j-1)).html('');
        j--;
        document.getElementById('no_of_payments').value = j;
        }
    });
  });
</script>

<script>
  function autoFill(){
    var moveout_date = document.getElementById('moveout_date').value;
    var movein_date = document.getElementById('movein_date').value;
    var rent = document.getElementById('rent').value;
    

    date1 = new Date(movein_date);
    date2 = new Date(moveout_date);

    let diff = date2-date1; 

    let months = 1000 * 60 * 60 * 24 * 28;

    let dateInMonths = Math.floor(diff/months);

    document.getElementById('number_of_months').value = dateInMonths +' month/s';

    if(dateInMonths <=0 ){
      document.getElementById('invalid_date').innerText = 'Invalid movein or moveout date!';
    }else{
      document.getElementById('invalid_date').innerText = ' ';
      if(dateInMonths <5 ){
        document.getElementById('term').value = 'Short Term';
        document.getElementById('discount').value = 0;
        document.getElementById('rent').value = document.getElementById('original').value;
      }else{
        document.getElementById('term').value = 'Long Term';
        document.getElementById('discount').value = (document.getElementById('original').value * .1);
        document.getElementById('rent').value = document.getElementById('original').value - (document.getElementById('original').value * .1) ;
      }
     
     
    }
  }
</script>

<script>
  function selectAll(){

    var x = document.getElementById("selectAll").checked;

    if(x == true){     
      $("#showSelectedContract").show();  
      var checkboxes = $('input:checkbox').length;
      $(':checkbox').each(function() {
        this.checked = true;   
         document.getElementById('showNumberOfSelectedContract').innerHTML =  'You have selected ' + parseInt(checkboxes-1) + ' contracts';                
    });
    }else{ 
      $("#showSelectedContract").hide();  
      $(':checkbox').each(function() {
        this.checked = false;                        
    });
    }
    
   
  }
</script>

<script>
  function selectOne(){
    $("#showSelectedContract").show();  
    var checkboxes = $('input:checkbox:checked').length;
      document.getElementById('showNumberOfSelectedContract').innerHTML =  'You have selected ' + parseInt(checkboxes-1) + ' contracts';   
  }
</script>

<script>
  $('#add_payment').on('click',function(){
    $(".addPaymentButton").show()  
});
</script>

@endsection