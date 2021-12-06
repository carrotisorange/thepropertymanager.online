@extends('layouts.argon.main')

@section('title', 'Edit Bills')


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
<form id="editBillsForm" action="/property/{{Session::get('property_id')}}/bills/update"
    method="POST">
    @csrf
    @method('PUT')
</form>
<h6 class="h2 text-dark d-inline-block mb-0">This message will appear at the bottom of every exported Statement of Accounts.</h6>
<br><br>
<textarea form="editBillsForm" class="form-control" name="footer_message" id="" cols="20" rows="20">
  {{ $footer->footer_message }}
  </textarea>
<br>
<div class="row">
    <div class="col-md-12">
        <button form="editBillsForm" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Update</button>
        <br>
        <p class="text-center">
            <a class="text-center text-dark" href="/property/{{ Session::get('property_id') }}/bills"><i class="fas fa-times"></i> Cancel</a>
        </p>
    </div>
</div>
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