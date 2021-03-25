@extends('layouts.argon.main')

@section('title', $unit->unit_no)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    {{-- <h6 class="h2 text-dark d-inline-block mb-0">{{ $tenant->first_name.' '.$tenant->last_name }}</h6> --}}
    
  </div>

</div>
{{-- 
@if(Auth::user()->user_type === 'manager') --}}
{{-- <a href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}#bills" class="btn btn-primary"><i class="fas fa-user fa-sm text-white-50"></i> {{ $tenant->first_name.' '.$tenant->last_name }}</a> --}}

<h6 class="h2 text-dark d-inline-block mb-0">{{ $unit->unit_no }}</h6>
{{-- @else
<a href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/billings" class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Bills</a>
@endif
 --}}


<div class="row">
  <div class="col-md-12">

    <form id="editBillsForm" action="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}/bills/update" method="POST">
      
      @csrf
      @method('PUT')
    </form>
    <p class="text-right">Statement of Accounts </p>
  @if($balance->count() <= 0)
    <p class="text-center text-danger">No bills found!</p>
    <hr>
  @else
 
  <div class="table-responsive text-nowrap">
    <table class="table">
      <?php $ctr=1; ?>
     <thead>
      <tr>
          <th class="text-center">#</th>
        
          <th>Bill No</th>
          <th>Particular</th>
          <th colspan="2">Period Covered</th>
          <th>Amount</th>
          <td></td>
        </tr>
     </thead>
      <?php
        $start_ctr = 1;
        $end_ctr = 1;
        $amount = 1;
        $billing_id_ctr =1;
      ?>
      @foreach ($balance as $item)
      <tr>
          <th class="text-center">{{ $ctr++ }}</th>
          <td>{{ $item->bill_no }} <input form="editBillsForm" type="hidden" name="billing_id_ctr{{ $billing_id_ctr++ }}" value="{{ $item->bill_id }}"></td>
        
          <td>{{ $item->particular }}</td>
          <td>
            <input form="editBillsForm" type="date" name="start_ctr{{ $start_ctr++ }}" value="{{ $item->start? Carbon\Carbon::parse($item->start)->format('Y-m-d') : null}}"> 
          </td>
          <td>
            <input form="editBillsForm"  type="date" name="end_ctr{{ $end_ctr++ }}" value="{{ $item->end? Carbon\Carbon::parse($item->end)->format('Y-m-d') : null }}">
          </td>
          <td><input form="editBillsForm" type="number" name="amount_ctr{{ $amount++ }}" step="0.01" value="{{  $item->balance }}"></td>
          <td>
            @if(Auth::user()->user_type === 'manager')

            <form action="/property/{{Session::get('property_id')}}/bill/{{ $item->bill_id }}" method="POST">
              @csrf
              @method('delete')
              <button title="archive this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
            </form>
            @endif
          </td>   
        </tr>
      @endforeach
      
  </table>
</div>
<hr>
  @endif
  <p>Message footer</p>
  <textarea form="editBillsForm" class="form-control" name="note" id="" cols="20" rows="10">
    {{ Auth::user()->note }}
    </textarea> 
    <br>
    <p class="text-right"><button form="editBillsForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" > Update</button> </p>
  </div>
  <br>
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



