


    <tr>
        <?php $explode = explode(" ", $referral->name);?>
        <td>{{ $explode[0] }}</td>
        <td>{{ $referral->role_id_foreign }}</td>
        <td>{{ number_format($referral->referrals) }}</td>
    </tr>

