@extends('layouts.material.template')

@section('title', $user->name)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
         
      <div class="col-lg-12 col-md-12">
        <div class="card">
       
          <div class="card-body table-responsive">
           
<form id="editPropertyForm" action="/dev/user/{{ $user->id }}/" method="POST">
  @method('put')
  @csrf


<div class="row">
  <div class="col">
      <label>Name</label>
      <input form="editPropertyForm" class="form-control" type="text" name="name" value="{{ $user->name }}" >
  </div>
</div>
<br>
<div class="row">
  <div class="col">
      <label>Email</label>
      <input form="editPropertyForm" class="form-control" type="email" name="email" value="{{ $user->email }}" >
  </div>
 
</div>
<br>
<div class="row">
  <div class="col">
      <label>Role</label>
      <select form="editPropertyForm" class="form-control" name="user_type" type="text" id="">
          <option value="{{ $user->user_type }}">{{ $user->user_type }}</option>
          <option value="admin">admin</option>
          <option value="ap">ap</option>
          <option value="billing">billing</option>
          <option value="dev">dev</option>      
          <option value="treasury">treasury</option>
      </select>
  </div>
</div>
<br>
<div class="row">
<div class="col">
    <label>Plan</label>
    <select form="editPropertyForm" class="form-control" name="account_type" type="text" id="">
        <option value="{{ $user->account_type }}">{{ $user->account_type }}</option>
        <option value="starter">starter</option>
        <option value="basic">basic</option>
        <option value="large">large</option>
        <option value="advanced">advanced</option>
        <option value="enterprise">enterprise</option>
    </select>
</div>
</div>
<br>
<div class="row">
<div class="col">
    <label>Password</label>
    <input form="editPropertyForm" class="form-control" type="password" name="password" >
</div>
</div>
<br>
<div class="row">
  <div class="col">
      <label>Email verified at</label>
      <input form="editPropertyForm" class="form-control" type="date" name="email_verified_at" value="{{ $user->email_verified_at? Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d'): null }}" >
  </div>
 
</div>
          <br>    
       <div class="row">
       <div class="col">
        <p class="text-right">   
         
          <button type="submit" form="editPropertyForm" class="btn btn-primary" > Update</button>
      </p>   
       </div>
      </div>  
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
@endsection
