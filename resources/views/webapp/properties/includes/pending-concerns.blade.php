
    <tr>

        <th>
            <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}
        </th>
        <th>
            @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
            @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
            Session::get('property_type') === '6')
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id   }}">{{ $item->unit_no }}</a>
            @else
            <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id   }}">{{ $item->unit_no }}</a>
            @endif
            @else
            {{ $item->building.' '.$item->unit_no }}
            @endif
        </th>
        <th>
            <a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id   }}">{{ $item->title }}</a>
        </th>
    </tr>
