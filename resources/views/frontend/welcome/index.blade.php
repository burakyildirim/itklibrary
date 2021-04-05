@extends('frontend.layout')


@section('content')
    <style>
        .yazarLi{
            margin-left:10px;
            list-style-type: none;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <img class="img-fluid" src="{{asset('backend/dist/img/itk_arma.png')}}" style="max-width: 120px;">
        <h1 class="display-4"><strong>İTK E-Library</strong>'e hoşgeldin!</h1>
        <p class="lead">Aradığınız kitabın hangi kütüphanelerimizde olduğunu öğrenmek için hızlı ve etkili bir araç.
            İstediğiniz kitap için rezervasyon yaptırabilir ve ilgili kütüphanemizden ödünç alabilirsiniz. Kitap
            okuyarak kazandığınız puanlarla sahip olabileceğiniz sürpriz ödüller sizleri bekliyor! <span style="color:#cf352d;"><i class="fas fa-heart"></i></span> <span style="color:#2684b7;"><i class="fas fa-book-reader"></i></span></p>
    </div>

    <div class="col-lg-12">
        <form method="post">
            @csrf
            <div class="form-group row">
                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                <div class="input-group mb-2 offset-lg-1 col-lg-10">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span style="color:#2684b7;"><i class="fas fa-book"></i></span>
                        </div>
                    </div>
                    <input type="text" id="book_name" name="book_name" autocomplete="off" class="form-control form-control-lg" id="inlineFormInputGroup" placeholder="Kitap adı giriniz">

                </div>
            </div>
        </form>
        <div class="col-lg-12"></div>
            <div id="bookList">
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function() {
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
