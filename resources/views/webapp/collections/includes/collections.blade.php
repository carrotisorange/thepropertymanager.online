<tr>
    <td>{{ Carbon\Carbon::parse($collection->payment_created)->format('M d, Y') }}</td>
    <td>{{ $collection->ar_no }}</td>
    <td>{{ $collection->payment_bill_no }}</td>
    <td>
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6')
        <a href="/property/{{Session::get('property_id')}}/occupant/{{ $collection->tenant_id }}#payments">{{$collection->first_name.' '.$collection->last_name }}</a>
        @else
        <a href="/property/{{Session::get('property_id')}}/tenant/{{ $collection->tenant_id }}#payments">{{$collection->first_name.' '.$collection->last_name }}</a>
        @endif
    </td>
    <td>
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6')
        <a href="/property/{{Session::get('property_id')}}/unit/{{ $collection->unit_id }}#payments">{{ $collection->building.' '.$collection->unit_no }}</a>
        @else
        <a href="/property/{{Session::get('property_id')}}/room/{{ $collection->unit_id }}#payments">{{ $collection->building.' '.$collection->unit_no }}</a>
        @endif
    </td>
    <td>{{ $collection->form }}</td>
    <td>
        @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 2 ||
        Auth::user()->role_id_foreign === 1)
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $collection->unit_id }}/contract/{{ $collection->contract_id }}/tenant/{{ $collection->tenant_id }}/bill/{{ $collection->bill_id }}/payment/{{ $collection->payment_id }}/remittance/create">{{
            number_format($collection->amt_paid,2) }}</a>
        @else
        {{ number_format($collection->amt_paid,2) }}
        @endif
    </td>
    <td><a class="text-danger" href="/payment/{{ $collection->payment_id }}/delete/payment"><i class="fas fa-times"></i>Remove</a></td>
</tr>