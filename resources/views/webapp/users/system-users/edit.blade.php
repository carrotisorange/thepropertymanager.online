@extends('layouts.argon.dashboard')

@section('title', $user->name)


@section('css')

@endsection


@section('content')

<form id="editUserForm" action="/user/{{ $user->id }}/update" method="POST">
    @csrf
    @method('PUT')
</form>
      {{-- <div class="text-left">
        <h1 class="h4 text-gray-900 mb-4">Select a property for the new user</h1>
      </div> --}}

      <div class="row">
        
                        
        <div class="table-responsive text-nowrap">
            @if($users->count() <= 0 )
            <table class="table table-bordered table-condensed">
                <tr>  
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                 
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ $user->user_type }}</td>
                </tr>
                </tr>
                {{-- <tr>
                    <th>Created on</th>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('M d Y') }}</td>
                </tr> --}}
                
                    {{-- <tr>
                       
                      
                 
                        <th>Verified on</th>
             
                       
                        <td>{{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('M d Y'): ' ' }}</td>
                    </tr> --}}
                    <tr>
                        <th>Property</th>
                        <td>
                            @if($users->count() <= 0 )
                            <select form="editUserForm" name="property_id" id="property_id" required>
                               @foreach ($properties as $item)
                               <option value="{{ $item->property_id }}">{{ $item->name.' '.$item->type }}</option>
                               @endforeach
                            </select>
                            @else
                            {{ $item->name.' '.$item->type }}
                            @endif
                        </td>
                    </tr>
               
            </table>
            @else
            @endif
            @foreach ($users as $user)
            <table class="table table-bordered table-condensed">
                <tr>  
                    <th>Name</th>
                    <td><input form="editUserForm" type="text" name="name" value="{{ $user->name }}" class="col-md-8"></td>
                 
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input form="editUserForm" type="text" name="email" value="{{ $user->email }}" class="col-md-8"></td>
                </tr>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        <select form="editUserForm" name="user_type" id="" class="col-md-8">
                            <option value="{{ $user->user_type }}" selected>{{ $user->user_type }} (selected)</option>
                            <option value="admin">admin</option>
                            <option value="ap">ap</option>
                            <option value="billing">billing</option>
                            <option value="manager">manager</option>
                            <option value="treasury">treasury</option>
                           
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Property</th>
                    <td>
                        {{-- @if($user->property === null) --}}
                        <select form="editUserForm" name="property_id" id="property_id" class="col-md-8" required>
                            {{-- <option value="{{ $user->property_id }}" selected>{{ $user->name }} (selected)</option> --}}
                           @foreach ($properties as $item)
                           <option value="{{ $item->property_id }}">{{ $item->name.' '.$item->type }}</option>
                           @endforeach
                        </select>
                        {{-- @else
                            {{ $user->property.' '.$user->type }}
                        @endif --}}
                    </td>
                </tr>

                {{-- <tr>
                    <th>Created on</th>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('M d Y') }}</td>
                </tr> --}}
                {{--   
                    <tr>
                       
                      
                 
                        <th>Verified on</th>
                        <td>
                            @if($user->email_verified_at == null)
                            <small title="unverified" class="text-danger"><i class="fas fa-exclamation-triangle"></i> </small>

                            @else

                            {{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('M d Y'): ' ' }}
                            @endif
                        </td>
           
                       
                        <td>{{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('M d Y'): ' ' }}</td> 
                    </tr>--}}
                   
               
            </table>
            @endforeach
        </div>
    </div>
    <br>
      <div class="row">
        
        @if($users->count() <= 0 )

        <div class="col">

           <p class="text-right"> <button form="editUserForm" type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i>   Assign new user to the property</button></p>
        
          </div>
        @else
        <div class="col">
        
            <a href="/property/all/" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-home"></i> Go back to home </a>
        
        </div>
        <div class="col">
            <a href="/user/{{ $user->id }}" class="btn btn-primary btn-user btn-block btn-sm"> <i class="fas fa-eye"></i> Go back to users</a>

        </div>
        <div class="col">
        
            <button form="editUserForm" class="btn btn-primary btn-user btn-block btn-sm"><i class="fas fa-check"></i> Update user</button>
        
        </div>
        @endif
      
        
      </div>
  

@endsection

@section('scripts')

@endsection



