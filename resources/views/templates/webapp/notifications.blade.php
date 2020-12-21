@foreach (['danger', 'warning', 'success', 'info'] as $key)
@if(Session::has($key))
<div class="col p-0 m-0 mx-auto text-center">
    <div class="alert alert-{{ $key }} alert-dismissable custom-{{ $key }}-box">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @if($key === 'danger')
        <strong> {{ Session::get($key) }}</strong>
        @elseif($key === 'success')
        <strong>{{ Session::get($key) }}</strong>
        @endif
     </div>
</div>
@endif
@endforeach