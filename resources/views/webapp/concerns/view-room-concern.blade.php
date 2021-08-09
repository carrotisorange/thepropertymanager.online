@extends('layouts.argon.main')

@section('title', 'View Concern')

@section('upper-content')

<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left"> 
        <h6 class="h2 text-dark d-inline-block mb-0">View Concern</h6>
    </div>
</div>
<form id="updateConcernForm" action="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/concern/{{ $concern->concern_id }}/update" method="POST">
    @csrf
    @method('PUT')
  </form>

  <div class="row">
    <div class="col-md-10 py-3 mx-auto">
      <div class="card">
        <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Reported on:</label>
          <input form="updateConcernForm" name="reported_at" class="form-control" type="date" value="{{ old('reported_at')? old('reported_at'): Carbon\Carbon::parse($concern->reported_at)->format('Y-m-d') }}" required>
          @error('reported_at')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="">Room:</label>
          <input form="updateConcernForm" value="{{ $room->building.' '.$room->unit_no }}" class="form-control" type="text" required readonly>
          <input form="updateConcernForm" name="concern_unit_id" value="{{ $room->unit_id }}" class="form-control" type="hidden" required readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="">Reported by:</label>
            <select form="updateConcernForm" class="form-control" name="concern_tenant_id">
                <option value="{{ old('concern_tenant_id')? old('concern_tenant_id'): $tenant->tenant_id }}" selected>{{ $tenant->first_name.' '.$tenant->last_name }} </option>
                @foreach ($tenants as $item)
                    <option value="{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }} | {{ $item->contract_status }}</option>
                @endforeach
              </select>
              @error('concern_tenant_id')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="">Contact no:</label>
            <input name="contact_no" form="updateConcernForm" value="{{ old('contact_no')? old('contact_no'): $concern->contact_no }}" class="form-control" type="number" required>
            @error('contact_no')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="">Concern/Request:</label>
              <textarea form="updateConcernForm" name="details" cols="115%" rows="5" class="form-control">{{ old('details')? old('details'): $concern->details }}</textarea>
              @error('details')
                <small class="text-danger">
                  {{ $message }}
                </small>
              @enderror
            </div>
          
        
          </div>
         
          
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Urgency:</label>
          <select form="updateConcernForm" name="urgency" class="form-control" required>
            <option value="{{ old('urgency')? old('urgency'): $concern->urgency }}" selected>{{ old('urgency')? old('urgency'): $concern->urgency }}</option>
            <option value="emergency"> Emergency</option>
            <option value="major_concern"> Major Concern</option>
            <option value="minor_concern"> Minor Concern</option>
        
          </select>
          @error('urgency')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-3">
            <label for="">Warranty:</label>
            <select form="updateConcernForm" name="is_warranty" id="is_warranty" class="form-control" required>
                <option value="{{ old('is_warranty')? old('is_warranty'): $concern->is_warranty }}" selected>{{ old('is_warranty')? old('is_warranty'): $concern->is_warranty }}</option>
                <option value="yes"> Yes</option>
                <option value="no"> No</option>
             
              </select>
            @error('is_warranty')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>
          <div class="form-group col-md-3">
          <label for="">Scheduled on:</label>
          <input name="scheduled_at" form="updateConcernForm" value="{{ old('scheduled_at')? old('scheduled_at'): Carbon\Carbon::parse($concern->scheduled_at)->format('Y-m-d') }}" class="form-control" type="date" required>
          @error('scheduled_at')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
        <div class="form-group col-md-3">
            <label for="">Endorsed to:</label>
            <select form="updateConcernForm" class="form-control" name="concern_user_id">
                <option value="{{ old('concern_user_id')? old('concern_user_id'): $endorsed_to->id }}">{{ old('concern_user_id')? old('concern_user_id'): $endorsed_to->name }}</option>
                @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
              @error('concern_user_id')
              <small class="text-danger">
                {{ $message }}
              </small>
            @enderror
          </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="">Course of action taken:</label>
          <textarea form="updateConcernForm" name="action_taken" cols="115%" rows="5" class="form-control">{{ old('concern_user_id')? old('action_taken'): $concern->action_taken }}</textarea>
          @error('action_taken')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>
      </div>

        <div class="form-row">
            
            <div class="form-group col-md-3">
                <label for="">Resolved by:</label>
                <select form="updateConcernForm" class="form-control" name="resolved_by">
                    <option value="{{ old('resolved_by')? old('resolved_by'): $resolved_by->id }}">{{ old('resolved_by')? old('resolved_by'): $resolved_by->name }}</option>
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                  @error('resolved_by')
                  <small class="text-danger">
                    {{ $message }}
                  </small>
                @enderror
              </div>
              
              <div class="form-group col-md-3">
                <label for="">Status:</label>
                <select form="updateConcernForm" id="status" name="status" class="form-control" required>
                  <option value="{{ old('status')? old('status'): $concern->status }}" selected>{{ old('status')? old('status'): $concern->status }}</option>
                  <option value="pending">pending</option>
                  <option value="active">active</option>
                  <option value="closed">closed</option>
                </select>
              @error('status')
                <small class="text-danger">
                  {{ $message }}
                </small>
              @enderror
              </div>

              <div class="form-group col-md-3">
                <label for="">Resolved on:</label>
                <input name="resolved_at" form="updateConcernForm" value="{{ old('resolved_at')? old('resolved_at'): Carbon\Carbon::parse($concern->resolved_at)->format('Y-m-d') }}" class="form-control" type="date" required>
              @error('resolved_at')
                <small class="text-danger">
                  {{ $message }}
                </small>
              @enderror
              </div>

              <div class="form-group col-md-3">
                <label for="">Rating:</label>
                <select form="updateConcernForm" id="rating" name="rating" class="form-control" required>
                  <option value="{{ old('rating')? old('rating'): $concern->rating }}" selected>{{ old('rating')? old('rating'): $concern->rating }}</option>
                  <option value="very poor">very poor</option>
                  <option value="satisfactory">satisfactory</option>
                  <option value="average">average</option>
                  <option value="superior">superior</option>
                  <option value="somewhat unsatisfactory">somewhat unsatisfactory</option>
                </select>
              @error('rating')
                <small class="text-danger">
                  {{ $message }}
                </small>
              @enderror
              </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="">Remarks:</label>
              <textarea form="updateConcernForm" name="remarks" cols="115%" rows="5" class="form-control">{{ old('remarks')? old('remarks'): $concern->remarks }}</textarea>
              @error('remarks')
                <small class="text-danger">
                  {{ $message }}
                </small>
              @enderror
            </div>
          </div>
          <div class="col-lg-6 text-left"> 
            <h6 class="h2 text-dark d-inline-block mb-0">Materials used</h6>
        </div>
          <div class="form-row">
            <table class="table">
                <?php $ctr = 1; ?>
                <thead>
                    <th>#</th>
                    <th>Material</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </thead>
                @foreach ($materials as $item)
                <tbody>
                <tr>
                  <th>{{ $ctr++ }}</th>
                  <td>{{ $item->description }}</td>
                  <td>{{ $item->price }}</td>
                  <td>{{ $item->quantity}}</td>
                  <td>{{ $item->total_cost }}</td>
                  <th></th>
                  {{-- <td><a class="text-danger" href="/material/{{ $item->material_id }}/delete"><i class="fas fa-times"></i> Remove</a></td> --}}
                </tr>
                </tbody>
                
                @endforeach 
                <tr>
               <th>Total</td>
               <td></td>
               <td></td>
               <td></td>
               <th>{{ number_format($materials->sum('total_cost'),2) }}</th>
              <th></th>
               </tr>
  
            </table>
  
        </div>
    
      </div>
    
      <div class="form-group col-md-11 mx-auto">
        <button type="submit" form="updateConcernForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Save</button>
        <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/room/{{ $room->unit_id }}/#concerns">Cancel</a>
        </p>
    </div>
    </div>

      <div class="row">
        <div class="col">
       
          <h6 class="h2 text-dark d-inline-block mb-0">Communications</h6>

         
         </div>
       </div>
      {{-- <br>
     @if($responses->count() <= 0)
       <p class="text-center text-danger">No responses found!</p>
     @else --}}
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
    
                        <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </small>
                       
                        
                      </div>
                    </div>
                    <p class="text-sm text-muted mb-0"> {!! $item->response !!}</p>
                   
                  </div>
                </div>
              </span>
    
              @endforeach
    
            </div>
            <br>
       
      </div>
      
    </div>

    <p class="text-center">      <a href="#" data-toggle="modal" data-target="#addResponse"><i class="fas fa-plus"></i> Response</a> </p>
          
      
      
    </div>
  </div>

  <div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content  text-center">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Response</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <form action="/concern/{{ $concern->concern_id }}/response" method="POST">
            @csrf
            <input type="hidden" name="concern_id" value={{ $concern->concern_id }}>
      
            <textarea class="form-control" name="response" id="" cols="30" rows="8" placeholder="type your response here..."></textarea required>
          
      
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"> Submit</button>
        </form>
        </div>
    </div>
    </div>
  
  </div>
    
@endsection

@section('scripts')

@endsection



