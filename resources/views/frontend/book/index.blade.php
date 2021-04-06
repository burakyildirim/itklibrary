@extends('frontend.layout')


@section('content')
    <style>
        #btnRezerve{
            color:white;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row" style="margin-top:15px;">
        {{--        @if($kitapDetay->book_rentStatus!=1)--}}
        {{--            <div class="col-lg-12">--}}
        {{--                <div class="alert alert-danger" role="alert">--}}
        {{--                    Bu kitap şuanda rezervasyon için uygun değil!--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}
        <div class="col-lg-3 col-sm-12" style="text-align: center;">
            <img
                src="{{ $kitapDetay->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$kitapDetay->book_image}}"
                alt="" class="img-thumbnail">
            <hr>
            @auth

                @if($kitapDetay->book_rentStatus==1 && !Rents::where('books_id',$kitapDetay->id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2'])->exists()))
                    <strong>Bulunduğu Kütüphane:</strong> {{$kitapDetay->library['libraries_name']}}
                    <hr>
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="xxxxx" id="xxxxx" value="66">
                        <a id="btnRezerve" value="{{$kitapDetay->id}}" href="#" class="form-control btn btn-lg btn-success">Rezerve Et</a>
                    </form>
                @else
                    <div class="alert alert-danger" role="alert">
                        Bu kitap şuanda rezervasyon için uygun değil!
                    </div>
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
            @if($myrents!=null)
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Başl. Tar.</th>
                            <th scope="col">Bitiş Tar.</th>
                            <th scope="col">Durumu</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($myrents as $rent)
                            <tr>
                                <td>1
                                </th>
                                <td>{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                <td>{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                <td>{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
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
                var bookId = $(this).attr('value');

                $.ajax({
                    url: "{{ route('books.Reservation','') }}/" + bookId + "/",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        alertify.success(data);

                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);
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
