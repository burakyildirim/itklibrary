@extends('frontend.layout')

@section('title','Profil Sayfası')

@section('content')
    <div class="row" style="padding-top:16px;">
        @yield('breadcrumb')
    </div>

    <div class="row" style="padding-top:0px;">
        <div class="col-lg-3" style="margin-bottom:30px;">
            @yield('sidebar_menu')
        </div>
        <div class="col-lg-9">
            @yield('sidebar_content')
        </div>
    </div>

@endsection
