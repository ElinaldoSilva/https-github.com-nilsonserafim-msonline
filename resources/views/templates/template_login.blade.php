<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <link rel="shortcut icon" type="image/ico" href="{{ asset('img/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            .title {
                font-weight: 700;
                color: #1b49b9;
                font-size: 24px;
            }    
            .cont-01 {
                display: flex;
                flex-direction: column;
            }                
            }
            .login-logo {
                margin-top: -6px;
            }
            @media (max-width: 591px) 
            {
                .login-logo  {
                    margin-top: 3px;
                }
                .cont-01  {
                    flex-direction: column-reverse;
                }
            }
            @yield('style');
        </style>

    </head>

    <body>

        <div class="cont-01">
          <div class="">
            @if (Route::has('login'))
                <div class="pt-3 pr-4 text-right">
                    @auth
                        <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 underline">Logout</a>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    @else
                        @if (!Request::is('login'))
                            <a href="{{ route('login') }}" class="mr-4 semibold c-gray underline">Login</a>
                        @endif
                    @endauth
                </div>
            @endif
          </div>

          <header class="header-desktop3 d-lg-block" style="height:68px;" >
            <div class="section__content--p35">
                <div class="login-logo">
                    <a href="/" ><img class="img-fluid img-responsive"  style="max-height:74px;" src="{{ asset('img/logo.png') }}" alt="Cemitério e Crematório do Catumbi"></a>
                </div>
            </div>

          </header>
        </div>
        <br>

        @yield('content')

    </body>

</html>
