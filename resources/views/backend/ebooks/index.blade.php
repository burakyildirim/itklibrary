@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">E-Kitap Yönetimi</h5>
                </div>
                <div class="card-body">
                    <div align="right">
                        <a href="{{route('ebooks.create')}}">
                            <button class="btn btn-success">Ekle</button>
                        </a>
                    </div>
                    <div class="row" style="margin-bottom:20px;">
                        e- kitaplar için yönetim karşılama sayfası. listeleme ve arama yapılacak.
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

    </script>

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
