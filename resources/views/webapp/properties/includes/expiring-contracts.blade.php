<?php $expiring_contract_ctr =1; ?>
<tbody>
    @foreach($expiring_contracts as $item)

    <tr>
        <th>{{ $expiring_contract_ctr++ }}</th>
        <th>
            <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#contracts">{{
                $item->first_name.' '.$item->last_name }}
        </th>
        <th>
            @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
            Session::get('property_type') === '6')
            <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->building.'
                '.$item->unit_no }}</a>
            @else
            <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.'
                '.$item->unit_no }}</a>
            @endif

        </th>
        <td>{{Carbon\Carbon::parse($item->moveout_at)->format('M d Y')}} <span class="text-danger">({{
                Carbon\Carbon::parse($item->moveout_at)->diffForHumans() }})</span></td>

        <td>
            @if($item->contract_status === 'active')
            <span> {{ $item->contract_status }} <i class="fas fa-check-circle text-success"></i> </span>
            @else
            <span> {{ $item->contract_status }} <i class="fas fa-clock text-warning"></i> </span>

            @endif
        </td>
        {{-- <td>
            @if($item->email_address === null)
            <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/edit#email_address"
                class="badge badge-danger">Please add an email</a>
            @else
            <form
                action="/property/{{Session::get('property_id')}}/home/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/contract/{{ $item->contract_id }}/alert">
                @csrf
                @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
                <button class="btn btn-sm btn btn-primary" type="submit"
                    onclick="this.form.submit(); this.disabled = true;"><i
                        class="fas fa-paper-plane fa-sm text-white-50"></i> Send email</button>
                @else
                <button class="btn btn-sm btn btn-primary" title="for manager and admin access only" type="submit"
                    onclick="this.form.submit(); this.disabled = true;" disabled><i
                        class="fas fa-paper-plane fa-sm text-white-50"></i> Send Email</button>
                @endif
            </form>
            @endif
        </td> --}}
        <td>{{ $item->contact_no }}</td>

    </tr>
    @endforeach
</tbody>