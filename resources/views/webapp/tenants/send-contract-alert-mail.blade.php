<p>
    <h3> Hi, {{ $name }}! </h3>

    <br>

    This email is to remind you that your contract in unit {{ $unit }} is set to end on
    {{ Carbon\Carbon::parse($moveout_at)->format('M d Y') }}, exactly {{ $days_before_moveout }} days from now.
    Would you like to extend your contract? If yes, for how long? Please send your response to
    {{ Auth::user()->email }}.

    <br><br>


    Thanks,<br>
    {{ Session::get('property_name') }}
</p>