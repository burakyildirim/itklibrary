@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Genel Site Ayarı Düzenle</h5>
                </div>
                <div class="card-body">
                    {{--                    {{route('settings.Update')}}--}}
                    <form action="{{route('settings.Update',['id' => $settings->id])}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Açıklama</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text"
                                           value="{{$settings->settings_value}}" readonly>
                                </div>
                            </div>
                        </div>

                        @if($settings->settings_type=="file")
                            <div class="form-group">
                                <label>Dosya Seç</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" name="settings_value"
                                               type="{{$settings->settings_type}}" required>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            @if($settings->settings_type!="text" || $settings->settings_type!="file")
                                <label>İçerik</label>
                            @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($settings->settings_type=="text")
                                        <input class="form-control" type="text" name="settings_value"
                                               value="{{$settings->settings_value}}" required>
                                    @endif

                                    @if($settings->settings_type=="textarea")
                                        <textarea class="form-control" name="settings_value">
                                                {{$settings->settings_value}}
                                            </textarea>
                                    @endif

                                    @if($settings->settings_type=="ckeditor")
                                        <textarea class="form-control" name="settings_value" id="editor1">
                                                {{$settings->settings_value}}
                                            </textarea>
                                    @endif

                                    @if($settings->settings_type=="file")
                                        <img src="/images/settings/{{$settings->settings_value}}" width="150">
                                    @endif

                                    <script>
                                        CKEDITOR.replace( 'editor1' );
                                        // ClassicEditor
                                        //     .create(document.querySelector('#editor1'))
                                        //     .catch(error => {
                                        //         console.error(error);
                                        //     });
                                    </script>
                                </div>
                            </div>

                            @if($settings->settings_type=="file")
                                <input type="hidden" name="old_file" value="{{$settings->settings_value}}">
                            @endif

                            <div class="form-group" style="margin-top:30px;">
                                <div align="right" class="card-footer">
                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                </div>
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
