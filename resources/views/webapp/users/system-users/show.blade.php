@extends('templates.webapp-new.dashboard')

@section('title', 'User')

@section('sidebar')
   

@endsection

@section('css')

@endsection

@section('welcome')

<h1 class="text-white">Show user</h1>


@endsection

@section('content')
      {{-- <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">{{ $user->name }}</h1>
      </div> --}}

      <div class="row">
        <div class="table-responsive text-nowrap">
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
                <th>Property</th>
                <td>{{ $user->property.' '.$user->type }}</td>
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
           
        </table>
          @endforeach
        </div>
    </div>
    

   
      <hr>
      <div class="row">
        
       
      
         <div class="col">
        
            <a href="/property/all/" class="btn btn-primary btn-user btn-block"><i class="fas fa-home"></i> Home </a>
        
        </div>

        <div class="col">
        
            <a href="/user/all" class="btn btn-primary btn-user btn-block"> <i class="fas fa-users"></i> Users </a>
        
        
        </div>
        {{-- <div class="col">
          @foreach ($users as $user)
          <a href="/user/{{ $user->id }}/edit" class="btn btn-primary btn-user btn-block"> <i class="fas fa-user"></i> View </a>
      @endforeach
      
      </div> --}}
        <div class="col">

            <a href="/user/create" class="btn btn-primary btn-user btn-block"> <i class="fas fa-user-plus"></i> Users </a>
        
          </div>

      </div>
  

@endsection

@section('scripts')

@endsection



