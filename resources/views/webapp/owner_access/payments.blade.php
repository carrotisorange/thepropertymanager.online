@extends('webapp.owner_access.template')

@section('title', 'Payments')

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Payments</h6>

</div>
@endsection

@section('main-content')
<div class="table-responsive text-nowrap">
  <table class="table">
    @foreach ($payments as $day => $collection_list)
    <thead>
      <tr>
        <th colspan="10">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $collection_list->count() }})
        </th>

      </tr>
      <tr>
        <?php $ctr = 1; ?>
        <th class="text-center">#</th>
        <th>AR No</th>
        <th>Bill No</th>

        <th>Particular</th>
        <th colspan="2">Period Covered</th>
        <th>Form</th>
        <th class="text-right">Amount</th>

      </tr>
      </tr>
    </thead>
    @foreach ($collection_list as $item)

    <tr>
      <th class="text-center">{{ $ctr++ }}</th>
      <td>{{ $item->ar_no }}</td>
      <td>{{ $item->payment_bill_no }}</td>
      {{-- <td>{{ $item->building.' '.$item->unit_no }}</td> --}}
      <td>{{ $item->particular }}</td>
      <td colspan="2">
        {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
        {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
      </td>
      <td>{{ $item->form }}</td>
      <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>

      {{-- <td class="">
                    <a title="export" target="_blank" href="/units/{{ $item->unit_tenant_id }}/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export"
      class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i></a> --}}
      {{-- <a target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a> 
                  
                  </td>  --}}
      {{-- <td class="text-center">
                    @if(Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4)
                    <form action="/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}" method="POST">
      @csrf
      @method('delete')
      <button title="delete" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
        onclick="return confirm('Are you sure you want perform this action?');"><i
          class="fas fa-times fa-sm text-white-50"></i></button>
      </form>
      @endif
      </td> --}}

    </tr>
    @endforeach
    <tr>
      <th>TOTAL</th>
      <th colspan="8" class="text-right">{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
    </tr>

    @endforeach
  </table>
</div>
@endsection

@section('scripts')

@endsection