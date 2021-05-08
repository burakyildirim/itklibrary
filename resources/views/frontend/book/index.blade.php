@extends('frontend.layout')
@section('title',$kitapDetay->book_name)

@section('content')
    <style>
        .img-thumbnail {
            -webkit-box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
            -moz-box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
            box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row" style="padding-top:30px;">
        @auth
            @if($tarafimcaRezerve)
                <div class="col-lg-12">
                    <div class="alert alert-warning" role="alert">
                        Bu kitap için rezervasyonunuz var!<br/>
                        <strong>Rezerv.
                            Durumu: </strong> {{\App\Models\Rents::RentStatuses[$myrentdetails->rent_status]}}<br/>
                        <strong>Son Teslim Tarihi: </strong> {{date('d.m.Y',strtotime($myrentdetails->rentEndDate))}}
                        <br/>
                    </div>
                </div>
            @endif

            @if($kitapDetay->book_rentStatus==0 && $mostNearDeliveryDate!=null)
                <div class="col-lg-12">
                    <div class="alert alert-info" role="alert">
                        <strong>Bu kitabın en yakın uygunluk
                            tarihi: </strong> {{ date('d.m.Y',strtotime($mostNearDeliveryDate->rentEndDate)) }}<br/>
                    </div>
                </div>
            @endif

        @endauth

        <div class="col-lg-3 col-sm-12" style="text-align: center;">
            <img
                src="{{ $kitapDetay->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$kitapDetay->book_image}}"
                alt="" class="img-thumbnail">
            <hr>
            <div id="libraryDetail" data-html="true" data-toggle="tooltip" data-placement="right" title="<strong>{{$kitapDetay->library['libraries_name']}}</strong><br/><strong>Tel: </strong>{{$kitapDetay->library['libraries_phone']}}<br/><strong>Sorumlu: </strong>{{$sorumlu->name}}">
                <strong>Bulunduğu Kütüphane:</strong>
                {{$kitapDetay->library['libraries_name']}}
            </div>
            <hr/>
            @auth

                @if($kitapDetay->book_rentStatus==1 && !$tarafimcaRezerve)

                    <form method="GET">
                        @csrf
                        <input type="hidden" name="xxxxx" id="xxxxx" value="66">
                        <input type="hidden" id="hidden_slug" value="{{$kitapDetay->book_slug}}">
                        {{--                        <button id="btnRezerve" value="{{$kitapDetay->id}}" class="btn btn-lg btn-success" onclick="javascript:void(0)" style="width: 100%;">Rezerve Et</button>--}}

                        <a id="btnRezerve" value="{{$kitapDetay->id}}" class="btn btn-lg btn-success"
                           style="width: 100%;" href="javascript:void(0)">Rezerve Et</a>
                    </form>
                    <hr/>
                @else
                    <div class="alert alert-danger" role="alert">
                        Bu kitap şuanda rezervasyon için uygun değil!
                    </div>
                    <hr/>
                @endif
            @endauth

            @guest
                <div class="alert alert-secondary" role="alert">
                    Bu kitaba rezervasyon oluşturmak için lütfen <a href="{{route('login')}}">giriş</a> yapınız.
                </div>
                <hr/>
            @endguest
        </div>

        <div class="col-lg-9">
            <div class="col-lg-12" style="text-align: center;">
                <h1 class="display-4" style="font-size:35pt;">{{$kitapDetay->book_name}}</h1>

            </div>
            <hr/>
            <div class="col-lg-12">
                <strong>Yazar:</strong>
                {{$kitapDetay->book_author}}
            </div>
            <div class="col-lg-12"><strong>ISBN:</strong> {{$kitapDetay->book_isbn}}</div>
            <div class="col-lg-12"><strong>Basım
                    Yılı:</strong> {{ date('d.m.Y',strtotime($kitapDetay->book_publishDate)) }}</div>
            <div class="col-lg-12"><strong>Yayınevi:</strong> {{$kitapDetay->book_publisher}}</div>
            <div class="col-lg-12"><strong>Kitap
                    Dili:</strong> {{\App\Models\Books::Languages[$kitapDetay->book_language]}}</div>

            <hr/>

            <div class="col-lg-12">{!!$kitapDetay->book_description!!}</div>

        </div>

        {{--        <div class="col-lg-12">--}}
        {{--            <hr/>--}}
        {{--            @guest--}}
        {{--                <div class="alert alert-info" role="alert">--}}
        {{--                    Yorum yapmak için lütfen <a href="{{route('login')}}">giriş</a> yapınız.<br/>--}}
        {{--                </div>--}}
        {{--                @endguest--}}
        {{--            @auth--}}

        {{--            @endauth--}}
        {{--        </div>--}}

    </div>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {

            $('#btnRezerve').click(function () {

                alertify.confirm('Rezervasyon yapmak istediğinize emin misiniz?', 'Bu kitap için rezervasyon yaptırdığınızda 2 haftalık bir ödünç alma sürecini başlatmış olursunuz ve kitabın bulunduğu kütüphanedeki sorumlu personel ile iletişime geçip hem işleminizi onaylatmalı hem de kitabı teslim almalısınız.<br/><br/><p class="text-info">Teslim tarihinizde değişiklik yapmak isterseniz kütüphane görevlisine bilgi vermeyi unutmayınız!</p>',
                    function () {
                        var bookId = $('#btnRezerve').attr('value');
                        var bookSlug = $('#hidden_slug').attr('value');

                        $.ajax({
                            url: "{{ url('/reservation') }}" + "/" + bookId + "/" + bookSlug,
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (data) {
                                alertify.alert(data['baslik'], data['metin'], function () {
                                    setTimeout(location.reload.bind(location), 500);
                                }).set('labels', {ok: 'Tamam'});

                            },
                            failed: function (data) {
                                alertify.confirm(data, 'Kitap rezervasyonu yapılamadı.<br/><br/><p class="text-warning">Beklenmeyen bir hata oluştu! Site yöneticisi ile iletişime geçin.</p>');
                            },
                        })
                    },
                    function () {
                        alertify.error('Rezervasyon işlemi gerçekleştirilmedi!');
                    }).set('labels', {ok: 'Rezerve Et', cancel: 'İptal'})
            })
        });

    </script>

    <script>
        $(function () {
            $('#libraryDetail').tooltip()
        })
    </script>

    <!-- jQuery UI -- Sortable ve Autocomplete işlemleri için -->
    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script src="{{asset('frontend/dist/js/bootstrap.js')}}"></script>

@endsection


@section('css')@endsection
@section('js')@endsection
