@extends('backend.layout')


@section('content')

    <style>
        .yazarLi{
            margin-left:10px;
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

                        <div class="form-group">
                            <label>Kütüphane</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Seçiniz</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="libraries_id">
                                    @foreach($userLibraries as $library)
                                        <option value="@php echo $library->id @endphp">@php echo $library->libraries_name @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap Adı</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="book_name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>ISBN Numarası</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="number" name="book_isbn" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap Görseli</label>
                            <div class="row">
                                <div class="col-xs-12">
                                    <input class="form-control-file" name="book_image" type="file">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Yazar</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="book_author" id="book_author" autocomplete="off" required>
                                    <div id="authorList">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Yayınevi</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="book_publisher" id="book_publisher" autocomplete="off" required>
                                    <div id="publisherList">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Yayın Tarihi</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="book_publishDate" autocomplete="off" class="publishDate"
                                           data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap Açıklaması</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="book_description" id="editor1">
                                            </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap Görünürlüğü</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="custom-select" id="inputGroupSelect01" name="book_visStatus">
                                        @foreach($visStatus as $visStat)
                                            <option {{\App\Models\Books::getVisStatusID($visStat)=='1'?'selected':''}} value="@php echo \App\Models\Books::getVisStatusID($visStat); @endphp">@php echo $visStat @endphp</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap Dili</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="custom-select" id="inputGroupSelect01" name="book_language">
                                        @foreach($languages as $language)
                                            <option {{\App\Models\Books::getLanguageID($language)=='1'?'selected':''}} value="@php echo \App\Models\Books::getLanguageID($language); @endphp">@php echo $language @endphp</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Stok Adedi</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="number" name="book_stok" value="1" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kitap SLUG</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="book_slug" autocomplete="off" disabled>
                                </div>
                            </div>
                        </div>

                        <script>
                            CKEDITOR.replace('editor1');
                        </script>


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
            $(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $(document).ready(function(){
                $('#book_author').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        $.ajax({
                            url:"{{route('books.yazarAra')}}",
                            type:"POST",
                            dataType:'json',
                            data:{
                                token: $('meta[name="csrf-token"]').attr('content'),
                                query:query,
                                _method: 'POST'
                            },
                            success:function (data) {
                                $('#authorList').fadeIn();
                                $('#authorList').html(data);
                            }
                        })
                    }

                    $('#book_author').on('focusout', function(){
                        $('#authorList').fadeOut();
                    });

                    $(document).on('click', '#authorList li', function(){
                        $('#book_author').val($(this).text());
                        $('#authorList').fadeOut();
                    });
                });

                $('#book_publisher').keyup(function(){
                    var query2 = $(this).val();
                    if(query2 != '')
                    {
                        $.ajax({
                            url:"{{route('books.yayineviAra')}}",
                            type:"POST",
                            dataType:'json',
                            data:{
                                token: $('meta[name="csrf-token"]').attr('content'),
                                publisherQuery:query2,
                                _method: 'POST'
                            },
                            success:function (data) {
                                $('#publisherList').fadeIn();
                                $('#publisherList').html(data);
                            }
                        })
                    }

                    $('#book_publisher').on('focusout', function(){
                        $('#publisherList').fadeOut();
                    });

                    $(document).on('click', '#publisherList li', function(){
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
