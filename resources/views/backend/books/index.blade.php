@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kitap Yönetimi</h5>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <input class="form-control" type="text" id="kitapArama" onkeyup="kitapAraBox()"
                                   placeholder="Kitap adı..">
                        </div>
                        <div class="col-lg-3" align="right">
                            <a href="{{route('books.create')}}">
                                <button class="btn btn-success">Ekle</button>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="bookTable">
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
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            @foreach($kitaplar as $kitap)
                                <tr id="item-{{$kitap->bookId}}">
                                    <td>
                                        {{--                                            : echo url('/images/books/').$kitap->book_image--}}
                                        <img
                                            src="{{ $kitap->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$kitap->book_image}}"
                                            alt="" style="width:50px;">
                                    </td>
                                    <td class="sortable">{{$kitap->book_name}}</td>
                                    <td>{{$kitap->book_author}}</td>
                                    <td>{{$kitap->book_publisher}}</td>
                                    <td>{{$kitap->formatted_date}}</td>
                                    <td>{{$kitap->library['libraries_name']}}</td>
                                    <td>{{\App\Models\Books::VisStatus[$kitap->book_visStatus]}}</td>
                                    <td style="text-align: center;">{{$kitap->book_stok}}</td>

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
                        {!! $kitaplar->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script type="text/javascript">

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
