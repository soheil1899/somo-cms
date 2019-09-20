<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminPanel</title>

    <!-- Fonts -->

{{--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
{{--    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}

    <link rel="stylesheet" href="/css/app.css">


</head>
<body id="adminmaster">


<nav class="navbar navbar-expand navbar-dark bg-primary" id="admin-header"><a href="#menu-toggle" id="menu-toggle"
                                                                              class="navbar-brand"><span
                class="navbar-toggler-icon"></span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02"
            aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>


    <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item position-relative">
                <div class="dropdown">
                    <label class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                        {{auth()->user()->name}}
                        عزیز خوش آمدید
                    </label>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/">صفحه اصلی سایت</a>
                        @if(auth()->user()->id == 1)
                        <a class="dropdown-item" href="{{route('superadmin.info')}}">ریزاطلاعات شما</a>
                        @endif
                        <a class="dropdown-item" href="{{route('changemyinfo')}}">تغییر رمز عبور</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            خروج
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-md-0"></form>
    </div>
</nav>

<div id="wrapper" class="toggled">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">

        @include('layouts.admin.aside')

    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div id="app" class="container-fluid">


            @yield('content')


        </div>
    </div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->

</body>


<script src="/js/app.js"></script>


<script>


    $(function () {
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");

        });

        $(window).resize(function (e) {
            if ($(window).width() <= 768) {
                $("#wrapper").removeClass("toggled");
            } else {
                $("#wrapper").addClass("toggled");
            }
        });
    });

    $(".sidebar-submenu").hide();

    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        $('.sidebar-dropdown > a').removeClass('subactive');
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
            $(this).removeClass('subactive');
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
            $(this).addClass('subactive');
        }
    });

    $(".sidebar-submenu > ul > li > a").click(function () {
        if (!$(this).hasClass("subactive2")) {
            $('.sidebar-submenu').find('a').removeClass('subactive2');
            $(this).addClass('subactive2');
        }
    });

</script>

@yield('script')

</html>
