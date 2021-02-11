@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-9 text-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#bills">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
     
        <li class="breadcrumb-item active" aria-current="page">Statement of Accounts</li>
      </ol>
    </nav>
    
    
  </div>
  <div class="col-md-3 text-right">
    <p class="text-right"><button form="editBillsForm" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" > Update Bills And Message</button> </p>
  </div>
</div>


<div class="row">
  <div class="col-md-12">
   
    <form id="editBillsForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}/bills/update" method="POST">
      @csrf
      @method('PUT')
    </form>
    {{-- <p class="text-right"> </p> --}}
    @if($balance->count() <=0)
    <p class="text-danger text-center">No bills found!</p>
    @else

    <div class="table-responsive text-nowrap">
      <table class="table">
        <?php $ctr=1; ?>
        <thead>
          <tr>
            <th class="text-center">#</th>
          
            <th>Bill No</th>
             <th>Room</th>
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
          $particular_ctr =1;
        ?>
        <tbody>
        @foreach ($balance as $item)
        @if($item->bill_status === 'deleted')
        <tr>
          <th class="text-center">{{ $ctr++ }}</th>
          <th>
     
       <strike>
        {{ $item->bill_no }} <input form="editBillsForm" type="hidden" name="billing_id_ctr{{ $billing_id_ctr++ }}" value="{{ $item->bill_id }}">
       </strike>
       
      </th>
          <td>{{$item->unit_no}}</td>
          <td>
            <select class="form-control" form="editBillsForm" name="particular_ctr{{ $particular_ctr++ }}" required>
              <option value='{{ $item->particular }}' selected>{{ $item->particular }}</option>
              <option value='Advance Rent'>Advance Rent</option>
              <option value='Electric'>Electric</option>
              <option value='Rent'>Rent</option>
              <option value='Security Deposit (Rent)'>Security Deposit (Rent)</option>
              <option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option>
              <option value='Surcharge'>Surcharge</option>
              <option value='Water'>Water</option>
            </select>
          </td>
          <td>
            <input class="form-control" form="editBillsForm" type="date" name="start_ctr{{ $start_ctr++ }}" value="{{ $item->start? Carbon\Carbon::parse($item->start)->format('Y-m-d') : null}}"> 
          </td>
          <td>
            <input class="form-control" form="editBillsForm"  type="date" name="end_ctr{{ $end_ctr++ }}" value="{{ $item->end? Carbon\Carbon::parse($item->end)->format('Y-m-d') : null }}">
          </td>
          <td><input class="form-control" form="editBillsForm" type="number" name="amount_ctr{{ $amount++ }}" step="0.01" value="{{  $item->balance }}"></td>
          <td>
            @if(Auth::user()->user_type === 'manager')
            @if($item->bill_status === 'deleted')
            <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/restore" method="POST">
              @csrf
              @method('put')
              <button title="restore this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-restore fa-sm text-white-50"></i></button>
            </form>
            @else
            <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/delete" method="POST">
              @csrf
              @method('delete')
              <button title="remove this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
            </form>
            @endif
            
            @endif
          </td>   
        </tr>
        @else
        <tr>
          <th class="text-center">{{ $ctr++ }}</th>
          <th>
     
         {{ $item->bill_no }} <input form="editBillsForm" type="hidden" name="billing_id_ctr{{ $billing_id_ctr++ }}" value="{{ $item->bill_id }}">
       
          </th>
          <td>{{$item->unit_no}}</td>
          <td>
            <select class="form-control" form="editBillsForm" name="particular_ctr{{ $particular_ctr++ }}" required>
              <option value='{{ $item->particular }}' selected>{{ $item->particular }}</option>
              <option value='Advance Rent'>Advance Rent</option>
              <option value='Electric'>Electric</option>
              <option value='Rent'>Rent</option>
              <option value='Security Deposit (Rent)'>Security Deposit (Rent)</option>
              <option value='Security Deposit (Utilities)'>Security Deposit (Utilities)</option>
              <option value='Surcharge'>Surcharge</option>
              <option value='Water'>Water</option>
            </select>
          </td>
          <td>
            <input form="editBillsForm" class="form-control" type="date" name="start_ctr{{ $start_ctr++ }}" value="{{ $item->start? Carbon\Carbon::parse($item->start)->format('Y-m-d') : null}}"> 
          </td>
          <td>
            <input form="editBillsForm"  class="form-control" type="date" name="end_ctr{{ $end_ctr++ }}" value="{{ $item->end? Carbon\Carbon::parse($item->end)->format('Y-m-d') : null }}">
          </td>
          <td><input form="editBillsForm" class="form-control" type="number" name="amount_ctr{{ $amount++ }}" step="0.01" value="{{  $item->balance }}"></td>
          <td>
            @if(Auth::user()->user_type === 'manager')
              @if($item->bill_status === 'deleted')
              <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/restore" method="POST">
                @csrf
                @method('put')
                <button title="restore this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-restore fa-sm text-white-50"></i></button>
              </form>
              @else
              <form action="/property/{{ $property->property_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/delete" method="POST">
                @csrf
                @method('delete')
                <button title="remove this bill" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash fa-sm text-white-50"></i></button>
              </form>
              @endif    
            @endif
          </td>   
        </tr>
        @endif
      
        @endforeach

        <tr>
          <th>TOTAL</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th><input class="form-control" type="" step="0.01" value="{{ number_format($balance->sum('balance')-$deleted_bills,2) }}" readonly> </th>
         </tr>  
         <tbody>  
    </table>
  </div>
  @endif
  <br>
  <h6 class="h2 text-dark d-inline-block mb-0">This message will appear at the bottom of the Statement of Accounts.</h6>
  <br><br>
  <textarea form="editBillsForm" class="form-control" name="note" id="" cols="20" rows="10">
    {{ Auth::user()->note }}
    </textarea> 

 
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



