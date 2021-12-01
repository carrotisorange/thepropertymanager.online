<tr>
    <td>{{ Carbon\Carbon::parse($bill->date_posted)->format('d M, Y') }}</td>
    <td>{{ $bill->bill_no }}</td>
    <td>
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type')
        === '6')
        <a href="/property/{{Session::get('property_id')}}/occupant/{{ $bill->tenant_id }}/#bills">{{
            $bill->first_name.' '.$bill->last_name }}</a>
        @else
        <a href="/property/{{Session::get('property_id')}}/tenant/{{ $bill->tenant_id }}/#bills">{{ $bill->first_name.'
            '.$bill->last_name }}</a>
        @endif
    </td>
    <td>
        @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
        Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type')
        === '6')
        <a href="/property/{{Session::get('property_id')}}/unit/{{ $bill->unit_id }}#payments">{{ $bill->building.'
            '.$bill->unit_no }}</a>
        @else
        <a href="/property/{{Session::get('property_id')}}/room/{{ $bill->unit_id }}#payments">{{ $bill->building.'
            '.$bill->unit_no }}</a>
        @endif

    </td>
    <td>{{ $bill->particular }}</td>

    <td colspan="2">
        {{ $bill->start? Carbon\Carbon::parse($bill->start)->format('d M, Y') : null}}-
        {{ $bill->end? Carbon\Carbon::parse($bill->end)->format('d M, Y') : null }}
    </td>
    <td>{{ number_format($bill->amount,2) }}</td>
    <td><a class="text-danger" href="/bill/{{ $bill->bill_id }}/delete/bill"><i class="fas fa-times"></i> Remove</a>
    </td>
</tr>