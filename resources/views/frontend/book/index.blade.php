@extends('frontend.layout')


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row" style="margin-top:30px;">
        @auth
            @if($tarafimcaRezerve)
                <div class="col-lg-12">
                    <div class="alert alert-warning" role="alert">
                        Bu kitap için rezervasyonunuz var!<br/>
                        <strong>Rezerv. Durumu: </strong> {{\App\Models\Rents::RentStatuses[$myrentdetails->rent_status]}}<br/>
                        <strong>Son Teslim Tarihi: </strong> {{date('d.m.Y',strtotime($myrentdetails->rentEndDate))}}<br/>
                    </div>
                </div>
            @endif

            @if($kitapDetay->book_rentStatus==0 && $mostNearDeliveryDate!=null)
                <div class="col-lg-12">
                    <div class="alert alert-info" role="alert">
                        <strong>Bu kitabın en yakın uygunluk tarihi: </strong> {{ date('d.m.Y',strtotime($mostNearDeliveryDate->rentEndDate)) }}<br/>
                    </div>
                </div>
            @endif

        @endauth

        <div class="col-lg-3 col-sm-12" style="text-align: center;">
            <img
                src="{{ $kitapDetay->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$kitapDetay->book_image}}"
                alt="" class="img-thumbnail">
            <hr>
            @auth
                @if($kitapDetay->book_rentStatus==1 && !$tarafimcaRezerve)
                    <strong>Bulunduğu Kütüphane:</strong> {{$kitapDetay->library['libraries_name']}}
                    <hr/>
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="xxxxx" id="xxxxx" value="66">
                        <button id="btnRezerve" value="{{$kitapDetay->id}}" class="btn btn-lg btn-success" onclick="javascript:void(0)" style="width: 100%;">Rezerve Et</button>
{{--                        <a id="btnRezerve" value="{{$kitapDetay->id}}" class="btn btn-lg btn-success"--}}
{{--                           style="width: 100%;">Rezerve Et</a>--}}
                    </form>
                    <hr/>
                @else
                    <div class="alert alert-danger" role="alert">
                        Bu kitap şuanda rezervasyon için uygun değil!
                    </div>
                    <hr/>
                @endif
            @endauth
        </div>

        <div class="col-lg-9">
            <div class="col-lg-12" style="text-align: center;">
                <h1 class="display-4" style="font-size:35pt;">{{$kitapDetay->book_name}}</h1>

            </div>
            <hr/>
            <div class="col-lg-12"><strong>Yazar:</strong> {{$kitapDetay->book_author}}</div>
            <div class="col-lg-12"><strong>Basım
                    Yılı:</strong> {{ date('d.m.Y',strtotime($kitapDetay->book_publishDate)) }}</div>
            <div class="col-lg-12"><strong>Yayınevi:</strong> {{$kitapDetay->book_publisher}}</div>
            <div class="col-lg-12"><strong>Kitap
                    Dili:</strong> {{\App\Models\Books::Languages[$kitapDetay->book_language]}}</div>

            <hr/>

            <div class="col-lg-12">{!!$kitapDetay->book_description!!}</div>
{{--            @if($allrents!=null)--}}
{{--                <div class="col-lg-12">--}}
{{--                    <table class="table table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th scope="col">#</th>--}}
{{--                            <th scope="col">Başl. Tar.</th>--}}
{{--                            <th scope="col">Bitiş Tar.</th>--}}
{{--                            <th scope="col">Durumu</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach($allrents as $rent)--}}
{{--                            <tr>--}}
{{--                                <td>1--}}
{{--                                </th>--}}
{{--                                <td>{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>--}}
{{--                                <td>{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>--}}
{{--                                <td>{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>

    </div>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {

            $('#btnRezerve').click(function () {
                console.log('butona basıldı');

                var bookId = $(this).attr('value');
                $(this).prop('disabled',true);

                $.ajax({
                    url: "{{ route('books.Reservation','') }}/" + bookId + "/",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {

                        alertify.success(data);

                        setTimeout(function () {
                            location.reload();
                        }, 1300);
                    },
                    failed: function (data) {
                        alertify.error(data);
                    },
                })

            })
        });

    </script>

@endsection


@section('css')@endsection
@section('js')@endsection
