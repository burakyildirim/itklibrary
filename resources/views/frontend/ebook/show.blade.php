@extends('frontend.layout')
@section('title',$ebookDetay->ebooks_name)

@section('content')
    <style>
        .img-thumbnail{
            -webkit-box-shadow: 0px 3px 13px -6px rgba(0,0,0,0.46);
            -moz-box-shadow: 0px 3px 13px -6px rgba(0,0,0,0.46);
            box-shadow: 0px 3px 13px -6px rgba(0,0,0,0.46);
        }
    </style>

    <div class="row" style="padding-top:30px;">
        <div class="col-lg-12">
            <div class="col-lg-12" style="text-align: center;">
                <h1 class="display-4" style="font-size:35pt;">{{$ebookDetay->ebooks_name}}</h1>
            </div>
            <hr/>
            <iframe src="{{url('zips/'.$ebookDetay->unique_key.'/index.html')}}" frameborder="2" width="100%" height="600px"></iframe>
            <hr/>
            <div class="col-lg-12">
                {!! $ebookDetay->ebooks_description !!}
            </div>
        </div>
    </div>
@endsection


@section('css')@endsection
@section('js')@endsection
