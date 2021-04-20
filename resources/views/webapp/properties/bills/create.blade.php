@extends('layouts.argon.dashboard')

@section('title', 'Step 3 of 5 | The Property Manager')
@section('title-page')
<div class="row">
  <div class="col">
    <h2 class="text-left"><i class="fas fa-file-invoice-dollar"></i> Bills</h2>
  </div>
  <div class="col">
    <h3 class="text-right">Step 3 of 5</h3>
  </div>
</div>
@endsection

@section('content')
<form class="user" method="POST" action="/property/{{ Session::get('property_id') }}/bills/store">
  @csrf
  <div class="form-group">
    <label for="">Select all the bills that apply to your property</label>
    {{-- <select name="type" id="type" class="form-control form-control-user @error('type') is-invalid @enderror" required autocomplete="type" autofocus> --}}
    
    {{-- @if (old('type'))
      <option value="{{ old('type') }}" selected>{{ old('type') }}</option>
      @foreach ($property_types as $item)
      <option value="{{ $item->property_type_id }}">{{ $item->property_type }}</option>
   @endforeach
      
  
      @else --}}


        @foreach ($particulars as $item)
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="particulars[]" value="{{ $item->particular_id }}">
          <label class="form-check-label" for="exampleRadios1">
            <b>{{ $item->particular }} </b> - {{ $item->description }}
          </label>
        </div>
    
     @endforeach
        
     @error('property_type_id')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
 @enderror


    {{-- @endif --}}
     
    {{-- </select>
          @error('type')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror --}}
  </div>

  {{-- <div class="row">
    <div class="col">
        <p class="text-right">
          <a href="#/"  id="add_entry" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add new row </a>   
        <a  href="#/" id='delete_entry' class="btn btn-danger btn-sm"><i class="fas fa-minus"></i> Remove current row </a>
       
        <button id="savebutton" form="addPayableEntryForm" type="submit" class="btn btn-success btn-sm" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i>Save bills (<span id="current_no_of_entry">0</span>)</button>
        </p>
           
        <div class="modal-body">
   
            <form id="addPayableEntryForm" action="/property/{{Session::get('property_id')}}/payable" method="POST">
              @csrf
           </form>
     
        
                 <div class="table-responsive">
                 <table class = "table table-bordered table-hover" id="tab_logic">    
                   <thead>
                     <tr>
                       <th>#</th>
                       <th>Bill</th>
                       {{-- <th>Particular</th>
                       <th>Added on</th> 
                     </thead>
                   </tr>
                       <input form="addPayableEntryForm" type="hidden" id="no_of_entry" name="no_of_entry" >
    
                       <input form="addPayableEntryForm" type="hidden" id="" name="property_id"  value="{{Session::get('property_id')}}">
                   <tr id='addr1'></tr>
                 
                 </table>
               </div>
             
    
          </div>
    </div>
</div> --}}
    
  <div class="row">
    {{-- <div class="col">
      <p class="text-left">
        <a href="/property/all" class="btn btn-primary"><i class="fas fa-home"></i> Home</a>
      </p>
     </div> --}}

     <div class="col">
      <p class="text-right">
        <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Next</button>
      </p>
     </div>
   </div>
</form>  
            
@endsection

@section('scripts')

@endsection

