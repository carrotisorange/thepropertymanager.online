@extends('layouts.argon.main')

@section('title', 'Options')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-12 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">Options - <span class="text-danger"> the values you set for each parameter will take affect on all the bills.</span></h6>
    </div>
</div>
<form id="optionForm" action="/property/{{ Session::get('property_id') }}/create/bill/{{ $particular->particular_id }}/batch/{{ $batch_no }}/options" method="POST">
    @csrf
    @method('PUT')
  </form>


  <div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                
                  <div class="form-group">
                    <label>Start</label>
                    <input form="optionForm" type="date" class="form-control" name="start" id="start" >
                    @error('start')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
                </div>

                      <div class="form-group">
                        <label>End</label>
                        <input form="optionForm" type="date" class="form-control" name="end" id="end" >
                        @error('end')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    </div>
        
                    <div class="form-group">
                        <label>Amount</label>
                        <input form="optionForm" type="number" step="0.01" class="form-control" name="amount" id="amount">
                        @error('amount')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    </div>
                  
                    <div class="form-group">
                        <button type="submit" form="optionForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Save</button>
                        <br>
                        <p class="text-center">
                            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/create/bill/{{ $particular->particular_id }}/batch/{{ $batch_no }}">Cancel</a>
                        </p>
                    </div>
            </div>
        </div>
      </div>
  </div>

@endsection

@section('scripts')

@endsection



