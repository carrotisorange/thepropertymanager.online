<tr>
    <td>{{ Carbon\Carbon::parse($payable->requested_at)->format('M d Y') }}</td>
    <td>{{ $payable->entry }}</td>
    <td>{{ number_format($payable->amt, 2) }}</td>
    <td>{{ $payable->name }}</td>
    <td>{{ $payable->pb_note? $payable->pb_note: '-' }}</td>
    <td>
        @if($payable->payable_status == 'pending')
        <span class="text-warning"><i class="fas fa-clock "></i> {{ $payable->payable_status }}</span>
        @elseif($payable->payable_status == 'approved')
        <span class="text-success"><i class="fas fa-check "></i> {{ $payable->payable_status }}</span>
        @elseif($payable->payable_status == 'released')
        <span class="text-success"><i class="fas fa-clipboard-check "></i> {{ $payable->payable_status }}</span>
        @elseif($payable->payable_status == 'declined')
      <span class="text-danger"><i class="fas fa-times "></i> {{ $payable->payable_status }}</span>
        @endif
    </td>
    <td>
        @if($payable->payable_status == 'released')

        @else
        <form action="/property/{{ Session::get('property_id') }}/payable/{{ $payable->pb_id }}/action" method="GET"
            onchange="submit();">
            <select class="" name="payable_option" id="">
                <option value="">Select your option</option>
                @if($payable->payable_status != 'approved' && $payable->payable_status != 'released' &&
                $payable->payable_status != 'declined')
                <option value="approve">Approve</option>
                @endif
                @if($payable->payable_status == 'approved' && $payable->payable_status != 'released' )
                <option value="release">Release</option>
                @endif
                @if($payable->payable_status != 'declined')
                <option value="decline">Decline</option>
                @endif
            </select>
        </form>
        @endif
    </td>
</tr>