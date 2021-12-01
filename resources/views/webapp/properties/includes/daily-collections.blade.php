<tbody>
    @foreach ($collection as $item)
    <tr>

        <td>{{ $item->ar_no }}</td>
        <td>{{ $item->payment_bill_no }}</td>
        <th>
            @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
            Session::get('property_type') === '6')
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->unit_no }}
                @else
                <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->unit_no }}
                    @endif

        </th>
        <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#payments">{{
                $item->first_name.' '.$item->last_name }}</a>
        </th>

        <td>{{ $item->particular }}</td>
        <td>{{ $item->form }}</td>
        <td colspan="2">
            {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
            {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
        </td>
        <td>{{ number_format($item->amt_paid,2) }}</td>
        @endforeach
    <tr>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="2"></th>
        <th>{{ number_format($collections_for_the_day->sum('amt_paid'),2) }}</th>
    </tr>
</tbody>