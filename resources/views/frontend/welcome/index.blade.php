@extends('frontend.layout')


@section('content')
    <style>
        .yazarLi{
            margin-left:10px;
            list-style-type: none;
        }

        #book_name{
            -webkit-box-shadow: 0px 3px 13px -2px rgba(0,0,0,0.46);
            -moz-box-shadow: 0px 3px 13px -2px rgba(0,0,0,0.46);
            box-shadow: 0px 3px 13px -2px rgba(0,0,0,0.46);
        }

        .display-4{
            height:150px;
            line-height: 70px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <img class="img-fluid" src="{{asset('backend/dist/img/itk_arma.png')}}" style="max-width: 120px;">
        <h1 class="display-4"><span class="typewrite" data-period="2000" data-type='["İTK E-Library","Hoşgeldin!","Welcome!","Benvenuto!","Bienvenue!","Willkommen!"]'><span class="wrap"></span></span></h1>
        <p class="lead">Aradığınız kitabın hangi kütüphanelerimizde olduğunu öğrenmek için hızlı ve etkili bir araç.
            İstediğiniz kitap için rezervasyon yaptırabilir ve ilgili kütüphanemizden ödünç alabilirsiniz. Kitap
            okuyarak kazandığınız puanlarla sahip olabileceğiniz sürpriz ödüller sizleri bekliyor! <span style="color:#cf352d;"><i class="fas fa-heart"></i></span> <span style="color:#2684b7;"><i class="fas fa-book-reader"></i></span></p>
    </div>

    <div class="col-lg-10 offset-lg-1">
        <form id="bookSearchBox" method="post">
            @csrf
            <div class="form-group row">
                <div class="input-group">
                    <input type="text" id="book_name" name="book_name" autocomplete="off" class="form-control form-control-lg" placeholder="Kitap adı giriniz">
                </div>
            </div>
        </form>
            <div id="bookList">
            </div>
    </div>

    <script>
        var TxtType = function(el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 4000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };

        TxtType.prototype.tick = function() {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

            var that = this;
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) { delta /= 2; }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function() {
                that.tick();
            }, delta);
        };

        window.onload = function() {
            var elements = document.getElementsByClassName('typewrite');
            for (var i=0; i<elements.length; i++) {
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
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function() {
            $('#bookSearchBox').keypress(
                function(event){
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
                    // $('#bookList').fadeOut();
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
