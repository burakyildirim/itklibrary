@extends('frontend.layout')
@section('title','#öncelikeğitim')

@section('content')
    <style>
        .yazarLi {
            margin-left: 10px;
            list-style-type: none;
        }

        #book_name {
            -webkit-box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
            -moz-box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
            box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
        }

        .display-4 {
            height: 100px;
            line-height: 70px;
        }

        #bookList {
            display: none;
            position: absolute;
            border-left: 1px solid #7ebafa;
            border-bottom: 1px solid #7ebafa;
            border-right: 1px solid #7ebafa;
            padding-right: 20px;
            width: 100%;
            background-color: white;
            margin-top: -15px;
            z-index: 5;
            padding-right: 5px;
            margin-left: -15px;
            padding-top: 15px;
            border-radius: 5px;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            -webkit-box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
            -moz-box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
            box-shadow: 0px 3px 13px -2px rgba(0, 0, 0, 0.46);
        }

        #bookList ul {
            padding-left: 0px;
        }

        .card:hover {
            -webkit-box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
            box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
        }

        .card {
            border-color: #e9e4e4;
            transition: 0.4s;

        }

        .shelf_head {
            height: 39px;
            background: url('{{asset('images/shelf_head_bg2.jpg')}}') top left no-repeat;
            background-size: 100%;

        }

        .books_long_slider_w {
            margin-top: -4px;
            background: url('{{asset('images/shelf_bg.jpg')}}') top left repeat;
            background-size: 100%;
            padding: 20px 8px;
            height: 610px;
            margin-bottom: 25px;
        }

        ul.books_long_slider {
        }

        .books_long_slider li {
            float: left;
            display: block;
            position: relative;
            height: 157px;
            width: 120px;
            margin-bottom: 52px;
            text-align: center;
        }

        .books_long_slider li img {
            box-shadow: 0px -4px 18px #332000;
            position: absolute;
            bottom: 0px;
            left: 12px;
            width:90px;
            transition: 300ms;
        }

        .books_long_slider li img:hover {
            bottom: 10px;
        }

        .books_long_slider li img {
            box-shadow: 0px -4px 18px #332000;
            position: absolute;
            bottom: 0px;
            left: 12px;
            width:90px;
            transition: 300ms;
        }

    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <img class="img-fluid" src="{{asset('/images/itk_kutuphane_logo.png')}}" style="max-width: 350px;">
        <h1 class="display-4" style="font-weight: lighter; font-size: 45px;">
            <span class="typewrite" data-period="2000"
                  data-type='["{{config('app.name')}}","Hoşgeldin!","Welcome!","Benvenuto!","Bienvenue!","Willkommen!"]'>
                <span class="wrap"></span>
            </span>
        </h1>

        <p class="lead">Aradığınız kitabın hangi kütüphanelerimizde olduğunu öğrenmek için hızlı ve etkili bir araç.
            İstediğiniz kitap için rezervasyon yaptırabilir ve ilgili kütüphanemizden ödünç alabilirsiniz. Kitap
            okuyarak kazandığınız puanlarla sahip olabileceğiniz sürpriz ödüller sizleri bekliyor! <span
                style="color:#cf352d;"><i class="fas fa-heart"></i></span> <span style="color:#2684b7;"><i
                    class="fas fa-book-reader"></i></span></p>
    </div>

    <div class="col-lg-10 offset-lg-1">
        <form id="bookSearchBox" method="post">
            @csrf
            <div class="form-group row">
                <div class="input-group">
                    <input type="text" id="book_name" name="book_name" autocomplete="off"
                           class="form-control form-control-lg" placeholder="Kitap yada yazar adı giriniz" autofocus>
                </div>
            </div>
        </form>
        <div id="bookList">
        </div>
    </div>

    <div class="row" style="margin-top:50px;">
        <div class="col-lg-12">
            <h1 class="display-5" style="margin-bottom: 0px; font-weight:lighter;">Son Eklenen Kitaplar</h1>
            <hr style=""/>

            <div class="card-deck">
                @foreach($sonEklenenKitaplar as $sonEklenenKitap)
                    <div class="card">
                        <img class="card-img-top"
                             src="{{ $sonEklenenKitap->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$sonEklenenKitap->book_image}}"
                             alt="Kitap Kapağı" style="height: 22vw; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{$sonEklenenKitap->book_name}}</h5>
                            <p class="card-text text-muted">
                                - {{$sonEklenenKitap->book_author}}
                            </p>
                            <p class="card-text">{!! substr(strip_tags($sonEklenenKitap->book_description),0,250).'...' !!}</p>
                            {{--                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>--}}

                        </div>
                        <div class="card-footer"
                             style="padding:0px; border-top-right-radius:0px; border-top-left-radius:0px; border-bottom-right-radius: 1px; border-bottom-left-radius: 1px;">
                            <a class="btn btn-warning btn-lg"
                               style="width: 100%; border-top-right-radius:0px; border-top-left-radius:0px;"
                               href="{{url('kitap').'/'.$sonEklenenKitap->id.'/'.$sonEklenenKitap->book_slug.'#disqus_thread'}}">Kitap
                                Sayfasına Git</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row d-none d-sm-block" style="margin-top:50px;">
        <div class="col-lg-12">

            <h1 class="display-5" style="margin-bottom: 0px; font-weight:lighter; text-align: right;">İTK Dijital
                Yayınlar</h1>
            <hr style=""/>

            <div class="col-lg-12" style="padding: 0px;">


                <div class="shelf_head"></div>
                <div class="books_long_slider_w">
                    <ul class="books_long_slider">
                        @foreach($sonDijitalYayinlar as $dijitalYayin)
                            <li>
                                <a href="{{route('frontend.ebooks.show','').'/'.$dijitalYayin->unique_key}}"
                                   title="{{$dijitalYayin->ebooks_name}} - @foreach($dijitalYayin->levels as $level) {{$level->levelName}}, @endforeach">
                                    <img src="{{ $dijitalYayin->ebooks_image == null ?  url('/images/books/default.jpg'): url('/images/ebooks')."/".$dijitalYayin->ebooks_image}}"></a>


                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script id="dsq-count-scr" src="//itklibrary.disqus.com/count.js" async></script>

    <script>

        // $('.card').mouseover(function () {
        //     $(this).animate({marginLeft: '9px'}, 'slow');
        // });

        var TxtType = function (el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 4000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };

        TxtType.prototype.tick = function () {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

            var that = this;
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) {
                delta /= 2;
            }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function () {
                that.tick();
            }, delta);
        };

        window.onload = function () {
            var elements = document.getElementsByClassName('typewrite');
            for (var i = 0; i < elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-type');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtType(elements[i], JSON.parse(toRotate), period);
                }
            }
            // INJECT CSS
            var css = document.createElement("style");
            css.type = "text/css";
            css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
            document.body.appendChild(css);
        };
    </script>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {
            $('#bookSearchBox').keypress(
                function (event) {
                    if (event.which == '13') {
                        event.preventDefault();
                    }

                    // $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                });

            $('#book_name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "{{route('welcome.kitapAra')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            token: $('meta[name="csrf-token"]').attr('content'),
                            query: query,
                            _method: 'POST'
                        },
                        success: function (data) {
                            $('#bookList').fadeIn();
                            $('#bookList').html(data);
                        }
                    })
                }

                $('#book_name').on('focusout', function () {
                    $('#bookList').fadeOut();
                });

                $(document).on('click', '#bookList li', function () {
                    $('#bookList').val($(this).text());
                    $('#bookList').fadeOut();
                });
            });
        });
    </script>
@endsection


@section('css')@endsection
@section('js')@endsection
