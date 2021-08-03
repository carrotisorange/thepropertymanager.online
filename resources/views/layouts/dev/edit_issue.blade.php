@extends('layouts.material.template')

@section('title', 'Issue #: '.$issue->issue_id)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
         
      <div class="col-lg-12 col-md-12">
        <div class="card">
       
          <div class="card-body table-responsive">
            <div class="row">
              <div class="col-md-12">
                <form id="editPropertyForm" action="/dev/issue/{{ $issue->issue_id }}/update" method="POST">
                  @method('put')
                  @csrf
              
              <div class="row">
                  <div class="col">
                      <label>Status</label>
                      <select form="editPropertyForm" class="form-control" name="status" type="text" id="">
                          <option value="{{ $issue->status }}">{{ $issue->status }}</option>
                          <option value="closed">closed</option>
                          <option value="active">active</option>
                      </select>
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col">
                      <label>Details</label>
                      <textarea form="editPropertyForm" rows="4" cols="50" class="form-control" name="details">{{ $issue->details }}</textarea>
                  </div>
                 
              </div>
              <br>
              
                      
                       <div class="row">
                       <div class="col">
                        <p class="text-right">   
                         
                          <button type="submit" form="editPropertyForm" class="btn btn-primary" > Update Issue</button>
                      </p>   
                       </div>
                      </div>  
              </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
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
                <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Add Response </button>
              </p>
              </form>
              </div>
            </div>
              <div class="row">
              <div class="col-md-12">
            
            
             
                      <div class="list-group list-group-flush">
                          @foreach ($responses as $item)
                       
                          <a href="#/" class="list-group-item list-group-item-action">
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
                          </a>
                
                          @endforeach
                
                        </div>
              </div>
              </div>
            
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
@endsection
