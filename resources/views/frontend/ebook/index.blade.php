@extends('frontend.sidebar_layout')


@section('sidebar_menu')

    <h1 class="display-5" style="font-weight: lighter;">Branş</h1>
    <hr/>
    <div class="digitalBookBranchesFilter">
        @foreach($allDigitalBookBranches as $bookBranch)
            <div class="form-check form-check-inline digitalBook">
                <input class="form-check-input" type="checkbox" name="levels_ebook[]"
                       id="inlineCheckbox-{{ $bookBranch->id }}" value="{{ $bookBranch->id }}">
                <label class="form-check-label digitalBook"
                       for="inlineCheckbox-{{ $bookBranch->id }}">{{ $bookBranch->branch_name }}</label>
            </div>
        @endforeach
    </div>

    <h1 class="display-5" style="font-weight: lighter; margin-top:15px;">Seviye</h1>
    <hr/>

    @foreach($allClassLevels as $classLevel)
        <div class="form-check form-check-inline digitalBook">
            <input class="form-check-input" type="checkbox" name="levels_ebook[]"
                   id="inlineCheckbox-{{ $classLevel->id }}" value="{{ $classLevel->id }}">
            <label class="form-check-label digitalBook"
                   for="inlineCheckbox-{{ $classLevel->id }}">{{ $classLevel->levelName }}</label>
        </div>
    @endforeach

    {{--        @foreach($allClassLevels as $classLevel)--}}
    {{--            <a href="{{url('dijitalyayinlar/'.$classLevel->level_slug)}}" class="list-group-item list-group-item-action">--}}
    {{--                <i class="fa fa-school"></i> {{$classLevel->levelName}}--}}
    {{--            </a>--}}
    {{--        @endforeach--}}


@endsection

@section('sidebar_content')
    <h1 class="display-5" style="font-weight: lighter;">İTK Dijital Yayınları</h1>
    <hr/>
    {{--        <div class="card-deck">--}}
    <div class="row">
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
    {{--        </div>--}}

    {{-- Pagination --}}
    <div class="d-flex justify-content-center" style="margin-top:20px;">
        {!! $allEbooks->links() !!}
    </div>
@endsection

