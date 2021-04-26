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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <style>
            .userlogado {
                font-size: larger;
                margin-top: 20px;
            }
            .btn-menu{
              font-weight: 600; 
              background-color: #dfe4ea3d; 
              margin-right: 20px;
              border: none;
            }
        @yield('style');
        </style>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" ></script>        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/sweetalert/sweetalert.js') }}"></script>

        @yield('head')

    </head>

    <body>
      <div class="main-content">
        <div class="page-wrapper">
            <header class="header-desktop d-lg-block">
                <div class="section__content section__content--p35 d-flex">
                    <div class="login-logo" style="display:flex">
                        <a href="http://www.cemiteriodocatumbi.com.br" style="width:100%;" >
                            <img class="img-fluid img-responsive"  style="margin-top:12px; max-height:64px;" src="{{ asset('img/logo.png') }}" alt="Cemitério e Crematório do Catumbi"></a>
                    </div>

                    <nav class="navbar navbar-expand-lg navbar-light w-100 ft-16 mt-2">
                        <div class="container-fluid">
                          <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          
                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                              @guest
                                @if (Route::has('login'))
                                <li class="nav-item ml-auto">
                                    <a class="btn btn-outline-primary me-4" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @endif
                                
                              @else
                                <label class="ml-auto"></label>
                                @if (!Request::is('home'))
                                <li class="nav-item ">
                                  <a class="btn btn-outline-primary btn-menu " aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                @endif

                                @if (Auth::user()->nivel==1)
                                <li class="nav-item ">
                                  <a class="btn btn-outline-primary btn-menu"  aria-current="page" href="{{ route('corretores') }}">Corretores</a>
                                </li>
                                @endif

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
<!--                                      <li><a class="dropdown-item" href="#">Perfil</a></li>
                                      <li><hr class="dropdown-divider"></li>  -->
                                      <li><a class="dropdown-item" href="{{ route('logout') }}">Sair</a></li>
                                    </ul>
                                </li>
                              @endguest

                            </ul>

                          </div>
                        </div>
                      </nav>

                </div>
            </header>
            <br>

            <!--  Módulo: espera   -->
            <div id="loadbar" class="d-none" style="z-index:999; left:50%; top:40%;">
                <div class="blockG" id="rotateG_01"></div>
                <div class="blockG" id="rotateG_02"></div>
                <div class="blockG" id="rotateG_03"></div>
                <div class="blockG" id="rotateG_04"></div>
                <div class="blockG" id="rotateG_05"></div>
                <div class="blockG" id="rotateG_06"></div>
                <div class="blockG" id="rotateG_07"></div>
                <div class="blockG" id="rotateG_08"></div>
            </div>

    @yield( "content" )

        </div>

        <!-- Inicio da footer---->      
        <div class="footer">
            <span class="copyright">Copyright © 2020-2021  CC.SFP - Cemitério e Crematório São Francisco de Paula. All rights reserved.</span>
        </div>

      </div>


      <!-- Scripts -->
      <script>
@yield( "script" )
      </script>
        
    </body>

</html>
