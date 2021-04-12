@extends('webapp.tenant_access.template')

@section('title', 'Concerns')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>
    
  </div>
  <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus"></i> Report Concern</a>  
  </div>
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
    <table class="table table-bordered table-condensed">
      <?php $ctr = 1; ?>
      <thead>
        <tr>
          <th>#</th>
          
            <th>Date Reported</th>
           
          
           <th>Category</th>
            <th>Title</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Assigned to</th>
            <th>Rating</th>
            <th></th>
            {{-- <th>Feedback</th> --}}
          
       </tr>
      </thead>
      <tbody>
        @foreach ($all_concerns as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
       
          <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
            
        <td>{{ $item->category }}</td>
          
            <th>{{ $item->title }}</th>
            <td>
                @if($item->urgency === 'urgent')
                <span class="badge badge-danger">{{ $item->urgency }}</span>
                @elseif($item->urgency === 'major')
                <span class="badge badge-warning">{{ $item->urgency }}</span>
                @else
                <span class="badge badge-primary">{{ $item->urgency }}</span>
                @endif
            </td>
            <td>
              @if($item->concern_status === 'pending')
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
              @elseif($item->concern_status === 'active')
              <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
              @else
              <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
              @endif
            </td>
            <?php $explode = explode(" ", $item->name );?>
           
            <td>{{ $item->name? $explode[0]: 'NULL' }}</td>
            <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
            <th><a class="btn btn-primary btn-sm" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concern/{{ $item->concern_id }}/responses"><i class="fas fa-eye"></i></a></th>
            {{-- <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td> --}}
        </tr>
        @endforeach
      </tbody>
    </table>
   
  </div>
       
                {{-- Modal for renewing tenant --}}
                <div class="modal fade" id="addConcern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Concern Information</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form id="concernForm" action="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concerns" method="POST">
                                {{ csrf_field() }}
                            </form>
  
                            <input type="hidden" form="concernForm" id="tenant_id" name="tenant_id" value="{{ $tenant->tenant_id }}"required>
                            <input type="hidden" form="concernForm" id="unit_tenant_id" name="unit_tenant_id" value="{{ $tenant->unit_tenant_id }}"required>
{{--   
                            <div class="row">
                              <div class="col">
                                  <label>Date Reported</label>
                                  <input type="date" form="concernForm" class="form-control" name="reported_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
                              </div>
                          </div>
                          <br> --}}
                          <div class="row">
                            <div class="col">
                                <label>Title</label>
                              
                                <input type="text" form="concernForm" class="form-control" name="title" placeholder="Uncessary charges to my account" required >
                            </div>
                          </div>  
                          
                          <br>
                            <div class="row">
                                <div class="col">
                                   <label>Category</label>
                                    <select class="form-control" form="concernForm" name="category" id="" required>
                                      <option value="" selected>Please select one</option>
                                      <option value="billing">billing</option>
                                      <option value="employee">employee</option>
                                      <option value="internet">internet</option>
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
                                  <select class="form-control" form="concernForm" name="urgency" id="" required>
                                    <option value="" selected>Please select one</option>
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
                                  <label>Details <span class="text-danger">(Make it as explicit as possible)</span></label>
                                  
                                  <textarea form="concernForm" rows="7" class="form-control" name="details" required></textarea>
                              </div>
                          </div>
                          <br>
                         {{-- <div class="row">
                            <div class="col">
                                <label for="movein_date">Assign concern to</label>
                                <select class="form-control" form="concernForm" name="concern_user_id">
                                  <option value="" selected>Please select one</option>
                                  
                                  @foreach($users as $item)
                                      <option value="{{ $item->id }}" selected> {{ $item->user_type }}</option>
                                  @endforeach
                                 
                                </select>
                            </div>
                        </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="submit" form="concernForm" class="btn btn-primary"> Report Concern</button>
                        </div>
                    </div>
                    </div>
                </div>
     
@endsection

@section('scripts')
  
@endsection



