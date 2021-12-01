

        <td>{{ $collection->ar_no }}</td>
        <td>{{ $collection->payment_bill_no }}</td>
        <th>
            @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
            Session::get('property_type') === '6')
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $collection->unit_id }}">{{ $collection->unit_no }}
                @else
                <a href="/property/{{Session::get('property_id')}}/room/{{ $collection->unit_id }}">{{ $collection->unit_no }}
                    @endif

        </th>
        <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $collection->tenant_id }}#payments">{{
                $collection->first_name.' '.$collection->last_name }}</a>
        </th>

        <td>{{ $collection->particular }}</td>
        <td>{{ $collection->form }}</td>
        <td colspan="2">
            {{ $item->start? Carbon\Carbon::parse($collection->start)->format('M d Y') : null}} -
            {{ $item->end? Carbon\Carbon::parse($collection->end)->format('M d Y') : null }}
        </td>
        <td>{{ number_format($collection->amt_paid,2) }}</td>
        @endforeach
    <tr>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="2"></th>
        <th>{{ number_format($collection->sum('amt_paid'),2) }}</th>
    </tr>
