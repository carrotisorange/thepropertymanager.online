@extends('layouts.argon.main')

@section('title',  $user->name )

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ Auth::user()->name }}</h6>
    
  </div>

</div>
  
<div class="row">
  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fas fa-user fa-sm text-primary-50"></i> Profile</a>
        <a class="nav-item nav-link" id="nav-property-tab" data-toggle="tab" href="#property" role="tab" aria-controls="nav-property" aria-selected="false"><i class="fas fa-home fa-sm text-primary-50"></i> Properties</a>
        <a class="nav-item nav-link" id="nav-referrals-tab" data-toggle="tab" href="#referrals" role="tab" aria-controls="nav-referrals" aria-selected="false"><i class="fas fa-swimmer fa-sm text-primary-50"></i> Referrals</a>
        <a class="nav-item nav-link" id="nav-concerns-tab" data-toggle="tab" href="#concerns" role="tab" aria-controls="nav-concerns" aria-selected="false"><i class="fas fa-tools fa-sm text-primary-50"></i> Concerns</a>
        <a class="nav-item nav-link" id="nav-session-tab" data-toggle="tab" href="#session" role="tab" aria-controls="nav-session" aria-selected="false"><i class="fas fa-sign-in-alt fa-sm text-primary-50"></i> Sessions</a>
        <a class="nav-item nav-link" id="nav-session-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="nav-settings" aria-selected="false"><i class="fas fa-user-cog fa-sm text-primary-50"></i> Settings</a>
      </div>
    </nav>
  </div>
</div>

<div class="row">
 <div class="col-md-12">
  <div class="tab-content" id="nav-tabContent">
    
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
      
      <br>
        <div class="col-md-12 mx-auto">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>Role</th>
                <td>{{ $user->user_type }}</td>
              </tr>
              <tr>
                <th>Plan</th>
                <td>{{ $user->account_type }}</td>
              </tr>
            </table>
      </div>
        </div>
    </div>
    <div class="tab-pane fade" id="property" role="tabpanel" aria-labelledby="nav-property-tab">
      <br>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
          <tr>
            <?php $ctr = 1; ?>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Ownership</th>
            <th>Mobile</th>
            <th>Address</th>
            <th></th>
          </tr>
          </thead>
          @foreach ($properties as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <td>{{ $item->name }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->ownership }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->address.', '.$item->country.', '.$item->zip }}</td>
            <th><a href="/property/{{ Session::get('property_id') }}/edit" class="btn btn-sm btn-primary"> Edit</a></th>
          </tr>
          @endforeach
      </table>
      </div>    

     
    </div>
    <div class="tab-pane fade" id="session" role="tabpanel" aria-labelledby="nav-session-tab">  
      <br>
      {{-- <p>Current usage time: 12123</p> --}}
      
   <div class="row">
              <div class="col">
               
                <div class="alert alert-danger alert-dismissable custom-danger-box">
                  
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                   
                        <strong><i class="fas fa-exclamation-triangle"></i> Don't forget to logout your account to record your usage time. </strong>
                      
                    
                </div>
            
              </div>
            </div>
            
      <div class="col-md-12 mx-auto">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <?php $ctr = 1; ?>
            <thead>
            <tr>
              <th>#</th>  
              <th>Date</th>
              <th>IP Address</th>
              <th>Location</th>
              <th>Login at</th>
              <th>Logout at</th>
              <th>Usage time</th>
            </tr>
          </thead>
            @foreach ($sessions as $item)
              <tr>
               <th>{{ $ctr++ }}</th>
               <td>{{ Carbon\Carbon::parse($item->session_last_login_at)->format('M d Y') }}</td>
                <td>{{ $item->session_last_login_ip }}</td>
                <td>{{ $item->location }}</td>
               <td>{{ $item->session_last_login_at? Carbon\Carbon::parse($item->session_last_login_at)->toTimeString() : null }}</td>
               <td>{{ $item->session_last_logout_at? Carbon\Carbon::parse($item->session_last_logout_at)->toTimeString() : null }}</td>
               <td>
                 @if($item->session_last_logout_at == null)
                  0.0 hours
                 @else
                 {{  number_format(Carbon\Carbon::parse($item->session_last_login_at)->DiffInHours(Carbon\Carbon::parse($item->session_last_logout_at)),1) }} hours
                 @endif


                </td>
               
               
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="concerns" role="tabpanel" aria-labelledby="nav-concerns-tab">  
   <br>

      <div class="col-md-12 mx-auto">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <?php $ctr = 1; ?>
            <thead>
            <tr>
              <th>#</th>  
              <th>Concern ID</th>
              <th>Category</th>
              <th>Title</th>
              <th>Urgency</th>
              <th>Status</th>
              <th>Rating</th>
              <th>Feedback</th>
            </tr>
          </thead>
            @foreach ($concerns as $item)
              <tr>
               <th>{{ $ctr++ }}</th>
               <td>{{ $item->concern_id }}</td>
               <td>
              
                {{ $item->category }}
                
            </td>
            <td ><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></td>
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
                @if($item->status === 'pending')
                <span class="badge badge-warning">{{ $item->status }}</span>
                @elseif($item->status === 'active')
                <span class="badge badge-primary">{{ $item->status }}</span>
                @else
                <span class="badge badge-success">{{ $item->status }}</span>
                @endif
            </td>
  
            <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
            <td>{{ $item->feedback? $item->feedback : 'NULL' }}</td>
               
               
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="referrals" role="tabpanel" aria-labelledby="nav-referrals-tab">  
      <br>
   
         <div class="col-md-12 mx-auto">
           <div class="table-responsive text-nowrap">
             <table class="table">
               <?php $ctr = 1; ?>
               <thead>
               <tr>
                 <th>#</th>  
                 <th>Contract ID</th>
              
                 <th>Movein</th>
                 <th>Moveout</th>
               
                 <th>Term</th>
                 <th>Source</th>
               </tr>
             </thead>
               @foreach ($referrals as $item)
                 <tr>
                  <th>{{ $ctr++ }}</th>
                  
                    <td>{{ $item->contract_id }}</td>
                    
                    <td>{{ Carbon\Carbon::parse( $item->movein_at)->format('M d, Y') }}</td>
                    <td>{{ Carbon\Carbon::parse( $item->moveout_at)->format('M d, Y') }}</td>
                 
                    <td>{{ $item->term }}</td>
                    <td>{{ $item->form_of_interaction }}</td>
                 </tr>
               @endforeach
             </table>
           </div>
         </div>
       </div>

    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="nav-settings-tab">  
      <br><br>
      <div class="col-md-11 mx-auto">
        <form id="editUserForm" action="/property/{{Session::get('property_id')}}/user/{{ $user->id }}" method="POST">
          @method('put')
          @csrf
        </form>
          <small>Name</small>
          <input form="editUserForm" id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" >
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          <br>
          <small>Email</small>
          <input form="editUserForm" id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          <br>
          <small>New Password</small>
          <input form="editUserForm" id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" autocomplete="password">
                <small class="text-danger">Changing your password will log you out of the application.</small>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          <p class="text-right">
            <button form="editUserForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?');"> Update</button>
          </p>

          <br>
          {{-- @if(Auth::user()->user_type === 'manager')
          <small>Warning: Account deletion can't be undone. </small>
          <br>
          <form action="/users/{{ $user->id }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="col-md-3 btn btn-danger btn-user btn-block" id="registerButton" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;">
              <i class="fas fa-trash fa-sm text-white-50"></i> Delete
            </button>
          </form>
          @endif --}}
         
      </div>
    </div>

  </div>
 </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



