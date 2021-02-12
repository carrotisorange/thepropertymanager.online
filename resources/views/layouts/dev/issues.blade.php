@extends('layouts.material.template')

@section('title', 'Tasks')
@section('content')
<div class="content">
  <div class="container-fluid">
 <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="card">
          
      
            <div class="list-group list-group-flush">
              @foreach ($issues as $item)
           
              <span class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                  @if($item->issue_status === 'closed')
                  <i class="fas fa-check-circle text-success"></i>
                  @else
                  <i class="fas fa-clock text-warning"></i>
                  @endif
                  </div>
                  <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">{{ $item->name }} ({{ $item->responses }})</h4>
                      </div>
                      <div class="text-right text-muted">
    
                        <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </small>
                       
                        
                      </div>
                    </div>
                    <p class="text-sm text-muted mb-0"><a href="/dev/issue/{{ $item->issue_id }}/edit">{{ $item->details }}</a></p>
                   
                  </div>
                </div>
              </span>
    
              @endforeach
    
            </div>
      
        </div>
      </div>
    </div>
  </div>
@endsection
