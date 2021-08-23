<p>
    <h3> Hi, {{ $name }}! </h3>

    <br>

    Thanks for staying in {{ $property }}.
    <br>
    <br>
    Your contract in room {{ $unit }} starts on {{ Carbon\Carbon::parse($movein_at)->format('M d Y') }} and ends on
    {{ Carbon\Carbon::parse($moveout_at)->format('M d Y') }}.
    Please take note that the billing cycle starts every 1st day of the month. If your movein date happens to be not on
    the first day of the month, then
    your first bill will be prorated, which means that you'll only have to pay from the date of your movein to the last
    day of the current month.

    <br><br>
    To keep track of your bills and payments, and to report concerns, go to your tenant portal through this link <a
        href="/thepropertymanager.online/login">here</a> and use the credentials below:
    <br>
    <br>
    Email: {{ $email }}
    <br>
    Password: {{ $mobile }}

    <br><br>



    Thanks,<br>
    {{ $property }}
</p>