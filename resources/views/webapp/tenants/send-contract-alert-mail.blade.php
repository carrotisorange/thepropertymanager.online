<p class="text-justify">
    <h3>Hi, {{ $name }}!</h3>

    <br>

    Your contract in <b>{{ $unit }}</b> is about to expire on <b>{{ Carbon\Carbon::parse($moveout_at)->format('M d Y') }}</b>, 
        exactly <b>{{ $days_before_moveout }} days </b> from now. Would you like to extend? If yes, for how long? Please send your response to {{ Auth::user()->email }}</p>

    <br>

    Sincerely,
    <br>
    {{ $property }}
</p>