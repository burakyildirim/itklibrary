@extends('frontend.sidebar_layout')


@section('sidebar_menu')
    <div class="list-group">
        <a href="{{route('profile.Index')}}" class="list-group-item list-group-item-action">
            <i class="fa fa-folder"></i> Rezervasyonlarım
        </a>
        <button type="button" class="list-group-item list-group-item-action">
            <i class="fa fa-heart"></i> Favorilerim
        </button>
        <a href="{{route('profile.Reservations')}}" class="list-group-item list-group-item-action active">
            <i class="fa fa-folder"></i> Rezervasyonlarım
        </a>
    </div>
@endsection

@section('sidebar_content')
    <h1 class="display-6" style="font-weight: lighter;">Rezervasyonlarım</h1>
    <hr/>

    <div class="table-responsive table-hover" style="margin-top:20px;">
        <table class="table table-striped table-sm table-hover" id="myRentsTable" style="font-size:13px;">
            <thead>
            <tr>
                @if(count($data['myRents'])!=0)
                    <th class="text-center">#</th>
                    <th>KİTAP</th>
                    <th class="text-center">BAŞ. TARİHİ</th>
                    <th class="text-center">BİTİŞ TARİHİ</th>
                    <th>DURUM</th>

                @endif
            </tr>
            </thead>
            <tbody id="sortable">
            @if(count($data['myRents'])==0)
                Hiç rezervasyon yok! :(
            @endif

            @foreach($data['myRents'] as $rent)
                <tr id="item-{{$rent->id}}">
                    <td width="5" style="vertical-align: middle;">
                        <img
                            src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"
                            alt="" style="width:30px;">
                    </td>
                    <td width="200" style="vertical-align: middle;">
                        <a href="{{'kitap/' . $rent['book']->id .'/'. $rent['book']->book_slug .''}}">{{$rent['book']->book_name}}</a>
{{--                        <a href="">{{$rent['book']->book_name}}</a>--}}
                    </td>

                    <td width="170" style="vertical-align: middle;"
                        class="text-center">{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                    <td width="170" style="vertical-align: middle;"
                        class="text-center">{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                    <td id="tdRentStatus-{{$rent->id}}" style="vertical-align: middle;">{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center" style="margin-top:20px;">
        {!! $data['myRents']->links() !!}
    </div>
@endsection
