@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Dijital Yayın Yönetimi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <form action="{{route('rents.Search')}}" method="GET" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q"
                                           placeholder="Dijital Yayın adı girin">

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                        <div class="col-lg-3 text-right">
                            <a href="{{route('ebooks.create')}}">
                                <button class="btn btn-success">Ekle</button>
                            </a>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:20px;">
                        <div class="table-responsive" style="margin-top:20px;">
                            <table class="table table-striped table-hover" id="digitalBooksTable">
                                <thead>
                                <tr>
                                    <th>RESİM</th>
                                    <th>DİJİTAL YAYIN ADI</th>
                                    <th>SINIF SEVİYESİ</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="sortable">


                                @foreach($digitalBooks as $digitalBook)

                                    <tr id="item-{{$digitalBook->id}}">
                                        <td>
{{--                                            <img--}}
{{--                                                src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"--}}
{{--                                                alt="" style="width:30px;">--}}
                                        </td>
                                        <td>{{$digitalBook->ebooks_name}}</td>

                                        <td>
                                            @foreach($digitalBook->levels as $level)
                                                <span class="badge badge-primary">{{$level->levelName}}</span>

                                                @endforeach
                                        </td>

                                        <td width="5">

                                        </td>
                                        <td width="5">

                                        </td>

                                        <td width="5">
                                            <a href="javascript:void(0)" alt="Sil">
                                                <i id="@php echo $digitalBook->id @endphp" class="fa fa-trash text-danger cop-{{$digitalBook->id}}"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center" style="margin-top:20px;">
                            {!! $digitalBooks->appends(Request::except('_token','page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(".fa-trash").click(function () {
            destroy_id = $(this).attr('id');
            console.log(destroy_id);
            alertify.confirm('Silme işlemini gerçekleştirmek istiyor musunuz?', 'Bu işlem geri alınamaz.',
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
                        url: "{{ route('ebooks.destroy','') }}/" + destroy_id,
                        success: function (data) {
                            $("#item-" + destroy_id).remove();
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
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

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
