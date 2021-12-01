<tr>
    <td>{{ Carbon\Carbon::parse($concern->reported_at)->format('M d, Y') }}</td>
    <td>
        @if($concern->concern_owner_id)
        <a target="_blank"
            href="/property/{{Session::get('property_id')}}/owner/{{$concern->concern_owner_id}}/#concerns">{{
            $item->concern_owner_name }}
            (owner)</a>
        @else
        <a target="_blank" href="/property/{{Session::get('property_id')}}/tenant/{{$concern->tenant_id}}/#concerns">{{
            $concern->first_name.' '.$concern->last_name }}
            (tenant)</a>
        @endif
    </td>
    <td>{{ $concern->category }}</td>
    <td>
        <a href="/property/{{Session::get('property_id')}}/room/{{ $concern-> unit_id  }}/#concerns" target="_blank">{{
            $concern->building.' '.$concern->unit_no }}</a>
    </td>
    <td>
        @if($concern->urgency === 'emergency')
        <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $concern->urgency }}</span>
        @elseif($concern->urgency === 'major')
        <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $concern->urgency }}</span>
        @else
        <span class="text-warning"><i class="fas fa-clock "></i> {{ $concern->urgency }}</span>
        @endif
    </td>
    <td>
        @if($concern->concern_status === 'pending' || $concern->concern_status === 'assessed' ||
        $concern->concern_status === 'waiting for approval' || $concern->concern_status === 'approved' ||
        $concern->concern_status === 'request for purchase' || $concern->concern_status === 'for purchase' )
        <span class="text-warning"><i class="fas fa-clock "></i> {{ $concern->concern_status }}</span>
        @elseif($concern->concern_status === 'on-going')
        <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $concern->concern_status }}</span>
        @else
        <span class="text-success"><i class="fas fa-check-circle "></i> {{ $concern->concern_status }}</span>
        @endif
    </td>
    <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $concern->id }}">{{ $concern->name }}({{ $concern->role }})</a> </td>
    <td>
        @if(Auth::user()->role_id_foreign == '1' || Auth::user()->role_id_foreign == '4')
        @if($concern->concern_status === 'pending')
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/assessment/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @elseif($concern->concern_status === 'assessed')
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/scope_of_work/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @elseif($concern->concern_status === 'waiting for approval')
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/approval/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @elseif($concern->concern_status === 'request for purchase')
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/materials/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @elseif($concern->concern_status === 'approved')
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/payment-options/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @endif
        @else
        <a href="/property/{{ Session::get('property_id') }}/room/{{ $concern->unit_id }}/tenant/{{ $concern->concern_tenant_id?$concern->concern_tenant_id:$concern->owner_id_foreign }}/concern/{{ $concern->concern_id }}/communications/"
            target="_blank"><i class="fas fa-eye"></i> View</a>
        @endif
    </td>
    <td>
        @if(Auth::user()->role_id_foreign == '1' || Auth::user()->role_id_foreign == '4')
        @if(!$concern->approved_by_manager_at)
        <a href="/property/{{ Session::get('property_id') }}/concern/{{ $concern->concern_id }}/approve/"><i
                class="fas fa-check"></i> Approve</a>
        @endif
        @else
        @endif
    </td>
</tr>