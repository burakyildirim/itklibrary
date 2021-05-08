@extends('frontend.layout')
@section('title',$ebookDetay->ebooks_name)





@section('content')
    <style>
        .img-thumbnail {
            -webkit-box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
            -moz-box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
            box-shadow: 0px 3px 13px -6px rgba(0, 0, 0, 0.46);
        }
    </style>

    <div class="row" style="padding-top:16px;">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('welcome.Index')}}">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a href="{{route('frontend.ebooks.index')}}">Dijital Yayınlar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$ebookDetay->ebooks_name}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12" style="text-align: center;">
                <h1 class="display-4" style="font-size:35pt;">{{$ebookDetay->ebooks_name}}</h1>
            </div>
            <hr/>
            <iframe src="{{url('zips/'.$ebookDetay->unique_key.'/index.html')}}" frameborder="2" width="100%"
                    height="600px"></iframe>
            <hr/>
            <div class="col-lg-12">
                {!! $ebookDetay->ebooks_description !!}

                <p>
                    @foreach($ebookDetay->levels as $level)
                        <span class="badge badge-warning">{{$level->levelName}}</span>
                    @endforeach
                    <br/>
                    @foreach($ebookDetay->branches as $branch)
                        <span class="badge badge-info">{{$branch->branch_name}}</span>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
@endsection


@section('css')@endsection
@section('js')@endsection
