@extends('backend.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Genel Site Ayarları</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Açıklama</th>
                            <th>İçerik</th>
                            <th>Key Değer</th>
                            <th>Ayar Tipi</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach($data['adminSettings'] as $adminSettings)
                            <tr id="item-{{$adminSettings->id}}">
                                <td>{{$adminSettings->id}}</td>
                                <td class="sortable">{{$adminSettings['settings_description']}}</td>
                                <td>{{$adminSettings['settings_value']}}</td>
                                <td>{{$adminSettings['settings_key']}}</td>
                                <td>{{$adminSettings['settings_type']}}</td>

                                <td width="5">
                                    <a href="{{route('settings.Edit',['id'=>$adminSettings->id])}}" alt="Düzenle">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                </td>

                                <td width="5">
                                    @if($adminSettings['settings_delete'])
                                        <a href="javascript:void(0)" alt="Sil">
                                            <i id="@php echo $adminSettings->id @endphp" class="fa fa-trash"></i>
                                        </a>
                                    @endif
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
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#sortable').sortable({
                revert: true,
                handle: ".sortable",
                stop: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    $.ajax({
                        type: "POST",
                        data: data,
                        url: "{{route('settings.Sortable')}}",
                        error: function (msg) {
                            alertify.error("İşlem Başarısız!");
                        },
                        success: function (msg) {
                            alertify.success("İşlem Başarılı!");
                        }
                    });

                }
            });

            $('#sortable').disableSelection();

        });

        $(".fa-trash").click(function () {
            destroy_id = $(this).attr('id');

            alertify.confirm('Silme işlemini gerçekleştirmek istiyor musunuz?', 'Bu işlem geri alınamaz',
                function () {
                    location.href = "/admin/settings/delete/"+destroy_id;
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
