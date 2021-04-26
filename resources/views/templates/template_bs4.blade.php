<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <link rel="shortcut icon" type="image/ico" href="img/favicon.ico">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <!-- Styles -->
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
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
                                <li class="nav-item ml-auto">
                                  <a class="btn btn-outline-primary btn-menu ml-auto" aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>

                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                  </a>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                                  </div>
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
