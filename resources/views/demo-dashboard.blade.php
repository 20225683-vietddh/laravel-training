<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Light Bootstrap Dashboard - Laravel Demo</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- CSS Files -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-5.jpg') }}">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        Light Bootstrap Dashboard Laravel
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-notes"></i>
                            <p>Table List</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"> Dashboard </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Light Bootstrap Dashboard Laravel Demo</h4>
                                    <p class="card-category">Template đã được tích hợp thành công</p>
                                </div>
                                <div class="card-body demo-page">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Các thành phần đã tích hợp:</h5>
                                            <ul>
                                                <li>✅ Template Light Bootstrap Dashboard</li>
                                                <li>✅ Bootstrap 5</li>
                                                <li>✅ SCSS compilation với Vite</li>
                                                <li>✅ JavaScript modules</li>
                                                <li>✅ Custom styles</li>
                                                <li>✅ Font và Icon integration</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cấu trúc file:</h5>
                                            <pre>
resources/
├── sass/
│   ├── app.scss (main file)
│   ├── custom.scss
│   ├── light-bootstrap-dashboard.scss
│   └── lbd/ (template files)
├── js/
│   ├── app.js
│   ├── light-bootstrap-dashboard.js
│   └── demo.js
public/
├── build/ (compiled assets)
├── img/ (images)
└── fonts/ (fonts)
                                            </pre>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-custom">Custom Button</button>
                                            <button type="button" class="btn btn-primary">Primary Button</button>
                                            <button type="button" class="btn btn-success">Success Button</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>