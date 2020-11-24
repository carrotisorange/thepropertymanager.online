

    <p>
        <h3> Hi, {{ $name }}! </h3>
        <br>

        Your contract has been terminated because of {{ $reason }} reason. You are scheduled to moveout on {{ Carbon\Carbon::parse($actual_moveout_at)->format('M d Y') }}.
        Please settle your unpaid balance amounting ₱{{ number_format($balance->sum('balance'),2) }} before the moveout date. Login to your tenant <a href="/thepropertymanager.online/login">portal</a> to see the breakdown.

        <br>
        <br>
        Thanks,<br>
        {{ Auth::user()->property }}
    </p>
        