@extends('backend.layout')

@section('content')


    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Rezervasyon Yönetimi</h5>

                </div>
                <div class="card-body">
                    <div align="right">
                        {{--                        <a href="{{route('users.create')}}">--}}
                        {{--                            <button class="btn btn-warning">Toplu Kullanıcı Ekle</button>--}}
                        {{--                        </a>--}}

                        <a href="#">
                            <button class="btn btn-success">Ekle</button>
                        </a>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>RESİM</th>
                                <th>KİTAP</th>
                                <th>ALICI</th>
                                <th>BAŞLANGIÇ TARİHİ</th>
                                <th>TESLİM TARİHİ</th>
                                <th>REZERV. DURUMU</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="sortable">


                            @foreach($data['rents'] as $rent)

                                <tr id="item-{{$rent->id}}">
                                    <td>
                                        <img
                                            src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"
                                            alt="" style="width:50px;">
                                    </td>
                                    <td>{{$rent['book']->book_name}}</td>
                                    <td class="sortable">{{$rent['user']->name}}</td>
                                    <td>{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                    <td>{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                    <td>{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>

                                    <td width="5">
                                        {{--                                    {{route('libraries.edit',$library->id)}}--}}
                                        <a href="" alt="Düzenle">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                    </td>

                                    <td width="5">
                                        <a href="javascript:void(0)" alt="Sil">
                                            <i id="@php echo $rent->id @endphp" class="fa fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center" style="margin-top:20px;">
                        {!! $data['rents']->links() !!}
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
                        url: "{{ route('libraries.destroy','') }}/" + destroy_id,
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

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
