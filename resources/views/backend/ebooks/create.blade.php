@extends('backend.layout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">E-Kitap Yükle</h5>
                </div>
                <div class="card-body">
{{--                    {{route('libraries.store')}}--}}
                    <form action="{{route('ebooks.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>E-Kitap Adı</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="ebooks_name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Sınıf Seviyeleri</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="ebooks_seviye">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Açıklama</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="ebooks_description" id="editor1">
                                            </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Flipbook Dosyası(Sıkıştırılmış ZIP)</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="file" name="ebook_file">
                                </div>
                            </div>
                        </div>

                        <script>
                            CKEDITOR.replace( 'editor1' );
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

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
