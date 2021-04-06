<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="İzmir Özel Türk Koleji kütüphanelerinde bulunan kitapları ödünç almak için hızlı ve güçlü bir araç.">
    <meta name="author" content="İzmir Özel Türk Koleji Bilişim Teknolojileri Bölümü, Burak Yıldırım">
    <meta name="generator" content="brkyldrm">

    <title>İTK-Library | #öncelikeğitim</title>

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
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="brand-link" href="{{route('welcome.Index')}}">E-Library</a></h5>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">

        </ul>
        @if (Route::has('login'))
            @auth
                <span class="navbar-text">
                    <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Hoşgeldin, {{ Auth::user()->name }}.</a>
                    Kütüphane Puanın <span class="badge badge-primary">{{Auth::user()->puan}}</span>

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
</nav>


<div class="container">
    @yield('content')

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md text-center">
                <small class="d-block mb-3 text-muted">&copy; 2021 İTK Bilişim Teknolojileri Bölümü | Powered by
                    brkyldrm</small>
            </div>
        </div>
    </footer>
</div>



<!-- jQuery -->
<script src="{{asset('frontend/dist/js/bootstrap.js')}}"></script>

</body>


</html>
