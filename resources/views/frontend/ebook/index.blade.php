@extends('frontend.sidebar_layout')


@section('sidebar_menu')
    <div class="list-group" style="font-size: 13px;">
            <a href="{{url('dijitalyayinlar')}}" class="list-group-item list-group-item-action active">
                <i class="fa fa-layer-group"></i> Tüm Kademeler
            </a>
        @foreach($allClassLevels as $classLevel)
            <a href="{{url('dijitalyayinlar/'.$classLevel->level_slug)}}" class="list-group-item list-group-item-action">
                <i class="fa fa-school"></i> {{$classLevel->levelName}}
            </a>
        @endforeach

{{--        <a href="#" class="list-group-item list-group-item-action">--}}
{{--            <i class="fa fa-star"></i> Favori Dijital Kitaplarım--}}
{{--        </a>--}}

    </div>
@endsection

@section('sidebar_content')
        <h1 class="display-6" style="font-weight: lighter;">İTK Dijital Yayınları</h1>
        <hr/>
        <div class="card-deck">
            @foreach($allEbooks as $ebook)

                        <div class="card" style="margin-left:0px; margin-bottom:15px;">
                                <img src="{{ $ebook->ebooks_image == null ?  url('/images/books/default.jpg'): url('/images/ebooks')."/".$ebook->ebooks_image}}" class="card-img-top" style="height: 17vw; object-fit:cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$ebook->ebooks_name}}</h5>
                                    <p class="card-text">{!! $ebook->ebooks_description !!}</p>
                                    @foreach($ebook->levels as $level)
                                        <span class="badge badge-warning">{{$level->levelName}}</span>
                                    @endforeach
                                </div>
                                <div class="card-footer" style="padding:0px; border-top-right-radius:0px; border-top-left-radius:0px; border-bottom-right-radius: 1px; border-bottom-left-radius: 1px;">
                                    <a class="btn btn-primary btn-lg"
                                       style="width: 100%; border-top-right-radius:0px; border-top-left-radius:0px;"
                                       href="{{route('frontend.ebooks.show','').'/'.$ebook->unique_key}}">Detay</a>
                                </div>
                        </div>

            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center" style="margin-top:20px;">
            {!! $allEbooks->links() !!}
        </div>
@endsection

