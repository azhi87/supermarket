<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Pharmacy System</title>
    <!-- google font -->
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
    <!-- icons -->
    <link  href="{{asset('/public/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('/public/css/material-design-iconic-font.min.css')}}">
    <!-- bootstrap -->
    <link href="{{asset('/public/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- style -->
    <link rel="stylesheet" href="{{asset('/public/css/extra_pages.css')}}">
    <!-- favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" />
</head>

<body>
    <div class="limiter">
        <div class="container-login100 page-background">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" action="{{ route('login') }}">
                        @csrf
                        <span class="login100-form-logo">
                        <img alt="" src="img/hospital.png">
                    </span>
                    <span class="login100-form-title p-b-34 p-t-27">
                      <strong>  Log in </strong>
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="Email" required="">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                         @error('email')
                                    <h6 class="label label-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </h6>
                                @enderror
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password" required="">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                        @error('password')
                                    <h6 class="font-red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </h6>
                                @enderror
                    </div>

                        <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                    <strong>       {{ __('Login') }}   </strong>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- start js include path -->
    <script src="{{asset('/public/js/jquery.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{asset('/public/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/public/js/login.js')}}"></script>
    <!-- end js include path -->
</body>

</html>
