<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestión de Flota</title>

    <link href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="{{ asset("css/sb-admin-2.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/Estilo.css") }}" rel="stylesheet" type="text/css">

</head>

<body id="page-top">
<div id="wrapper">

    <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Gestión Flota</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i><span>Inicio</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading"></div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFlota" aria-expanded="true" aria-controls="collapseFlota"><i class="fa fa-bus"></i><span>Flota</span></a>
            <div id="collapseFlota" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Flota:</h6>
                    <a class="collapse-item" href="{{ url('flota/buses') }}">Buses</a>
                    <a class="collapse-item" href="{{ url('flota/salones') }}">Salones</a>
                    <a class="collapse-item" href="{{ url('flota/mantencion') }}">Mantenciones</a>
                    <a class="collapse-item" href="{{ url('flota/mantencion/ordenescompra') }}">Ordenes de Compra</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTripulacion" aria-expanded="true" aria-controls="collapseTripulacion"><i class="fa fa-user"></i><span>Tripulación</span></a>
            <div id="collapseTripulacion" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Tripulación:</h6>
                    <a class="collapse-item" href="#">Gestión</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuario" aria-expanded="true" aria-controls="collapseUsuario"><i class="fa fa-users"></i><span>Usuario</span></a>
            <div id="collapseUsuario" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Usuario:</h6>
                    <a class="collapse-item" href="#">Gestión</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLiquidacion" aria-expanded="true" aria-controls="collapseLiquidacion"><i class="fa fa-dollar"></i><span>Liquidación</span></a>
            <div id="collapseLiquidacion" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Liquidación:</h6>
                    <a class="collapse-item" href="#">Gestión</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button"><i class="fas fa-search fa-sm"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-white small">{{ $user->data_persona->nombres . " " . $user->data_persona->apellido_paterno . " " . $user->data_persona->apellido_materno}}</span>
                            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#"><i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Perfil</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Configuración</a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>Salir</a>
                        </div>
                    </li>

                </ul>

            </nav>

            <script src="{{ asset("js/jquery-3.4.0.js") }}"></script>
            <script src="{{ asset("js/bootstrap.min.js") }}"></script>


            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">@yield('titulo')</h1>
                </div>

                @yield('contenido')

            </div>

        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span class="small">Copyright &copy; Felipe Rodríguez 2019</span>
                </div>
            </div>
        </footer>
    </div>

</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>



</body>
</html>
