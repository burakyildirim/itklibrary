@extends('frontend.sidebar_layout')


@section('breadcrumb')
    <div class="col-lg-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('welcome.Index')}}">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dijital Yayınlar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('sidebar_menu')

    <form method="GET" action="{{route('frontend.ebooks.index')}}">
        @csrf
        <h1 class="display-5" style="font-weight: lighter;">Branş</h1>
        <hr/>
        <div class="digitalBookBranchesFilter">
            @foreach($allDigitalBookBranches as $bookBranch)
                <div class="form-check form-check-inline digitalBook">
                    <input class="form-check-input" type="checkbox" name="brans[]"
                           id="{{ $bookBranch->branch_slug }}" value="{{ $bookBranch->id }}"
                           @if(is_array(request('brans')) && in_array($bookBranch->id,request('brans'))) checked @endif>

                    <label class="form-check-label digitalBook"
                           for="{{ $bookBranch->branch_slug }}">{{ $bookBranch->branch_name }}</label>
                </div>
            @endforeach
        </div>

        <h1 class="display-5" style="font-weight: lighter; margin-top:15px;">Seviye</h1>
        <hr/>

        @foreach($allClassLevels as $classLevel)
            <div class="form-check form-check-inline digitalBook">
                <input class="form-check-input" type="checkbox" name="seviye[]"
                       id="{{ $classLevel->level_slug }}" value="{{ $classLevel->id }}"
                       @if(is_array(request('seviye')) && in_array($classLevel->id,request('seviye'))) checked @endif>
                <label class="form-check-label digitalBook"
                       for="{{ $classLevel->level_slug }}">{{ $classLevel->levelName }}</label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-lg btn-success" style="width: 100%; margin-top:20px;">Filtrele</button>
    </form>

@endsection

@section('sidebar_content')
    <h1 class="display-5" style="font-weight: lighter;">İTK Dijital Yayınları</h1>
    <hr/>
    <div class="row">
        @if(count($allEbooks)==0)
            <div class="col-lg-12">
                Seçtiğiniz kriterlerde bir dijital yayın bulunamadı! :(
            </div>
        @endif

        @foreach($allEbooks as $ebook)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card digitalBook">
                    <img
                        src="{{ $ebook->ebooks_image == null ?  url('/images/books/default.jpg'): url('/images/ebooks')."/".$ebook->ebooks_image}}"
                        class="card-img-top" style="height: 16vw; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{$ebook->ebooks_name}}</h5>
                        <div class="card-text digitalBook">{!! $ebook->ebooks_description !!}</div>
                        @foreach($ebook->levels as $level)
                            <span class="badge badge-warning">{{$level->levelName}}</span>
                        @endforeach
                        <br/>
                        @foreach($ebook->branches as $branch)
                            <span class="badge badge-info">{{$branch->branch_name}}</span>
                        @endforeach
                    </div>
                    <div class="card-footer digitalBook">
                        <a class="btn btn-primary btn-md"
                           href="{{route('frontend.ebooks.show','').'/'.$ebook->unique_key}}">Detay</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Sayfalama --}}
    <div class="d-flex justify-content-center" style="margin-top:20px;">
        {!! $allEbooks->links() !!}
    </div>

    <script>

        {{--        $(document).ready(function () {--}}
        {{--            $('#btnFiltrele').click(function () {--}}
        {{--                var branchArray = $.map($('input[name="branches_ebook"]:checked'), function (c) {--}}
        {{--                    return c.value;--}}
        {{--                });--}}

        {{--                // console.log(array);--}}
        {{--               {{ http_build_query(array('seviye' => branchArray)) }};--}}
        {{--            })--}}
        {{--        });--}}
    </script>
@endsection

