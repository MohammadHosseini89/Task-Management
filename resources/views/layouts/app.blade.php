<x-laravel-ui-adminlte::adminlte-layout>

    {{-- <link rel="stylesheet" href="{{ asset('vendor/livewire-charts/app.css') }}"> --}}
    <script src="{{ asset('vendor/livewire-charts/app.js') }}"></script>
    <style src="{{ asset('vendor/all.min.css') }}"></style>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/livewire/livewire.js') }}"></script> --}}
    {{-- @livewireChartsScripts --}}

    <style>
        .main-header {
            background:
                rgba(238, 232, 232, 0.99);

            /* background-image: url('{{ asset('images/test1.webp') }}');
            background-size: cover;
            background-position: top; */
        }

        .main-footer {

            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0.99),
                    rgba(244, 231, 231, 0.66));
            /* background-image: url('{{ asset('images/test27.jpg') }}');
            background-size: cover;
            background-position: bottom; */
        }

        .main-sidebar {

            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0.99),
                    rgba(244, 231, 231, 0.66));
            /* background-image: url('{{ asset('images/test1.webp') }}');
            background-size: cover;
            background-position: right; */
        }
    </style>

    @livewireStyles

    <body class="hold-transition sidebar-mini layout-fixed ">
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            {{-- <img src="https://cdn-icons-png.flaticon.com/512/3631/3631053.png"
                                class="user-image img-circle elevation-2" alt="User Image"> --}}
                            <span style="color:rgb(32, 7, 142)"
                                class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-light">
                                {{-- <img src= "{{ asset('images/back8.jpg') }}"
                                    class="img-circle elevation-2" alt="User Image"> --}}
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="{{ route('reset-password') }}" class="btn btn-primary float-right">Reset
                                    Password</a>
                                <a href="#" class="btn btn-danger btn-flat float-left"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper bg-custom">

                {{ $slot }}

            </div>


            <div>
                <!-- Main Footer -->
                <footer class="main-footer">
                    <strong>Mohammad Hosseini Copyright &copy; 2024</strong> All rights
                    reserved.
                </footer>
            </div>

            @stack('scripts')

            @livewireScripts
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
