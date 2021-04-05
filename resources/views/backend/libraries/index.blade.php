@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kütüphane Yönetimi</h5>

                </div>
                <div class="card-body">
                    <div align="right">
{{--                        <a href="{{route('users.create')}}">--}}
{{--                            <button class="btn btn-warning">Toplu Kullanıcı Ekle</button>--}}
{{--                        </a>--}}

                        <a href="{{route('libraries.create')}}">
                            <button class="btn btn-success">Ekle</button>
                        </a>

                    </div>
                    <table class="table table-striped" id="userTable">
                        <thead>
                        <tr>
                            <th>KÜTÜPHANE ADI</th>
                            <th>TELEFON</th>
                            <th>ADRES</th>
                            <th>YETKİLİ KİŞİ</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="sortable">



                        @foreach($data['libraries'] as $library)

                            <tr id="item-{{$library->id}}">
                                <td class="sortable">{{$library['libraries_name']}}</td>
                                <td>{{$library['libraries_phone']}}</td>
                                <td>{{$library['libraries_address']}}</td>
                                <td>{{$library['uname']}}</td>

                                <td width="5">
                                    <a href="{{route('libraries.edit',$library->id)}}" alt="Düzenle">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                </td>

                                <td width="5">
                                    <a href="javascript:void(0)" alt="Sil">
                                        <i id="@php echo $library->id @endphp" class="fa fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                        url: "{{ route('libraries.destroy','') }}/"+destroy_id,
                        success: function (data) {
                            $("#item-"+destroy_id).remove();
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
