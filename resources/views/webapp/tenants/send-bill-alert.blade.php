<p class="text-justify">
    <h3>Hi, {{ $name }}!</h3>

    <br>

    Your bill ({{ $desc }}) for <b>{{ Carbon\Carbon::parse($start)->format('M d Y') }} -
        {{ Carbon\Carbon::parse($end)->format('M d Y') }}</b>
    amounting ₱{{ number_format($amt,2) }} has been posted to your account. Log in to your <a
        href="thepropertymanager.online/login">tenant portal</a> to see more details.

    <br><br>

    Sincerely,
    <br>
    {{ Session::get('property_name') }}
</p>