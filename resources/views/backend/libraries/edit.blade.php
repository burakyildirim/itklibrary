@extends('backend.layout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kütüphane Güncelle</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('libraries.update',$libraries->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="form-group">
                            <label>Kütüphane Adı</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="libraries_name" value="{{$libraries->libraries_name}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kütüphane Telefon</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="libraries_phone" value="{{$libraries->libraries_phone}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kütüphane Adres</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="libraries_address" id="editor1">
                                        {{$libraries->libraries_address}}
                                            </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kütüphane Yetkilisi</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Seçiniz</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="libraries_auth">
                                    @foreach($libraryAuthPersons as $authPerson)
                                        <option {{$libraries->libraries_auth==$authPerson->id ? "selected" : ""}} value="@php echo $authPerson->id @endphp">@php echo $authPerson->name @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <script>
                            CKEDITOR.replace( 'editor1' );
                        </script>

                            <div class="form-group" style="margin-top:30px;">
                                <div align="right" class="card-footer">
                                    <button type="submit" class="btn btn-success">Güncelle</button>
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
