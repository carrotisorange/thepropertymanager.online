@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)


@section('css')
 <style>
/*This will work on every browser*/
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>   
@endsection


@section('upper-content')
<br>
<form id="editBillsForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/update" method="POST">
  @csrf
  @method('PUT')
</form>
<h6 class="h2 text-dark d-inline-block mb-0">This message will appear at the bottom of the Statement of Accounts.</h6>
<br><br>
<textarea form="editBillsForm" class="form-control" name="note" id="" cols="20" rows="10">
  {{ Session::get('footer_message') }}
  </textarea> 
  <br>
  <a class="btn btn-secondary btn-sm" href="/property/{{ Session::get('property_id') }}/bills"><i class="fas fa-times"></i> Cancel</a>
  <button form="editBillsForm" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check"></i> Save</button>
@endsection

@section('main-content')

@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'note', {
      filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form',
  });
  </script>

@endsection



