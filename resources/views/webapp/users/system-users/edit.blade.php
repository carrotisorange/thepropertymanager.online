@extends('layouts.argon.dashboard')

@section('title', $user->name)

@section('sidebar')
   

@endsection

@section('css')

@endsection

@section('welcome')

<h1 class="text-white">Assign a property to the user</h1>


@endsection

@section('content')

<form id="editUserForm" action="/user/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')
</form>
      {{-- <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">{{ $user->name }}</h1>
      </div> --}}

      <div class="row">
        
                        
        <div class="table-responsive text-nowrap">
            @if($users->count() <= 0 )
            <table class="table">
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
                <tr>
                    <th>Created on</th>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('M d Y') }}</td>
                </tr>
                
                    <tr>
                       
                      
                 
                        <th>Verified on</th>
             
                       
                        <td>{{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('M d Y'): ' ' }}</td>
                    </tr>
                    <tr>
                        <th>Property</th>
                        <td>
                            @if($users->count() <= 0 )
                            <select form="editUserForm" class="form-control" name="property_id" id="property_id" required>
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
            <table class="table">
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
                <tr>
                    <th>Created on</th>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('M d Y') }}</td>
                </tr>
                
                    <tr>
                       
                      
                 
                        <th>Verified on</th>
             
                       
                        <td>{{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('M d Y'): ' ' }}</td>
                    </tr>
                    <tr>
                        <th>Property</th>
                        <td>
                            @if($user->property === null)
                            <select form="editUserForm" class="form-control" name="property_id" id="property_id" required>
                                <option value="">Please select property</option>
                               @foreach ($properties as $item)
                               <option value="{{ $item->property_id }}">{{ $item->name.' '.$item->type }}</option>
                               @endforeach
                            </select>
                            @else
                                {{ $user->property.' '.$user->type }}
                            @endif
                        </td>
                    </tr>
               
            </table>
            @endforeach
        </div>
    </div>
    

   
      <hr>
      <div class="row">
        
        @if($users->count() <= 0 )

        <div class="col">

            <button form="editUserForm" type="submit" class="btn btn-success btn-user btn-block"> Complete </button>
        
          </div>
        @else
        <div class="col">
        
            <a href="/property/all/" class="btn btn-primary btn-user btn-block"><i class="fas fa-home"></i> Home </a>
        
        </div>
        {{-- <div class="col">
            <a href="/user/{{ $user->id }}" class="btn btn-primary btn-user btn-block"> <i class="fas fa-user-circle"></i> User </a>

        </div> --}}
        @endif
      
        
      </div>
  

@endsection

@section('scripts')

@endsection



