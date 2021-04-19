@extends('frontend.sidebar_layout')


@section('sidebar_menu')
    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
            <i class="fa fa-layer-group"></i> Sınıf Seviyesi/Branş Filtreleri burada olacak.
        </a>

        <a href="#" class="list-group-item list-group-item-action">
            <i class="fa fa-star"></i> Favori Dijital Kitaplarım
        </a>

    </div>
@endsection

@section('sidebar_content')
                <h1 class="display-6" style="font-weight: lighter;">İTK Dijital Yayınları</h1>
                <hr/>
                <div class="col-lg-12">
                    <ul>
                        @foreach($allEbooks as $ebook)
                            <li><a href="{{route('frontend.ebooks.show',$ebook->unique_key)}}">{{$ebook->ebooks_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
@endsection

