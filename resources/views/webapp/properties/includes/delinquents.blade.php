<?php $delinquents_ctr =1; ?>
<tbody>
    @foreach($delinquents as $item)
    <tr>
        <th>{{ $delinquents_ctr++ }}</th>
        <th>
            <a href="/property/{{Session::get('property_id')}}/tenant/{{ $delinquent->tenant_id }}#bills">{{$delinquent->first_name.' '.$delinquent->last_name }}
        </th>
        <th>
            @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
            @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
            Session::get('property_type') === '6')
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $delinquent->unit_id   }}">{{$delinquent->building.' '.$delinquent->unit_no }}</a>
            @else
            <a href="/property/{{Session::get('property_id')}}/room/{{ $delinquent->unit_id   }}">{{$delinquent->building.' '.$delinquent->unit_no }}</a>
            @endif
            @else
            {{ $delinquent->unit_no }}
            @endif
        </th>
        <td>
            <a>{{ number_format($delinquent->balance,2) }}
        </td>
    </tr>
    @endforeach
</tbody>