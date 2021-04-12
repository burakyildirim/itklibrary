<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="PEO-VyAWaKqhbr_mLqA_1Vs7lXn5g8s4x3TWwqP1nnc" />
    <meta name="description" content="İzmir Özel Türk Koleji kütüphanelerinde bulunan kitapları ödünç almak için hızlı ve güçlü bir araç.">
    <meta name="author" content="İzmir Özel Türk Koleji Bilişim Teknolojileri Bölümü, Burak Yıldırım">
    <meta name="generator" content="brkyldrm">

    <title>İTK E-Library #öncelikeğitim</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('frontend/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Temanın varsayılan stil dosyaları -->
    <link href="{{asset('frontend/dist/css/pricing.css')}}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/47521f488e.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

    <!-- jQuery UI -- Sortable ve Autocomplete işlemleri için -->
    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.js')}}"></script>

    <!-- ALERTIFY JS VE CSS DOSYALARI -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <style>
        .alertify .ajs-footer .ajs-buttons .ajs-button {
            font-weight: bold;
            border-radius: 5px;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
{{--    <div class="container">--}}
    <div class="container">

    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="brand-link" href="{{route('welcome.Index')}}">{{config('app.name')}}</a></h5>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome.Index')}}">ANASAYFA</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        PROFİLİM
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Hesap Bilgilerim</a>
                        <a class="dropdown-item" href="#">Favorilerim</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Rezervasyonlarım</a>
                    </div>
                </li>

            </ul>

        @if (Route::has('login'))
            @auth
                <span class="navbar-text">
                    <img style="width: 32px;" class="rounded-circle" src="@php echo Auth::user()->avatar == null ? asset('images/user_head.png') : Auth::user()->avatar @endphp" alt="">
                    <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Hoşgeldin, {{ Auth::user()->name }}.</a>

                    <a href="#" class="btn btn-primary btn-sm" style="color:white; font-weight: bold;">
                        PUAN <span class="badge badge-warning">{{Auth::user()->puan}}</span>
                    </a>

                    <a href="{{ route('logout') }}" class="btn btn-sm btn-danger" style="color:white;"
                       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        Güvenli Çıkış
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                </span>
            @else
                <span class="navbar-text">
                    <a class="btn btn-danger" style="color:white;" href="{{route('login')}}">Giriş Yap</a>
                    <a class="btn btn-primary" style="color:white;" href="{{route('register')}}">Üye Ol</a>
                </span>
            @endauth

        @endif
        </div>
    </div>
{{--    </div>--}}
</nav>


<div class="container">
    @yield('content')


</div>

<footer class="pt-4 my-md-5 pt-md-5 border-top" style="z-index:-5;">
        <div class="col-12 col-md text-center">
            @auth()
                @if((Auth::user()->role == 1 || Auth::user()->role == 3))
                    <a href="{{route('admin.Index')}}" class="btn btn-sm btn-danger">Yönetici Paneli</a>
                    <br><br><br>
                @endif
            @endauth
            <small class="d-block mb-3 text-muted">&copy; 2021 İTK Bilişim Teknolojileri Bölümü | Powered by
                brkyldrm</small>
        </div>
</footer>


<!-- jQuery -->
<script src="{{asset('frontend/dist/js/bootstrap.js')}}"></script>


</body>


</html>
