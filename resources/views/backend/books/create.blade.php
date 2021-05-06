@extends('backend.layout')


@section('content')

    <style>
        .yazarLi {
            margin-left: 10px;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kitap Ekle</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('books.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Kitap Adı</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" id="book_name" type="text" name="book_name"
                                               autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>ISBN Numarası</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="number" name="book_isbn" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Kütüphane</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Seçiniz</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="libraries_id">
                                        @foreach($userLibraries as $library)
                                            <option
                                                value="@php echo $library->id @endphp">@php echo $library->libraries_name @endphp</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Yazar</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="book_author" id="book_author"
                                               autocomplete="off" required>
                                        <div id="authorList">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Yayınevi</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="book_publisher"
                                               id="book_publisher" autocomplete="off" required>
                                        <div id="publisherList">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Yayın Tarihi</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="book_publishDate"
                                               autocomplete="off" class="publishDate"
                                               data-provide="datepicker" data-date-format="dd.mm.yyyy" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Kitap Görseli</label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input class="form-control-file" name="book_image" id="kitap_gorselBox"
                                               type="file">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col">
                                <label>Kitap Açıklaması</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                            <textarea class="form-control" name="book_description" id="editor1">
                                                    </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col">
                                <label>Kitap Görünürlüğü</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select class="custom-select" id="inputGroupSelect01" name="book_visStatus">
                                            @foreach($visStatus as $visStat)
                                                <option
                                                    {{\App\Models\Books::getVisStatusID($visStat)=='1'?'selected':''}} value="@php echo \App\Models\Books::getVisStatusID($visStat); @endphp">@php echo $visStat @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Kitap Dili</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select class="custom-select" id="inputGroupSelect01" name="book_language">
                                            @foreach($languages as $language)
                                                <option
                                                    {{\App\Models\Books::getLanguageID($language)=='1'?'selected':''}} value="@php echo \App\Models\Books::getLanguageID($language); @endphp">@php echo $language @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Stok Adedi</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="number" name="book_stok" value="1"
                                               autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col">
                                <label>Kitap SLUG</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="book_slug" autocomplete="off"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Kitap Raf</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select class="custom-select" id="inputGroupSelect02" name="book_raf">
                                            @foreach(\App\Models\Books::Rafs as $raf)
                                                <option value="@php echo $raf @endphp">@php echo $raf @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Raf Sıra</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select class="custom-select" id="inputGroupSelect02" name="book_sira">
                                            @foreach(\App\Models\Books::Siras as $sira)
                                                <option value="@php echo $sira @endphp">@php echo $sira @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            CKEDITOR.replace('editor1');
                        </script>

                        <div class="form-group" style="margin-top:30px;">
                            <div align="left" class="card-footer">
                                İdefix Link:<input class="form-control" type="text" id="kitapYurduLinkBox"
                                                   name="kitap_link">
                            </div>
                            <div class="card-footer">
                                <img alt="" width="170px" id="idefixKitapResim">
                                <input type="hidden" id="idefixHiddenResimName" name="hiddenResimDosyasi">
                            </div>
                            <div align="right" class="card-footer">
                                <a id="btnBilgiCek" href="javascript:void(0)">VERİLERİ ÇEK</a>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:30px;">
                            <div align="right" class="card-footer">
                                <button type="submit" class="btn btn-success">Ekle</button>
                            </div>
                        </div>

                    </form>
                </div>


            </div>

        </div>
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
            $('#btnBilgiCek').click(function () {

                alertify.confirm('Kitap bilgilerini idefix adresinden çekmek istediğinize emin misiniz?', 'idefix üzerinden çekilen verilerin doğruluğunu mutlaka kontrol edin!',
                    function () {
                        var bookKitapYurduLink = $('#kitapYurduLinkBox').val();
                        // console.log(bookKitapYurduLink);

                        $.ajax({
                            url: "{{ route('books.KitapYurduSearchName','') }}/" + bookKitapYurduLink,
                            type: 'get',
                            ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                            dataType: 'json',
                            data: {
                                token: $('meta[name="csrf-token"]').attr('content'),
                                link: bookKitapYurduLink
                            },
                            success: function (data) {
                                CKEDITOR.instances.editor1.setData(data['metin'][0]);
                                // var kitabinAdi = ;
                                // var yazarinAdi = ;
                                // var yayinEviAdi = ;

                                $('#book_name').val(data['kitapAdi']);
                                $('#book_author').val(data['yazarAdi']);
                                $('#book_publisher').val(data['yayineviAdi']);

                                // console.log(data['kitapResimLink'][1][0]);
                                $('#idefixKitapResim').attr("src", data['kitapResimLink'][1][0]);

                                $('#idefixHiddenResimName').val(data['dosyaAdi']);
                                $('#kitap_gorselBox').prop('disabled', true);

                                // console.log(data[1].split("<li>")[2].split("<a class=\"bold authorr\" href=\"/Yazar/gulseren-budayicioglu/s=265093\">")[1].split("</a>")[0]);
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 200);
                            },
                            failed: function (data) {
                                alertify.error(data);
                                console.log(data);
                            },
                        })
                    },
                    function () {
                        alertify.error('Rezervasyon işlemi gerçekleştirilmedi!');
                    }).set('labels', {ok: 'Verileri Çek', cancel: 'İptal'})
            });

            $('#book_author').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "{{route('books.yazarAra')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            token: $('meta[name="csrf-token"]').attr('content'),
                            query: query,
                            _method: 'POST'
                        },
                        success: function (data) {
                            $('#authorList').fadeIn();
                            $('#authorList').html(data);
                        }
                    })
                }

                $('#book_author').on('focusout', function () {
                    $('#authorList').fadeOut();
                });

                $(document).on('click', '#authorList li', function () {
                    $('#book_author').val($(this).text());
                    $('#authorList').fadeOut();
                });
            });

            $('#book_publisher').keyup(function () {
                var query2 = $(this).val();
                if (query2 != '') {
                    $.ajax({
                        url: "{{route('books.yayineviAra')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            token: $('meta[name="csrf-token"]').attr('content'),
                            publisherQuery: query2,
                            _method: 'POST'
                        },
                        success: function (data) {
                            $('#publisherList').fadeIn();
                            $('#publisherList').html(data);
                        }
                    })
                }

                $('#book_publisher').on('focusout', function () {
                    $('#publisherList').fadeOut();
                });

                $(document).on('click', '#publisherList li', function () {
                    $('#book_publisher').val($(this).text());
                    $('#publisherList').fadeOut();
                });
            });
        });
    </script>

    <script src="{{asset('backend/custom/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

@section('css')@endsection
@section('js')@endsection
