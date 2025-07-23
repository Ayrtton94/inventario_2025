<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

    <!-- AdminLTE + FontAwesome (instalado por npm) -->
    <link rel="stylesheet" href="/node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link">
            <img src="{{ asset('img/Logo_2.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @can('pendiente.index')
                        <li class="nav-item">
                            <a href="{{ route('pendiente.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                    @endcan
                    @can('producto.index')
                        <li class="nav-item">
                            <a href="{{ route('productos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>Producto</p>
                            </a>
                        </li>
                    @endcan
                    @can('detalle_producto.index')
                        <li class="nav-item">
                            <a href="{{ route('detalle_productos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Detalle del producto</p>
                            </a>
                        </li>
                    @endcan
                    @can('importexcel.index')
                        <li class="nav-item">
                            <a href="{{ route('importexcel') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-import"></i>
                                <p>Importar</p>
                            </a>
                        </li>
                    @endcan
                    @can('user.index')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    @endcan
                    @can('roles.index')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>Lista de roles</p>
                            </a>
                        </li>
                    @endcan
                    @can('tecnico.index')
                        <li class="nav-item">
                            <a href="{{ route('tecnico.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Formulario Técnico</p>
                            </a>
                        </li>
                    @endcan
                    @can('asignar.index')
                        <li class="nav-item">
                            <a href="{{ route('asignado.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Asignados</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            {{ date('Y') }}
        </div>
        <strong>&copy; {{ config('app.name') }}</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- AdminLTE App JS -->
<script src="/node_modules/admin-lte/dist/js/adminlte.min.js"></script>
</body>
</html>
