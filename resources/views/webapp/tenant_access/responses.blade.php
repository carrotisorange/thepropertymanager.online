@extends('webapp.tenant_access.template')

@section('title', $concern->details)


@section('css')
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

<style>
  div.stars {
    width: 270px;
    display: inline-block;
  }

  input.star {
    display: none;
  }

  label.star {
    float: right;
    padding: 10px;
    font-size: 36px;
    color: #444;
    transition: all .2s;
  }

  input.star:checked~label.star:before {
    content: '\f005';
    color: #FD4;
    transition: all .25s;
  }

  input.star-5:checked~label.star:before {
    color: #FE7;
    text-shadow: 0 0 20px #952;
  }

  input.star-1:checked~label.star:before {
    color: #F62;
  }

  label.star:hover {
    transform: rotate(-15deg) scale(1.3);
  }

  label.star:before {
    content: '\f006';
    font-family: FontAwesome;
  }
</style>
@endsection

@section('upper-content')
{{-- <div class="col-md-6">
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

</div> --}}
<br><br>
<div class="row">
  <div class="col-md-12">
    @if($concern->status != 'closed')
    <p class="text-right"><a href="#"
        title="You can close the concern once you're satisfied with the action made the person/s in charge."
        data-toggle="modal" data-target="#markAsCompleteModal" class="btn btn-primary"><i class="fas fa-question-circle"></i> Did the employee address
        your concern?</a></p>
    @else
    <p class="text-center">Concern has been closed.</p>
    @endif
  </div>
</div>

@endsection

@section('main-content')
@if($concern->status != 'closed')

<p class="text-center"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addResponse"
    data-whatever="@mdo"><i class="fas fa-plus"></i> Add</a></p>
</p>
@endif

  <div class="row">
    <div class="col">
      @if(!$concern->approved_by_tenant_at)
      
      
<span class="list-group-item list-group-item-action">
  <div class="row align-items-center">

    <div class="col">
      <div class="d-flex justify-content-between align-items-center">
        <div>

          <h4 class="mb-0 text-sm">{{ $concern->concern_user_id }}</h4>
        </div>
        <div class="text-right text-muted">

          <small>{{ Carbon\Carbon::parse($concern->assessed_at)->format('M d, Y') }}
            ({{ Carbon\Carbon::parse($concern->assessed_at)->diffForHumans() }}) </small>


        </div>
      </div>
      <p class="text-sm text-muted mb-0"> Your concern has been assessed. Click <a href="">here</a>  to see the details of the concern.</p>

    </div>
  </div>
</span>
      @endif
      <div class="list-group list-group-flush">
        <span class="list-group-item list-group-item-action">
          <div class="row align-items-center">
        
            <div class="col">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  
                  <h4 class="mb-0 text-sm">{{ Auth::user()->name }}</h4>
                </div>
                <div class="text-right text-muted">
        
                  <small>{{ Carbon\Carbon::parse($concern->reported_at)->format('M d, Y') }}
                    ({{ Carbon\Carbon::parse($concern->reported_at)->diffForHumans() }}) </small>
        
        
                </div>
              </div>
              <p class="text-sm text-muted mb-0"> {!! $concern->details !!}</p>
        
            </div>
          </div>
        </span>
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

  
  <div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content  text-center">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter your response</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/concern/{{ $concern->concern_id }}/response" method="POST">
            @csrf
            <input type="hidden" name="concern_id" value={{ $concern->concern_id }}>

            <textarea class="form-control" name="response" id="" cols="30" rows="3"
              placeholder="type your response here..."></textarea required>
        
    
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-submit"></i><i class="fas fa-check"></i> Submit </button>
      </form>
      </div>
  </div>
  </div>

</div>



<div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content  text-center">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Response</h5>
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
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Submit </button>
      </form>
      </div>
  </div>
  </div>

</div>



<div class="modal fade" id="markAsCompleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content  text-center">
      <div class="modal-header">

      <h5 class="modal-title" id="exampleModalLabel">Enter your rating</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <p class="text-left">
       
          How well did the employee handle your concern?


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

 
  
  <input form="markAsCompleteModalForm" type="hidden" name="id" value="{{ $concern->concern_user_id }}">


     
   <p class="text-left">Please provide your overall feedback.</p>
      <textarea form="markAsCompleteModalForm" class="form-control" id="" cols="30" rows="5" name="feedback" required>
        
      </textarea>


        </div>
        <div class="modal-footer">
          <button form="markAsCompleteModalForm" type="submit" class="btn btn-primary btn-block"
            onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
        </div>
      </div>
    </div>

  </div>




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