<tr>
    <td>{{ $item->user_name }}</td>
    <td>{{ $item->role_id_foreign }}</td>
    <td>{{ $item->session_last_login_ip }}</td>
    <td>{{ $item->session_last_login_at? Carbon\Carbon::parse($item->session_last_login_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_login_at)->toTimeString() : null }}</td>
    <td>{{ $item->session_last_logout_at? Carbon\Carbon::parse($item->session_last_logout_at)->format('M d Y').' '.Carbon\Carbon::parse($item->session_last_logout_at)->toTimeString() : null }}</td>
    <td>
        @if($item->session_last_logout_at == null)
            0.0 hours
        @else
            {{ number_format(Carbon\Carbon::parse($item->session_last_login_at)->DiffInHours(Carbon\Carbon::parse($item->session_last_logout_at)),1) }}
            hours
        @endif
    </td>
</tr>