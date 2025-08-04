<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', 'Laravel CRUD Demo') - Light Bootstrap Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- CSS Files -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    @yield('extra_css')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-5.jpg') }}">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="{{ route('users.index') }}" class="simple-text">
                        Laravel CRUD Demo
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Users Management</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-notes"></i>
                            <p>Tasks Management</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-key-25"></i>
                            <p>Roles Management</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('demo.dashboard') }}">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Demo Dashboard</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"> @yield('page_title', 'Dashboard') </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Breadcrumb -->
                    @if(isset($breadcrumbs))
                    <div class="row">
                        <div class="col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach($breadcrumbs as $breadcrumb)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>
                        </div>
                    </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <p class="copyright text-center">
                            ©{{ date('Y') }} Laravel CRUD Demo với Light Bootstrap Dashboard
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>

    @yield('extra_js')
</body>

</html>