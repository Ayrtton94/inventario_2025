<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100vh;
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
            transition: background 0.3s, padding-left 0.3s;
        }

        .sidebar a:hover {
            background: #495057;
            padding-left: 15px;
        }

        .sidebar a.active {
            background: #007bff;
            font-weight: bold;
        }

        /* BOTÓN TOGGLE */
        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1100;
        }

        .menu-toggle:hover {
            background: #0056b3;
        }

        /* Para que el contenido no se oculte bajo la barra lateral */
        .content {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
            padding: 20px;
            flex-grow: 1;
        }

        .content.shift {
            margin-left: 250px;
        }

        @media (min-width: 768px) {
            .menu-toggle {
                display: none; /* Ocultar botón en pantallas grandes */
            }
            .sidebar {
                left: 0;
            }
            .content {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
            <!-- Botón para abrir/cerrar menú -->
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>

        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="text-center">
                    <img src="{{ asset('img/Logo_2.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                </div>
                <br>
                <ul class="nav flex-column">
                     <li class="nav-item">
                            @can('user.index')
                                <a class="nav-link" href="{{ route('pendiente.index') }}">Cliente</a>
                            @endcan                           
                        </li>
                        <!-- Puedes agregar más opciones aquí -->
                        <li class="nav-item">
                            @can('producto.index')
                                <a class="nav-link" href="{{ route('productos.index') }}">Producto</a>                                
                            @endcan                            
                        </li>
                         <li class="nav-item">
                            @can('detalle_producto.index')
                                <a class="nav-link" href="{{ route('detalle_productos.index') }}">Detalle del producto</a>
                            @endcan                            
                        </li>

                        <li class="nav-item">
                            @can('importexcel.index')
                                <a class="nav-link" href="{{ route('importexcel') }}">Importar</a>
                            @endcan                            
                        </li>

                        <li class="nav-item">
                            @can('user.index')
                                <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                            @endcan                            
                        </li>

                        <li class="nav-item">
                            @can('roles.index')
                                <a class="nav-link" href="{{ route('roles.index') }}">Lista de roles</a>
                            @endcan                            
                        </li>

                        <li class="nav-item"> 
                            @can('tecnico.index')                           
                            <a class="nav-link" href="{{ route('tecnico.index') }}">Formulario tecnico</a>                                                       
                            @endcan
                        </li>

                        <li class="nav-item"> 
                            @can('asignar.index')                           
                            <a class="nav-link" href="{{ route('asignado.index') }}">Asignados</a>                                                       
                            @endcan
                        </li>
                </ul>
            </div>           

            <!-- Contenido -->
            <div class="content">
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('home') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav me-auto">
        
                            </ul>
        
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif
        
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
        
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>   

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const menuToggle = document.querySelector(".menu-toggle");
    const content = document.querySelector(".content");

    // Abrir/cerrar menú
    menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("open");
        content.classList.toggle("shift");
    });

    // Manejar elementos activos
    const menuItems = document.querySelectorAll(".menu-item");
    const currentPath = window.location.pathname;
    
    // Marcar como activo según la URL actual
    menuItems.forEach(item => {
        const itemPath = new URL(item.href).pathname;
        if (currentPath === itemPath || 
            (currentPath === '/' && itemPath === '/home')) {
            item.classList.add("active");
            // También marcar el elemento li padre si es necesario
            item.closest('li').classList.add("active");
        }
    });

    // Guardar estado en localStorage (opcional)
    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            menuItems.forEach(link => link.classList.remove("active"));
            this.classList.add("active");
            localStorage.setItem("activeMenuItem", this.textContent.trim());
        });
    });
});
    </script>

</body>
</html>
