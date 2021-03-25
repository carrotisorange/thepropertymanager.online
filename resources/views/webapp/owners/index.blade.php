@extends('layouts.argon.main')

@section('title', 'Owners')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-12">
    <h6 class="h2 text-dark d-inline-block mb-0">Owners</h6>
    
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <form  action="/property/{{Session::get('property_id')}}/owners/search" method="GET" >
      @csrf
      <div class="input-group">
          <input type="text" class="form-control" name="owner_search" placeholder="enter name..." value="{{ Session::get('owner_search') }}">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
      </div>
  </form>
  </div>

</div>
<br>
@if($owners->count() <=0 )
<p class="text-danger text-center">No owners found!</p>

@else
Showing <b>{{ $owners->count() }} </b> of {{  $count_owners }}  owners
 @if(Session::get('owner_search'))
<p class="text-center"> <span class=""> <small> you searched for </small></span> <span class="text-danger">"{{ Session::get('owner_search') }}"<span></p>
@endif 
<div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

    <table class="table table-condensed table-bordered table-hover">
        <thead>
          <?php $ctr=1; ?>
            <tr>
              <th>#</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Representative</th>
               {{-- <th></th> --}}
           </tr>
        </thead>   
           <tbody>
           @foreach ($owners as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <th><a href="/property/{{Session::get('property_id')}}/owner/{{ $item->owner_id }}">{{ $item->name }} </a></th>
            <td>{{ $item->email}}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->representative }}</td>
            {{-- <td>
              @if(Auth::user()->user_type === 'manager')
              <form action="/property/{{Session::get('property_id')}}/owner/{{ $item->owner_id }}/delete" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt fa-sm text-white-50"></i></button>
              </form>
              @endif
            </td> --}}
          </tr>
           @endforeach
           </tbody>
    </table>
   
  </div>
  @endif
@endsection



@section('scripts')
  
@endsection



