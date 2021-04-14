@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kitap Yönetimi</h5>

                </div>
                <div class="card-body">
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-lg-9">
                            <form action="{{route('books.Search')}}" method="GET" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q"
                                           placeholder="Kitap adı yada yazar adı giriniz">

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                        <div class="col-lg-3 text-right">
                            <a class="btn btn-success btn-md" href="{{route('books.create')}}">
                                Yeni Kitap Ekle
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="bookTable">
                            <thead>
                            <tr>
                                <th>KİTAP RESİM</th>
                                <th>KİTAP ADI</th>
                                <th>KİTAP YAZARI</th>
                                <th>YAYINEVİ</th>
                                <th>BASIM YILI</th>
                                <th>KÜTÜPHANE</th>
                                <th>GÖRÜNÜR MÜ?</th>
                                <th style="text-align: center;">STOK ADEDİ</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            @foreach($kitaplar as $kitap)
                                <tr id="item-{{$kitap->bookId}}">
                                    <td>
                                        {{--                                            : echo url('/images/books/').$kitap->book_image--}}
                                        <img
                                            src="{{ $kitap->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$kitap->book_image}}"
                                            alt="" style="width:30px;">
                                    </td>
                                    <td class="sortable sortable-{{$kitap->bookId}}">{{$kitap->book_name}}</td>
                                    <td>{{$kitap->book_author}}</td>
                                    <td>{{$kitap->book_publisher}}</td>
                                    <td>{{$kitap->formatted_date}}</td>
                                    <td>{{$kitap->library['libraries_name']}}</td>
                                    <td>{{\App\Models\Books::VisStatus[$kitap->book_visStatus]}}</td>
                                    <td style="text-align: center;">{{$kitap->book_stok}}</td>

                                    <td width="5">
                                        <a href="javascript:void(0)" alt="QR Code Al">
                                            <i id="@php echo $kitap->bookId @endphp" class="fa fa-qrcode"></i>
                                        </a>
                                    </td>

                                    <td width="5">
                                        <a href="{{route('books.edit',$kitap->bookId)}}" alt="Düzenle">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                    </td>

                                    <td width="5">
                                        <a href="javascript:void(0)" alt="Sil">
                                            <i id="@php echo $kitap->bookId @endphp" class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center" style="margin-top:20px;">
                        {!! $kitaplar->appends(Request::except('_token','page'))->render() !!}
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- QRCode Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary" onclick='printDiv();'>Yazdır</button>
                </div>
            </div>
        </div>
    </div>

    {{--    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">--}}

    {{--    {{Imagick::getVersion()}}--}}
    {{--    {!!QrCode::size(250)->format('png')->generate("buraaaaak", public_path('images/qrcodes/deneme.png'))!!}--}}
    <script type="text/javascript" src="{{asset('backend/custom/js/printThis.js')}}"></script>

    <script type="text/javascript">
        function printDiv() {
            $(".modal-body").printThis({
                pageTitle: $('.modal-title').text(),
            });
        }

        $(".fa-qrcode").click(function () {
            qrcode_idSlugUrl = $(this).attr('id');
            console.log('qr code ala bastın');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                // dataType: 'html',
                contentType: "image/png",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: qrcode_idSlugUrl,
                    _method: 'GET'
                },
                url: "{{ route('books.qrcode','') }}/" + qrcode_idSlugUrl,
                success: function (data) {
                    $('.modal-body').html('<img class="img-fluid" style="width:100%;" src="data:image/png;base64, ' + data + '"/>');

                    //ÇALIŞAN
                    //$('.modal-body').html('<img src="{{url('/images/qrcodes/')}}'+ '/' + qrcode_idSlugUrl + '.png' +'" />');
                    $('.modal-title').html('<strong>QR Kod: </strong>' + $('.sortable-' + qrcode_idSlugUrl).text());
                    $('#exampleModal').modal('show');
                }
            });
        });


        $(".fa-trash").click(function () {

            destroy_id = $(this).attr('id');

            alertify.confirm('Silme işlemini gerçekleştirmek istiyor musunuz?', 'Bu işlem geri alınamaz',
                function () {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: destroy_id,
                            _method: 'DELETE'
                        },
                        url: "{{ route('books.destroy','') }}/" + destroy_id,
                        success: function (data) {
                            $("#item-" + destroy_id).remove();
                            alertify.success(data);
                            //setTimeout(location.reload.bind(location), 1500);
                        }
                    });

                },
                function () {
                    alertify.error('Silme işlemi gerçekleştirilmedi!');
                }
            )
        });
    </script>

    <script>
        function kitapAraBox() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("kitapArama");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent.toUpperCase() || td.innerText.toUpperCase();
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
