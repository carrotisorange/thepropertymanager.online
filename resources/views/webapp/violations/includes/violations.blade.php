<tr>
    <td>{{ Carbon\Carbon::parse($violation->created_at)->format('M d Y') }}</td>
    <td><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $violation->tenant_id }}#violations">{{$violation->first_name.'
            '.$violation->last_name }}</a>
    </td>
    <td><a href="/property/{{ Session::get('property_id') }}/room/{{ $violation->unit_id }}#violations">{{ $violation->building.'
            '.$violation->unit_no }}</a>
    </td>
    <td>{{ $violation->title }}</td>
    <td>{{ $violation->frequency }}</td>
    <td>{{ $violation->severity }}</td>
    <td>
        @if($item->status === 'received')
        <i class="fas fa-clock text-warning"></i> {{ $violation->status }}
        @elseif($item->status === 'pending')
        <i class="fas fa-snowboarding text-primary"></i> {{ $violation->status }}
        @else
        <i class="fas fa-check-circle text-success"></i> {{ $violation->status }}
        @endif
    </td>
</tr>