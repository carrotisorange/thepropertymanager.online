<tr>
    <td> 
        <span class="avatar avatar-sm rounded-circle">
            <img alt="Image placeholder" src="{{ $tenant->tenant_img? asset('/storage/img/tenants/'.$tenant->tenant_img): asset('/arsha/assets/img/no-image.png') }}">
        </span>
    </td>
    <th><a href="{{ url('property/'.Session::get('property_id'), ['tenant', 'tenant_id'=>$tenant->tenant_id]) }}">{{$tenant->first_name.' '.$tenant->last_name }}</a></th>
    <th><a href="{{ url('property/'.Session::get('property_id'), ['room', 'room_id'=>$tenant->unit_id]) }}">{{$tenant->building.' '.$tenant->unit_no }}</a></th>
    <td>
        @if($tenant->contract_status === 'active')
        <span class="text-success"><i class="fas fa-check"></i> {{ $tenant->contract_status }}</span>
        @elseif($tenant->contract_status === 'pending')
        <span class="text-warning"><i class="fas fa-clock"></i> {{ $tenant->contract_status }}</span>
        @elseif($tenant->contract_status === 'inactive')
        <span class="text-danger"><i class="fas fa-times"></i> {{ $tenant->contract_status }}</span>
        @endif
    </td>
    <td>{{ Carbon\Carbon::parse($tenant->movein_at)->format('M d, Y') }}</td>
    <td>{{ Carbon\Carbon::parse($tenant->moveout_at)->format('M d, Y') }}</td>
    <td>{{ $tenant->contact_no }}</td>
    <td>{{ $tenant->type_of_tenant }}</td>
    <td>{{ $tenant->gender }}</td>
    <td>{{ $tenant->civil_status }}</td>
</tr>