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

    <title>Forgot password | The Property Manager </title>
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
              <h3>Forgot password</h3>
              @if(session('status'))
              <div class="alert alert-success" role="alert">
                  {{  session('status') }}
              </div>
            @endif
            </div>
            <form class="user" id="resetPasswordForm" method="POST" action="{{ route('password.email') }}">
              @csrf
         
           
      <div class="form-group first">
             
        <input form="resetPasswordForm" id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-describedby="emailHelp" placeholder="Enter Email Address...">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror         
     
    </div>
      <br>
 
   

              <input form="resetPasswordForm" type="submit" value="Send Password Reset Link" class="btn btn-block btn-primary" onclick="this.form.submit(); this.disabled = true;">

             <a style="text-decoration:none" href="/#pricing"><span class="d-block text-left my-4 text-muted">&mdash; Doesn't have an account yet? &mdash;</span></a>

             <a style="text-decoration:none" href="/login"><span class="d-block text-left my-4 text-muted">&mdash; Already have an account? &mdash;</span></a>
              
              <div class="social-login">
              
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