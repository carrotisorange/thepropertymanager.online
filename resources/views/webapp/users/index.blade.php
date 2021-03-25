@extends('layouts.argon.main')

@section('title', 'Usage History')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Usage History</h6>
  </div>
</div>
<div class="table-responsive text-nowrap">
  <table class="table table-condensed table-bordered table-hover">
    <?php $ctr = 1; ?>
    <thead>
    <tr>
      <th>#</th>  
      <th>Name</th>
      <th>Role</th>

      <th>IP Address</th>
      <th>Login at</th>
      <th>Logout at</th>
      <th>Usage time</th>
      
    </tr>
    </thead>
    <tbody>
    @foreach ($sessions as $item)
      <tr>
       <th>{{ $ctr++ }}</th>
       <td>{{ $item->user_name }}</td>
       <td>{{ $item->user_type }}</td>
       
       
        <td>{{ $item->session_last_login_ip }}</td>
       <td>{{ $item->session_last_login_at? Carbon\Carbon::parse($item->session_last_login_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_login_at)->toTimeString() : null }}</td>
       <td>{{ $item->session_last_logout_at? Carbon\Carbon::parse($item->session_last_logout_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_logout_at)->toTimeString() : null }}</td>
       
     <td>
      @if($item->session_last_logout_at == null)
        0.0 hours
       @else
       {{  number_format(Carbon\Carbon::parse($item->session_last_login_at)->DiffInHours(Carbon\Carbon::parse($item->session_last_logout_at)),1) }} hours
       @endif
      </td>
      </tr>
    @endforeach
    </tbody>
  </table>

</div>
@endsection

@section('scripts')

@endsection



