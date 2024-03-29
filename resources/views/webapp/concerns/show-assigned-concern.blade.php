@extends('layouts.argon.main')

@section('title', $concern->details)

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6">
    <h6 class="h2 text-dark d-inline-block mb-0">Concern # {{ $concern->concern_id }}
      (
      @if($concern->status === 'pending')
      <span class="text-warning"><i class="fas fa-clock "></i> {{ $concern->status }}</span>
      @elseif($concern->status === 'active')
      <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $concern->status }}</span>
      @else
      <span class="text-success"><i class="fas fa-check-circle "></i> {{ $concern->status }}</span>
      @endif
      )
    </h6>
  </div>

  <div class="col-md-6 text-right">
    <h6 class="h2 text-dark d-inline-block mb-0">Urgency:
      @if($concern->urgency === 'urgent')
      <span class="badge badge-danger">{{ $concern->urgency }}</span>
      @elseif($concern->urgency === 'major')
      <span class="badge badge-warning">{{ $concern->urgency }}</span>
      @else
      <span class="badge badge-primary">{{ $concern->urgency }}</span>
      @endif
    </h6>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Details: {{ $concern->details  }}</h6>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    @if($responses->count() <= 0) <p class="text-center text-danger">No responses found!</p>
      @else
      <div class="row">
        <div class="col">
          <div class="list-group list-group-flush">
            @foreach ($responses as $item)

            <span class="list-group-item list-group-item-action">
              <div class="row align-items-center">

                <div class="col">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="mb-0 text-sm">{{ $item->posted_by }}</h4>
                    </div>
                    <div class="text-right text-muted">

                      <small>{{ Carbon\Carbon::parse($concern->created_at)->format('M d, Y') }}
                        ({{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}) </small>


                    </div>
                  </div>
                  <p class="text-sm text-muted mb-0"> {!! $item->response !!}</p>

                </div>
              </div>
            </span>

            @endforeach

          </div>


        </div>

      </div>
      @endif
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12 text-right">
    <a href="#" data-toggle="modal" data-target="#addResponse" class="btn btn-primary"><i
        class="fas fa-plus text-dark-50"></i> Add Response</a>
  </div>
</div>



<div class="modal fade" id="editConcernDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Concern Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editConcernDetailsForm" action="/concerns/{{ $concern->concern_id }}" method="POST">
          @method('put')
          {{ csrf_field() }}
        </form>


        <div class="row">
          <div class="col">
            <label>Date reported</label>
            <input type="date" form="editConcernDetailsForm" class="form-control" name="reported_at"
              value="{{ $concern->reported_at }}" required>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <label>Title</label>
            <input type="text" form="editConcernDetailsForm" class="form-control" name="title"
              value="{{ $concern->title }}" required>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <label>Category</label>
            <select class="form-control" form="editConcernDetailsForm" name="category" id="" required>
              <option value="{{ $concern->category }}" readonly selected class="bg-primary">{{ $concern->category }}
              </option>
              <option value="billing">billing</option>
              <option value="internet">internet</option>
              <option value="employee">employee</option>
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
            <select class="form-control" form="editConcernDetailsForm" name="urgency" id="" required>
              <option value="{{ $concern->urgency }}" readonly selected class="bg-primary">{{ $concern->urgency }}
              </option>
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
            <textarea form="editConcernDetailsForm" class="form-control" name="details" id="" cols="30" rows="10"
              required>
              {{ $concern->details }}
             </textarea>
          </div>
        </div>
        {{-- 
      <br>
        <div class="row">
            <div class="col">
                <label>Assigned to</label>
                <select class="form-control" form="editConcernDetailsForm" name="concern_user_id" id="" required>
                    <option value="{{ $concern->concern_user_id }}" readonly selected
        class="bg-primary">{{ $concern->concern_user_id }}</option>
        @foreach ($users as $item)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
        </select>
      </div>
    </div> --}}

  </div>
  <div class="modal-footer">

    <button form="editConcernDetailsForm" type="submit" class="btn btn-primary"
      onclick="this.form.submit(); this.disabled = true;"> Update</button>
  </div>
</div>
</div>

</div>



<div class="modal fade" id="addJobOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Job Order Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/property/{{Session::get('property_id')}}/concern/{{ $concern->concern_id }}/joborder"
          method="POST">
          @csrf

          <div class="row">
            <div class="col">
              <label>Date</label>
              <input type="date" class="form-control" name="created_at"
                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label>Personnel</label>
              {{-- <select  class="form-control r" name="personnel_id_foreign" id="personnel_id_foreign" required> --}}
              <select class="form-control form-control-user @error('personnel_id_foreign') is-invalid @enderror"
                name="personnel_id_foreign" id="personnel_id_foreign" required>
                <option value="">Please select one</option>
                @foreach ($personnels as $item)
                <option value="{{ $item->personnel_id }}">{{ $item->personnel_name }}</option>
                @endforeach
              </select>

              @error('personnel_id_foreign')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label>Summary</label>
              <textarea class="form-control form-control-user @error('summary') is-invalid @enderror" name="summary"
                id="" cols="30" rows="3" placeholder="enter the summary of the job order..."></textarea required>
              @error('summary')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
    </div>
         
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add Job Order </button>
      </form>
      </div>
  </div>
  </div>

</div>

<div class="modal fade" id="forwardConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Assign An Employee</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <form id="forwardConcernForm" action="/property/{{ Session::get('property_id') }}/concern/{{ $concern->concern_id }}/forward" method="POST">
        @method('put')
        {{ csrf_field() }}
      </form>
      
    
        <div class="row">
            <div class="col">
                <label>Urgency</label>
                <select class="form-control" form="forwardConcernForm" name="urgency" id="" required>
                    <option value="{{ $concern->urgency }}" readonly selected class="bg-primary">{{ $concern->urgency }}</option>
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
                <label>Assigned to</label>
                <select class="form-control" form="forwardConcernForm" name="concern_user_id" id="" required>
                    <option value="{{ $concern->concern_user_id }}" readonly selected class="bg-primary">{{ $concern->concern_user_id }}</option>
                    @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

      </div>
      <div class="modal-footer">

          <button form="forwardConcernForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Forward Concern</button>
      </div>
  </div>
  </div>

</div>


<div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content  text-center">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Response Information</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <form action="/concern/{{ $concern->concern_id }}/response" method="POST">
          @csrf
          <input type="hidden" name="concern_id" value={{ $concern->concern_id }}>
    
          <textarea class="form-control" name="response" id="" cols="30" rows="3" placeholder="type your response here..."></textarea required>
        
    
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add Response </button>
      </form>
      </div>
  </div>
  </div>

</div>



<div class="modal fade" id="markAsCompleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content  text-center">
      <div class="modal-header">

      <h5 class="modal-title" id="exampleModalLabel">Rating Information</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <p>
          @foreach ($concern_details as $concern)
          How did <b>{{ $concern->name }}</b> handle the concern?

          @endforeach
        </p>
      <form id="markAsCompleteModalForm" action="/concern/{{ $concern->concern_id }}/closed" method="POST">
        @method('put')
        {{ csrf_field() }}
      </form>
      <div class="stars">
          <input  form="markAsCompleteModalForm" class="star star-5" id="star-5" type="radio" value="5" name="rating"/>
          <label class="star star-5" for="star-5"></label>
          <input  form="markAsCompleteModalForm" class="star star-4" id="star-4" type="radio" value="4" name="rating"/>
          <label class="star star-4" for="star-4"></label>
          <input  form="markAsCompleteModalForm" class="star star-3" id="star-3" type="radio" value="3" name="rating"/>
          <label class="star star-3" for="star-3"></label>
          <input  form="markAsCompleteModalForm" class="star star-2" id="star-2" type="radio" value="2" name="rating"/>
          <label class="star star-2" for="star-2"></label>
          <input  form="markAsCompleteModalForm" class="star star-1" id="star-1" type="radio" value="1" name="rating"/>
          <label class="star star-1" for="star-1"></label>
      </div>
  <br>

  @foreach ($concern_details as $concern)
  
  <input form="markAsCompleteModalForm" type="hidden" name="id" value="{{ $concern->id }}">

  @endforeach

     
      <p class="">Feedback</p>
      <textarea form="markAsCompleteModalForm" class="form-control" id="" cols="30" rows="5" name="feedback" required>
        
      </textarea>


            </div>
            <div class="modal-footer">
              <button form="markAsCompleteModalForm" type="submit" class="btn btn-primary"
                onclick="this.form.submit(); this.disabled = true;"> Mark as closed and rate </button>
            </div>
          </div>
      </div>

    </div>



    @endsection

    @section('main-content')

    @endsection

    @section('scripts')
    <script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
      CKEDITOR.replace( 'response', {
      filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form',
  });
    </script>
    @endsection