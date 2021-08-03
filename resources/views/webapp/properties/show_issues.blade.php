@extends('layouts.argon.main')

@section('title', 'Issues')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-12 col-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Issue # {{ $issue->issue_id.' : '.$issue->details }}</h6>
    
  </div>

</div>

<div class="row">
    <div class="col">
  
        
  
          <form action="/dev/issue/{{ $issue->issue_id }}/responses" method="POST">
            @csrf
        
      
            <textarea  class="form-control form-control-user @error('response') is-invalid @enderror" name="response" id="" cols="30" rows="3" placeholder="enter your response here..."></textarea required>
            
              @error('response')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
        
          <br>
        <p class="text-right">
          <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add Response</button>
        </p>
        </form>
      
    
    </div>
  </div>

  <div class="row align-items-center py-4">
    <div class="col-lg-12 col-12">
      <h6 class="h2 text-dark d-inline-block mb-0">Threads ({{ $responses->count() }})</h6>
      
    </div>
  
  </div>
<div class="row">
  <div class="col">
    @if($responses->count()<1)
    <p class="text-center text-danger">No responses found!</p>
    @else
    <div class="list-group list-group-flush">
        @foreach ($responses as $item)
     
        <span class="list-group-item list-group-item-action">
          <div class="row align-items-center">
            <div class="col-auto">
                <!-- Avatar -->
              @if($item->role_id_foreign === 'dev')
              <i class="fas fa-user-secret text-red"></i>
              @else
              <i class="fas fa-user-circle text-primary"></i>
              @endif
              </div>
            <div class="col">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="mb-0 text-sm">{{ $item->name }}</h4>
                </div>
                <div class="text-right text-muted">
                  <small>{{ Carbon\Carbon::parse($item->responded_at)->diffForHumans() }}</small>
                </div>
              </div>
              <p class="text-sm text-muted mb-0">{{ $item->response }}</p>
            </div>
          </div>
        </span>

        @endforeach

      </div>
    @endif
 
    </div>
  </div>

@endsection

@section('main-content')

@endsection

@section('scripts')
<script>
  window.onload=function(){
  $("#btnLoginMain").click();
  }
  </script>
@endsection



