<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Saúde sob Controle" name="keywords">
        <meta content="Controle sua saúde, registrando consultas e exames para mais fácil solução de casos médicos" name="description">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Saúde sob Controle</title>
        <link rel="shortcut icon" href="{{ asset('site/img/logo.png') }}" type="image/x-icon">

        <!-- Manual de uso referente aos alerts customizados "swal": https://sweetalert.js.org/guides/ -->
        <script src="{{ URL::asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}" ></script>

        <!-- JS Geral -->
        <script src="{{ asset('site/js/geral.js') }}"></script>

        <!-- CSS -->
        <link href="{{ asset('site/vendor/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/vendor/fontawesome/css/solid.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/vendor/fontawesome/css/brands.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/css/master.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/vendor/chartsjs/Chart.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('site/vendor/flagiconcss/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css" >
    </head>

    <body>
        <!-- Caonteiner principal Inicio -->
        <div class="wrapper">

            <header>
                <!-- Menu Inicio -->
                <nav id="sidebar" class="active">

                    <!-- Logo do menu inicio -->
                    <div class="sidebar-header">
                        <a href="{{route('index')}}" data-placement="top" data-toggle="tooltip" title="Voltar ao início"> <img src="{{ asset('site/img/menuLogo.png') }}" alt="bootraper logo" class="app-logo"> </a>
                        <a href="{{route('index')}}" data-placement="top" data-toggle="tooltip" title="Voltar ao início"> <span style="color: black">Sáude sob Controle</span> </a>
                    </div>
                    <!-- Logo do menu fim -->

                    <!-- Opções do Menu inicio -->
                    <ul class="list-unstyled components text-secondary">

                        <li>
                            <a href="{{route('index')}}"><i class="fas fa-home"></i> Home</a>
                        </li>

                        <li>
                            <a href="{{route('Casos.index')}}"><i class="fas fa-notes-medical"></i> Casos médicos</a>
                        </li>

                        <li>
                            <a href="{{route('relatorio')}}"><i class="fas fa-file-alt"></i> Relatórios</a>
                        </li>

                        <li>
                            <a href="{{route('premium')}}"><i class="fas fa-file-invoice-dollar"></i> Premium</a>
                        </li>

                        @if ( !empty(Auth::user()->name) )
                            @if ( Auth::user()->isAdmin() )
                                <li>
                                    <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-cog"></i> Admin </a>
                                    <ul class="collapse list-unstyled" id="pagesmenu">
                                        <li>
                                            <a href="{{route('Users.index')}}"><i class="fas fa-users"></i> Usuários</a>
                                        </li>
                                        <li>
                                            <a href="{{route('Especialidades.index')}}"><i class="fas fa-list-alt"></i> Especialidades</a>
                                        </li>
                                        <li>
                                            <a href="{{route('Tipos.index')}}"><i class="fas fa-dot-circle"></i> Tipos</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif

                        <li>
                            <a href="{{route('sobre')}}"><i class="fas fa-info-circle"></i> Sobre</a>
                        </li>

                    </ul>
                    <!-- Opções do Menu fim -->
                </nav>
                <!-- Menu Fim -->
            </header>

            <!-- Menu de acesso rápido a direita inicio -->
            <div id="body" class="active">

                <nav class="navbar navbar-expand-lg navbar-white bg-white">
                    <button type="button" id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i><span></span></button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">

                            {{-- inicio - Apenas mostrar essa parte se estiver no modo mobile, pois o logo no dropdown nas tags abaixo não são mostradas --}}
                            <li class="nav-item menuExibirManual">
                                @if( !empty(Auth::user()->name)  )
                                    <div class="ml-5">
                                        <img src=" @if( empty(Auth::user()->image) )  {{asset('site/img/semImagem.jpg')}} @else {{Auth::user()->image}} @endif" data-placement="top" data-toggle="tooltip" title="Acessar menu" width="50" class="rounded-circle mr-3">
                                        {{Auth::user()->name}}
                                    </div>
                                @else
                                    <div class="ml-5 mt-3">
                                        <i class="fas fa-user"></i>
                                        Usuário
                                    </div>
                                @endif
                            </li>
                            {{-- fim - Apenas mostrar essa parte se estiver no modo mobile, pois o logo no dropdown nas tags abaixo não são mostradas --}}

                            <li class="nav-item dropdown">

                                <div class="nav-dropdown">

                                    <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">

                                        <span>
                                            @if( !empty(Auth::user()->name)  )
                                                <img src=" @if( empty(Auth::user()->image) )  {{asset('site/img/semImagem.jpg')}} @else {{Auth::user()->image}} @endif" data-placement="top" data-toggle="tooltip" title="Acessar menu" width="50" class="rounded-circle mr-3">
                                                {{Auth::user()->name}}
                                            @else
                                                <i class="fas fa-user"></i>
                                                Usuário
                                            @endif
                                        </span>

                                        <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                        <ul class="nav-list">
                                            <li>
                                                <a href="{{ route('perfil') }}" class="dropdown-item" data-placement="top" data-toggle="tooltip" title="Acessar suas informações de acesso">
                                                    <i class="fas fa-address-card"></i>
                                                    Seu Cadastro
                                                </a>
                                            </li>


                                            <li class="dropdown-divider"></li>

                                            <li>
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-placement="top" data-toggle="tooltip" title="Encerrar acesso" class="dropdown-item">
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                    <i class="fas fa-sign-out-alt"></i>
                                                    Sair
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Conteudo da página inicio -->
                <main>
                    {{-- class="content" --}}

                    <!-- container do conteudo inicio -->
                    <div>
                        {{-- class="container" --}}
                        @yield('content_site')

                        {{-- @yield('script') --}}
                    </div>
                    <!-- Caonteiner do conteudo fim -->

                </main>
                <!-- Conteudo da página fim -->

            </div>
            <!-- Menu de acesso rápido a direita fim -->

        </div>
        <!-- Caonteiner principal Fim -->

        <!-- Footer -->
        <footer class="container-fluid">
            <div class="col-12 text-center text-dark font-weight-bold">
                <p>&copy; Copyright. Senac 2021 - Sistemas para Internet - Projeto integrador 5</p>
            </div>
        </footer>

        <!-- JS -->
        @yield('script')
        <script src="{{ asset('site/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('site/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('site/js/script.js') }}"></script>
    </body>
</html>
