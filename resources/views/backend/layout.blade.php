<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <META http-equiv=content-type content=text/html;charset=iso-8859-9>
    <META http-equiv=content-type content=text/html;charset=windows-1254>
    <META http-equiv=content-type content=text/html;charset=x-mac-turkish>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ITK Library | Yönetim Paneli</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{asset('backend/custom/css/custom.css')}}">

    <!-- Bootstrap DatePicker CSS -->
    <link rel="stylesheet" href="{{asset('backend/custom/css/bootstrap-datepicker.min.css')}}">

    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

    <!-- jQuery UI -- Sortable ve Autocomplete işlemleri için -->
    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.js')}}"></script>
{{--    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.css')}}"></script>--}}

<!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>

    <!-- ALERTIFY JS VE CSS DOSYALARI -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <!-- SELECT2 JS VE CSS DOSYALARI -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <style>
        .table > tbody > tr > td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('admin.Index')}}" class="nav-link">Yönetim Anasayfa</a>
            </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        Profil Ayarları
                    </a>


                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"
                       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        Güvenli Çıkış
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('settings.Index')}}" class="brand-link">
            <img src="{{asset('backend/dist/img/itk_arma.png')}}" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">ITK Library</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                {{--                <div class="image">--}}
                {{--                    <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">--}}
                {{--                </div>--}}
                <div class="info">
                    <a href="#" class="d-block">Merhaba, {{Auth::user()->name}}.</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">
                        <a href="{{route('admin.Index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Yönetim Anasayfa
                                <span class="right badge badge-danger">!</span>
                            </p>
                        </a>
                    </li>

                    @if(Auth::user()->role == 1)
                        <li class="nav-item">
                            <a href="{{route('settings.Index')}}" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Genel Site Ayarları
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('libraries.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Kütüphaneler
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Kullanıcı Yönetimi
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{route('books.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Kitap Yönetimi
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('rents.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                Kitap Rezervasyon
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Modüler bir yapıyla default/index içerisinde -->
    @yield('content')

    <!-- Yönetim paneli içerik kısmı -->
        <div class="content">
            <div class="container-fluid">

            </div>
        </div>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Powered by brkyldrm
        </div>
        <!-- Default to the left -->
        <strong>İTK Bilişim Teknolojileri Bölümü &copy; 2021 | itklibrary v0.1</strong>
    </footer>
</div>
<!-- ./wrapper -->


@if(session()->has('success'))
    <script>
        alertify.success('{{session('success')}}');
    </script>
@endif

@if(session()->has('error'))
    <script>
        alertify.error('{{session('error')}}');
    </script>
@endif

@foreach($errors->all() as $error)
    <script>
        alertify.error('{{$error}}');
    </script>
@endforeach
</body>
</html>
