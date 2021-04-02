<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/login-form-07/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('/login-form-07/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/login-form-07/css/bootstrap.min.css') }}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('/login-form-07/css/style.css') }}">

    <title>Verify Email | The Property Manager </title>
  </head>
  <body>
  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('/login-form-07/images/TPMO 4.png') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Verify your email address...</h3>
              {{-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> --}}
            </div>

            @if (session('resent'))
            <div class="alert alert-success" role="alert">
              A fresh verification link has been sent to the email address {{ Auth::user()->email }}.
            </div>
            @endif
            
                  {{ __('Before proceeding, please check your email for a verification link.') }}
                  {{ __('If you did not receive the email') }},
                  <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
            
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="{{ asset('/login-form-07/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/login-form-07/js/popper.min.js') }}"></script>
    <script src="{{ asset('/login-form-07/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/login-form-07/js/main.js') }}"></script>
  </body>
</html>