@extends('backend.layout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Dijital Yayın Yükle</h5>
                </div>
                <div class="card-body">
                    {{--                    {{route('libraries.store')}}--}}
                    <form action="{{route('ebooks.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Dijital Yayın Adı</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="ebooks_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Sınıf Seviyesi</label><br/>

{{--                                <select name="ebooks_levels" class="form-control" multiple>--}}
{{--                                    @foreach($classLevels as $classLevel)--}}
{{--                                        <option value="{{ $classLevel->id }}">{{ $classLevel->levelName }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

                                @foreach($classLevels as $classLevel)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="levels_ebook[]" id="inlineCheckbox-{{ $classLevel->id }}" value="{{ $classLevel->id }}">
                                        <label class="form-check-label" for="inlineCheckbox-{{ $classLevel->id }}">{{ $classLevel->levelName }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col">
                                <label>Dijital Yayın Branş</label><br/>

                                @foreach($digitalBookBranches as $digitalBookBranch)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="branches_ebook[]" id="inlineBranchesCheckbox-{{ $digitalBookBranch->id }}" value="{{ $digitalBookBranch->id }}">
                                        <label class="form-check-label" for="inlineBranchesCheckbox-{{ $digitalBookBranch->id }}">{{ $digitalBookBranch->branch_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px;">
                            <label>Açıklama</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="ebooks_description" id="editor1">
                                            </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Flipbook Dosyası(Sıkıştırılmış ZIP)</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="file" name="ebook_file">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Dijital Yayın Görseli (250x400)</label>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="file" name="ebook_image">
                                    </div>
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

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
