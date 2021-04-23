@extends('frontend.layout')

@section('title','Profil Sayfası')

@section('content')

    <div class="row" style="margin-top:30px;">
        <div class="col-lg-3" style="margin-bottom:30px;">
            @yield('sidebar_menu')
        </div>
        <div class="col-lg-9">
            @yield('sidebar_content')
        </div>
    </div>

@endsection
