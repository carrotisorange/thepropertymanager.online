<?php $referral_ctr = 1; ?>
<tbody>
    @foreach ($refferals as $referral)
    <tr>
        <?php $explode = explode(" ", $referral->name);?>
        <th>{{ $referral_ctr++ }}</th>
        <td>{{ $explode[0] }}</td>
        <td>{{ $referral->role_id_foreign }}</td>
        <td>{{ number_format($referral->referrals) }}</td>
    </tr>
    @endforeach
</tbody>