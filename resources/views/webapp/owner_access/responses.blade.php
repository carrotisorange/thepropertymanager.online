@extends('webapp.owner_access.template')

@section('title', $concern->details)


@section('css')
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

<style>
  div.stars {
width: 270px;
display: inline-block;
}
input.star { display: none; }
label.star {
float: right;
padding: 10px;
font-size: 36px;
color: #444;
transition: all .2s;
}
input.star:checked ~ label.star:before {
content: '\f005';
color: #FD4;
transition: all .25s;
}
input.star-5:checked ~ label.star:before {
color: #FE7;
text-shadow: 0 0 20px #952;
}
input.star-1:checked ~ label.star:before { color: #F62; }
label.star:hover { transform: rotate(-15deg) scale(1.3); }
label.star:before {
content: '\f006';
font-family: FontAwesome;
}
</style>
@endsection

@section('sidebar')

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Owner Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
              <i class="fas fa-file-signature text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/bills">
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/payments">
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active " href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
          </li>
  

        </ul>
      </div>
    </div>
  </div>
</nav>
@endsection


@section('upper-content')
<div class="col-lg-6">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ $concern->details }}</h6>
   
  </div>
<div class="col-md-6">
    
  @if($concern->status != 'closed')
  <p class="text-right"><a href="#" title="You can close the concern once you're satisfied with the action made the person/s in charge." data-toggle="modal" data-target="#markAsCompleteModal" class="btn btn-primary"> Did the employee address your concern?</a></p>
  @else
  <p class="text-right"><button class="btn btn-success">The concern is closed.</button></p>
  @endif
</div>

@endsection

@section('main-content')

<div class="row">

 <div class="col-md-12">
  <p class="text-danger">This page will serve as your way of communicating to the person/s in charge of your concern. Please provide as many details as possible to properly address your concern. </p>
    
        <form action="/concern/{{ $concern->concern_id }}/response" method="POST">
          @csrf
    
          <textarea class="form-control" name="response" id="" cols="30" rows="3" placeholder="type your response here..."></textarea required>
    <br>
      <p class="text-right">  <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Response </button></p>
      </form>
  
    </div>

</div>
<hr>
<h6 class="h2 text-dark d-inline-block mb-0">Responses ({{ $responses->count() }})</h6>
<br><br>
@if($responses->count() < 1)
  <p class="text-center text-red">No responses found!</p>
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
                   <?php $explode = explode(" ", $item->posted_by );?>
                    <h4 class="mb-0 text-sm">{{ $explode[0] }}</h4>
                  </div>
                  <div class="text-right text-muted">

                    <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </small>
                   
                    
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

<div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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



<div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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



<div class="modal fade" id="markAsCompleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content  text-center">
      <div class="modal-header">

      <h5 class="modal-title" id="exampleModalLabel">Rate employee</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <p>
       
          How did the employee handle the concern?


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


     
      <p class="">Feedback</p>
      <textarea form="markAsCompleteModalForm" class="form-control" id="" cols="30" rows="5" name="feedback" required>
        
      </textarea>
  
 
      </div>
      <div class="modal-footer">
          <button form="markAsCompleteModalForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Submit</button>
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



