@extends('layouts.material.template')

@section('title', 'System Users')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
         
      <div class="col-lg-12 col-md-12">
        <div class="card">
       
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-primary">
                
                <th>Name@extends('layouts.material.template')

                  @section('title', 'Users')
                  @section('content')
                  <div class="content">
                    <div class="container-fluid">
                      <div class="row">
                           
                        <div class="col-lg-12 col-md-12">
                          <div class="card">
                         
                            <div class="card-body table-responsive">
                              <table class="table table-hover">
                                <thead class="text-primary">
                                  
                                  <th>Name</th>
                                  <th>Email</th>
                                
                                  <th>Role</th>
                                    <th>Plan</th>
                                  <th>Created at</th>
                                  <th>Verified at</th>
                           
                                </thead>
                                <tbody>
                                  @foreach ($users as $item)
                                  <tr>
                                 
                                    <td><a href="/dev/user/{{ $item->id }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->user_type }}</td>
                                    <td><a href="/dev/user/{{ $item->id }}/plans">{{ $item->account_type }}</a></td>
                                     <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
                                     <td>
                                       @if($item->email_verified_at == null)
                                       null
                                       @else
                                       {{ Carbon\Carbon::parse($item->email_verified_at)->format('M d Y').' '.Carbon\Carbon::parse($item->email_verified_at)->toTimeString() }}
                                       @endif
                                     </td>
                                  
                                    
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  @endsection
                  </th>
                <th>Email</th>
              
                <th>Role</th>
                  <th>Plan</th>
                <th>Created at</th>
                <th>Verified at</th>
         
              </thead>
              <tbody>
                @foreach ($users as $item)
                <tr>
               
                  <td><a href="/dev/user/{{ $item->id }}">{{ $item->name }}</a></td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->user_type }}</td>
                  <td><a href="/dev/user/{{ $item->id }}/plans">{{ $item->account_type }}</a></td>
                   <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y').' '.Carbon\Carbon::parse($item->created_at)->toTimeString() }}</td>
                   <td>
                     @if($item->email_verified_at == null)
                     null
                     @else
                     {{ Carbon\Carbon::parse($item->email_verified_at)->format('M d Y').' '.Carbon\Carbon::parse($item->email_verified_at)->toTimeString() }}
                     @endif
                   </td>
                
                  
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
@endsection
