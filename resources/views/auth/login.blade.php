<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="position-relative" style="background-image: url(/media/cite/loginback.jpg); background-size: cover; background-repeat: no-repeat; height: auto">
<div id="app" class="mt-0 pt-5">

    <div class="pt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-5">


                <div class="mx-auto position-relative" style="width: fit-content">
                    <div class="arrow-right mr-auto"></div>
                    <div class="arrow-left ml-auto"></div>
                    <div class="position-absolute" style="top: 10px;width: 100%; height: 100%">
                        <div class="mx-auto my-3 py-2" style="width: fit-content; background-color: #fff">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                </div>


                <h3 class="text-center py-2 mb-4" style="color: #fcfffb; font-family: Alegria; font-size: 40px">
                    Login
                </h3>


                <form method="POST" action="{{ route('login') }}" dir="ltr" class="px-5" style="width: 100%;">
                    @csrf

                    <div class="px-2 py-1 mb-2"
                         style="background-color: rgba(117, 122, 142, 0.5)">


                        <div class="d-inline-block text-left" dir="ltr" style="width: fit-content">
                            <i class="fas fa-at fa-2x py-1 pr-2 border-right" style="color: #eee"></i>
                        </div>
                        <div class="d-inline-block position-relative" style="width: 90%">
                            <input id="email" type="email" name="email"
                                   class="form-control position-absolute loginregisterinput @error('email') is-invalid @enderror"
                                   required autocomplete="email" autofocus
                                   placeholder="Email">

                        </div>

                    </div>
                    <div class="px-2 py-1"
                         style="background-color: rgba(117, 122, 142, 0.5)">
                        <div class="d-inline-block text-left" dir="ltr" style="width: fit-content">
                            <i class="fas fa-fingerprint fa-2x py-1 pr-2 border-right" style="color: #eee"></i>
                        </div>
                        <div class="d-inline-block position-relative" style="width: 90%">
                            <input id="password" type="password"
                                   class="form-control position-absolute loginregisterinput @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="current-password" placeholder="Password">

                        </div>
                    </div>
                    <div class="row">

                        <div class="col pl-4">
                            <div class="form-group text-left mb-0 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label logintext" for="remember">
                                        <small>
                                            <strong>
                                            {{ __('Remember Me') }}
                                            </strong>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="col ">
                                <a class="btn btn-link logintext forgetpass" href="{{ route('password.request') }}">
                                    <small>
                                        <strong>
                                        {{ __('Forgot Your Password?') }}
                                        </strong>
                                    </small>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-block btn-danger py-2"
                                style="background-color: rgb(255,51,102); border-radius: 0">
                            <strong>Login</strong>
                        </button>
                    </div>
                    <div class="row">
                        @if (Route::has('password.request'))
                            <div class="col text-center">
                                <a class="btn btn-link logintext loginregister" href="{{ route('register') }}">
                                    <small>
                                        <strong>
                                        Create a New Account
                                        </strong>
                                    </small>
                                </a>
                            </div>
                        @endif
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>

<div class="position-absolute" style="bottom: 5px; width: 100%">
    <div class="mx-auto logintext" dir="ltr" style="width: fit-content">
        <small class="d-block d-sm-none">
        &copy; 2019 <strong>SOMO</strong> Engine. All rights reserved &nbsp;&nbsp;  | &nbsp;&nbsp;  Design by <strong>GelyGroup</strong>
        </small>
        <div class="d-none d-sm-block">
        &copy; 2019 <strong>SOMO</strong> Engine. All rights reserved &nbsp;&nbsp;  | &nbsp;&nbsp;  Design by <strong>GelyGroup</strong>
        </div>

    </div>
</div>

</body>
</html>