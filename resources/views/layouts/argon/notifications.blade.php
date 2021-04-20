@foreach (['danger', 'warning', 'success', 'info'] as $key)
@if(Session::has($key))
<div class="col-md-6 mx-auto text-center">
    <div class="alert alert-{{ $key }} alert-dismissable custom-{{ $key }}-box">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @if($key === 'danger')
        <span> {{ Session::get($key) }} <i class="fas fa-times-circle"></i></span>
        @elseif($key === 'success')
        <span>{{ Session::get($key) }} <i class="fas fa-check-circle"></i></span>
        @endif
     </div>
</div>
@endif
@endforeach