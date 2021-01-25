@extends('layouts.argon.main')

@section('title',   $concern->details)

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
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{Session::get('property_name')}}
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
           <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Units</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Rooms</span>
              </a>
              @endif
            
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                 <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
               <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            @if(Session::get('property_type') === 'Apartment Rentals')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/remittances">
                <i class="fas fa-hand-holding-usd text-teal"></i>
                <span class="nav-link-text">Remittances</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>

            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">

  <div class="col-auto">
    <a href="/property/{{ $property->property_id }}/concerns" class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a> 
    
   
    <a href="#" data-toggle="modal" data-target="#addResponse" class="btn btn-primary"><i class="fas fa-plus text-white-50"></i> Response</a> 
  
    @if($concern->status != 'closed')
    <a href="#" data-toggle="modal" data-target="#editConcernDetails" class="btn btn-primary"><i class="fas fa-edit text-white-50"></i> Edit</a> 
    <a href="#" data-toggle="modal" data-target="#markAsCompleteModal" class="btn btn-success"><i class="fas fa-check-square text-white-50"></i> Mark as complete</a> 
    {{-- @else
    <a href="#" data-toggle="modal" data-target="#/" class="btn btn-success"><i class="fas fa-check text-white-50"></i> Closed</a>  --}}
    @endif

    <a href="#" data-toggle="modal" data-target="#addJobOrder" class="btn btn-primary"><i class="fas fa-plus text-dark-50"></i> Job order</a>  

  </div>


</div>


<div class="row">

  <div class="col">
    <h6 class="h2 text-dark d-inline-block mb-0">Concern # {{ $concern->concern_id}}: {{ $concern->details }}</h6>
    <br>
    <div class="table-responsive">
      @foreach ($concern_details as $concern)
          
   
      <table class="table">
        
        <tr>
          <th>Date Reported</th>
          <td>{{ Carbon\Carbon::parse($concern->reported_at)->format('M-d-Y') }}</td>
        </tr>
           <tr>
                <th>Reported by</th>
                <td><a target="_blank" href="/property/{{ $property->property_id }}/tenant/{{ $concern->concern_tenant_id }}/#concerns">{{ $concern->first_name.' '.$concern->last_name }}</a></td>
           </tr>  
           
          </tr>
          <tr>
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <th>Unit</th>
            @else
            <th>Room</th>
            @endif
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <td><a target="_blank" href="/property/{{ $property->property_id }}/unit/{{ $concern->unit_id }}/#concerns">{{ $concern->unit_no }}</a></td>
            @else
            <td><a target="_blank" href="/property/{{ $property->property_id }}/room/{{ $concern->unit_id }}/#concerns">{{ $concern->unit_no }}</a></td>
            @endif
           
            
           
          </tr>  
     
       <tr>
            <th>Category</th>
            <td>
              {{ $concern->category }}
            </td>
       </tr>
      
       <tr>
            <th>Urgency</th>
            <td>
              @if($concern->urgency === 'urgent')
              <span class="badge badge-danger">{{ $concern->urgency }}</span>
              @elseif($concern->urgency === 'major')
              <span class="badge badge-warning">{{ $concern->urgency }}</span>
              @else
              <span class="badge badge-primary">{{ $concern->urgency }}</span>
              @endif
            </td>
       </tr>
       <tr>
          <th>Status</th>
            <td>
              @if($concern->concern_status === 'pending')
              <i class="fas fa-clock text-warning"></i> {{ $concern->concern_status }}
              @elseif($concern->concern_status === 'active')
              <i class="fas fa-snowboarding text-primary"></i> {{ $concern->concern_status }}
              @else
              <i class="fas fa-check-circle text-success"></i> {{ $concern->concern_status }}
              @endif
            </td>
       </tr>
       <tr>
         <th>Assigned to</th>
         <td><a target="_blank" href="/property/{{ $property->property_id }}/user/{{ $concern->concern_user_id }}/#concerns">{{ $concern->name }}</a></td>
       </tr>
       
      
       <tr>
        <th>Rating</th>
        <td>{{ $concern->rating? $concern->rating.'/5' : 'NA' }}</td>
     </tr>
     <tr>
      <th>Feedback</th>
      <td>{{ $concern->feedback? $concern->feedback : 'NA' }}</td>
   </tr>
      
       </table>
       @endforeach
    </div>

   
  </div>
</div>


<hr>
<div class="row">
  <div class="col">
    <div class="col-lg-5">
      <h6 class="h2 text-dark d-inline-block mb-0">Responses ({{$responses->count()}})</h6>
      <br>
    </div>

   </div>
 </div>
<br>
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
  </div>
</div>


<div class="modal fade" id="editConcernDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Concern</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <form id="editConcernDetailsForm" action="/concerns/{{ $concern->concern_id }}" method="POST">
        @method('put')
        {{ csrf_field() }}
      </form>
      
      <div class="row">
          <div class="col">
              <label>Title</label>
              <input type="text" form="editConcernDetailsForm" class="form-control" name="title" value="{{ $concern->title }}" required>
          </div>
      </div>
      <br>
        <div class="row">
            <div class="col">
                <label>Date reported</label>
                <input type="date" form="editConcernDetailsForm" class="form-control" name="reported_at" value="{{ $concern->reported_at }}" required>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <label>Category</label>
                <select class="form-control" form="editConcernDetailsForm" name="category" id="" required>
                    <option value="{{ $concern->category }}" readonly selected class="bg-primary">{{ $concern->category }}</option>
                    <option value="billing">billing</option>
                    <option value="internet">internet</option>
                    <option value="employee">employee</option>
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
                <select class="form-control" form="editConcernDetailsForm" name="urgency" id="" required>
                    <option value="{{ $concern->urgency }}" readonly selected class="bg-primary">{{ $concern->urgency }}</option>
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
              <label>Details</label>
             <textarea form="editConcernDetailsForm" class="form-control" name="details" id="" cols="30" rows="10" required>
              {{ $concern->details }}
             </textarea>
          </div>
      </div>

      <br>
        <div class="row">
            <div class="col">
                <label>Assigned to</label>
                <select class="form-control" form="editConcernDetailsForm" name="concern_user_id" id="" required>
                    <option value="{{ $concern->concern_user_id }}" readonly selected class="bg-primary">{{ $concern->concern_user_id }}</option>
                    @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

      </div>
      <div class="modal-footer">

          <button form="editConcernDetailsForm" type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"> Update</button>
      </div>
  </div>
  </div>

</div>



<div class="modal fade" id="addJobOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add job order</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <form action="/property/{{ $property->property_id }}/concern/{{ $concern->concern_id }}/joborder" method="POST">
          @csrf

          <div class="row">
            <div class="col">
                <label>Date</label>
                <input type="date"  class="form-control" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
              <label>Personnel</label>
              {{-- <select  class="form-control r" name="personnel_id_foreign" id="personnel_id_foreign" required> --}}
              <select  class="form-control form-control-user @error('personnel_id_foreign') is-invalid @enderror" name="personnel_id_foreign" id="personnel_id_foreign" required>
                <option value="">Please select one</option>
                @foreach ($personnels as $item)
                    <option value="{{ $item->personnel_id }}">{{ $item->personnel_name }}</option>
                @endforeach
              </select>

              @error('personnel_id_foreign')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
      </div>
      <br>
      <div class="row">
        <div class="col">
            <label>Summary</label>
            <textarea  class="form-control form-control-user @error('summary') is-invalid @enderror" name="summary" id="" cols="30" rows="3" placeholder="enter the summary of the job order..."></textarea required>
              @error('summary')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
    </div>
         
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
          @foreach ($concern_details as $concern)
          How did <b>{{ $concern->name }}</b> handle the concern?

          @endforeach
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

  @foreach ($concern_details as $concern)
  
  <input form="markAsCompleteModalForm" type="hidden" name="id" value="{{ $concern->id }}">

  @endforeach

     
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

@section('main-content')

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



