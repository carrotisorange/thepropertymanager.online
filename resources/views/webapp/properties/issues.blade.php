@extends('layouts.argon.main')

@section('title', 'Issues')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Issues</h6>
    
  </div>

</div>
<div class="row">
  <div class="col">

      

        <form action="/property/{{Session::get('property_id')}}/issue/create" method="POST">
          @csrf
      
    
          <textarea  class="form-control form-control-user @error('details') is-invalid @enderror" name="details" id="" cols="30" rows="3" placeholder="I just created 3 rooms but it is not showing on the rooms page..."></textarea required>
          
            @error('details')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
      
        <br>
      <p class="text-right">
        {{-- <a href="/property/{{Session::get('property_id')}}/issues" class="btn btn-danger"> Clear Field</a> --}}
        <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Post Issue </button>
      </p>
      </form>
    
  
  </div>
</div>

<div class="row">
  <div class="col">
    
      <h6 class="h2 text-dark d-inline-block mb-0">Other issues ({{ $issues->count() }})</h6>
      <br><br>

     
    
      
            <div class="list-group list-group-flush">
                @foreach ($issues as $item)
             
                <a href="/property/{{ Session::get('property_id') }}/issue/{{ $item->issue_id }}" class="list-group-item list-group-item-action">
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
                          <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                        </div>
                      </div>
                      <p class="text-sm text-muted mb-0">{{ $item->details }}</p>
                    </div>
                  </div>
                </a>
      
                @endforeach
      
              </div>
      
 
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



