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

    <title>Sign in | The Property Manager </title>
  </head>
  <body>
  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('/login-form-07/images/undraw_remotely_2j6y.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In</h3>
              {{-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> --}}
            </div>
            <form class="user" method="POST" id="loginForm" action="{{ route('login') }}">
              @csrf
            </form>
              <div class="form-group first">
                <label for="username">Email</label>
                <input form="loginForm" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

              </div>
              <br>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input form="loginForm" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                @if (Route::has('password.request'))
                <span class="ml-auto"><a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password</a></span> 
            @endif
              
              </div>
              
              <input form="loginForm" type="submit" value="Log In" class="btn btn-block btn-primary" onclick="this.form.submit(); this.disabled = true;">

             <a style="text-decoration:none" href="/#pricing"><span class="d-block text-left my-4 text-muted">&mdash; Doesn't have an account yet? &mdash;</span></a>
              
              <div class="social-login">
                {{-- <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span> 
                </a>
                <a href="#" class="twitter">
                  <span class="icon-twitter mr-3"></span> 
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span> 
                </a> --}}
              </div>
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