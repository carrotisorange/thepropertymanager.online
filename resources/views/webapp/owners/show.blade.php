@extends('layouts.argon.main')

@section('title', $owner->name)

@section('upper-content')
{{-- <div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $owner->name }}</h6>

  </div>

</div> --}}
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0"> {{ $owner->name }}</h6>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-owner-tab" data-toggle="tab" href="#owner" role="tab"
            aria-controls="nav-owner" aria-selected="true"> <i class="fas fa-user-tie text-teal"></i> Profile</a>
          @if($access->count() <=0 ) <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#credentials"
            role="tab" aria-controls="nav-user" aria-selected="false"> <i class="fas fa-key text-green"></i> Credentials
            <i class="fas fa-exclamation-triangle text-danger"></i></a>
            @else
            <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#credentials" role="tab"
              aria-controls="nav-user" aria-selected="false"> <i class="fas fa-key text-green"></i> Credentials </a>
            @endif
            <a class="nav-item nav-link" id="nav-bank-tab" data-toggle="tab" href="#bank" role="tab"
              aria-controls="nav-bank" aria-selected="false"><i class="fas fa-money-check text-yellow"></i> Banks <span
                class="badge badge-primary"></span></a>
            <a class="nav-item nav-link" id="nav-certificates-tab" data-toggle="tab" href="#certificates" role="tab"
              aria-controls="nav-certificates" aria-selected="false"><i class="fas fa-home text-indigo"></i>
              Certificates <span class="badge badge-success">{{ $rooms->count() }}</span>
            </a>

            {{-- <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab"
              aria-controls="nav-bills" aria-selected="false"><i
                class="fas fa-file-signature fa-sm text-primary-50"></i> Bills <span
                class="badge badge-primary badge-counter">{{ $bills->count() }}</span></a>
            --}}
        </div>
      </nav>

    </div>

  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="owner" role="tabpanel" aria-labelledby="nav-owner-tab">
        <div class="row">
          <div class="col-md-8">

            <a href="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/edit"
              class="btn btn-primary"><i class="fas fa-edit fa-sm text-dark-50"></i> Edit</a>
            {{-- @if(Auth::user()->role_id_foreign === 4)
            <form action="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}/delete" method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                onclick="return confirm('Are you sure you want perform this action?');"><i
                  class="fas fa-trash-alt fa-sm text-white-50"></i></button>
            </form>
            @endif --}}
            <br><br>

            <div class="table-responsive text-nowrap">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <td>{{ $owner->name }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Email</th>
                    <td>{{ $owner->email }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Mobile</th>
                    <td>{{ $owner->mobile }}</td>
                  </tr>
                </thead>

                <thead>

                  <tr>
                    <th>Occupation</th>
                    <td>{{ $owner->occupation }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Address</th>
                    <td>{{ $owner->address }}</td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Representative</th>
                    <td>{{ $owner->representative }}</td>
                  </tr>
                </thead>

              </table>
            </div>


          </div>
          <div class="col-md-4">

            <img
              src="{{ $owner->img? asset('/storage/img/owners/'.$owner->img): asset('/arsha/assets/img/no-image.png') }}"
              alt="..." class="img-thumbnail">

            <form id="uploadImageForm"
              action="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/upload/img" method="POST"
              enctype="multipart/form-data">
              @method('put')
              @csrf
            </form>
            <br>

            <input type="file" form="uploadImageForm" name="img"
              class="form-control @error('img') is-invalid @enderror">
            @error('img')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
            <br>

            <button class="btn btn-primary btn-user btn-block" form="uploadImageForm"><i
                class="fas fa-upload fa-sm text-white-50"></i> Upload Image </button>

          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="credentials" role="tabpanel" aria-labelledby="nav-user-tab">
        @if($access->count() <=0 ) <a href="/property/{{ Session::get('property_id') }}/owner/{{ $owner->owner_id }}/create/credentials" class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
          <br><br>
          @endif


          <div class="col-md-12 mx-auto">
            <div class="table-responsive">
              <div class="table-responsive text-nowrap">

                @foreach ($access as $item)

                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <td>{{ $item->user_email }}</td>
                    </tr>
                  </thead>
                  <thead>
                    <tr>
                      <th>Default password</th>
                      <td>{{ $item->unhashed_password }}</td>
                    </tr>
                  </thead>
                  <thead>

                    <tr>
                      <th>Created at</th>
                      <td>{{ $item->created_at }}</td>
                    </tr>
                  </thead>

                  <thead>
                    <tr>
                      <th>Verified at</th>
                      <td>{{ $item->updated_at }}</td>
                    </tr>
                  </thead>
                </table>
                @endforeach

              </div>
            </div>
          </div>
      </div>

      <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="nav-certificates-tab">
        <a href="{{ route('create-certificate', ['property_id' => Session::get('property_id'),'owner_id' => $owner->owner_id]) }}"
          class="btn btn-primary">
          <i class="fas fa-plus fa-sm text-white-50"></i> New
        </a>
        <br><br>
        <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <?php $ctr = 1; ?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date purchased</th>

                  <th>Room</th>
                  <th>Payment</th>
                  <th>Type</th>

                  <th>Status</th>
                  <th>Rent</th>
                  <th>Occupancy</th>
                </tr>
              </thead>
              @foreach ($rooms as $item)
              <tbody>
                <tr>
                  <th>{{ $ctr++ }}</th>
                  <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>

                  <td>
                    @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
                    Session::get('property_type') === '6' || Session::get('property_type') === 1 ||
                    Session::get('property_type') === '6')
                    <a href="/property/{{ Session::get('property_id') }}/unit/{{ $item->unit_id }}">{{ $item->building.'
                      '.$item->unit_no }}</a>
                    @else
                    <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}">{{ $item->building.'
                      '.$item->unit_no }}</a>
                    @endif

                  </td>
                  <td>{{ $item->payment_type }}</td>

                  <td>{{ $item->type }}</td>

                  <td>{{ $item->status }}</td>
                  <td>{{ number_format($item->rent, 2) }}</td>
                  <td>{{ $item->occupancy? $item->occupancy: 0 }} pax</td>
                </tr>
              </tbody>
              @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">

      </div>
      <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="nav-bank-tab">

        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Bank</th>
                <td>{{ $owner->bank_name }}</td>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Account name</th>
                <td>{{ $owner->account_name }}</td>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Account number</th>
                <td>{{ $owner->account_number }}</td>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('main-content')

@endsection

@section('scripts')

@endsection