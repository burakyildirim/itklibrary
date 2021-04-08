@extends('backend.layout')

@section('content')
    <style>
        .btn-app{
            padding-top:15px;
            margin-right: 0px;
            margin-left: 0px;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Kütüphanedeki Kitap Sayısı</h5>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>

            {{--            Onay Bekleyen Rezervasyonlar--}}
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="m-0">Onay Bekleyen Rezervasyonlar</h5>
                </div>
                <div class="card-body">
                    {{--                    <h6 class="card-title">Altbaşlık Alanı</h6>--}}

                    <p class="card-text">
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                @if(count($data['rentsWaitingApprove'])!=0)
                                    <th>RESİM</th>
                                    <th>KİTAP</th>
                                    <th>ALICI</th>
                                    <th class="text-center">BAŞLANGIÇ TARİHİ</th>
                                    <th class="text-center">BİTİŞ TARİHİ</th>
                                    <th>REZERV. DURUMU</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @if(count($data['rentsWaitingApprove'])==0)
                                Onay bekleyen hiç rezervasyon yok!
                            @endif

                            @foreach($data['rentsWaitingApprove'] as $rent)
                                <tr id="item-{{$rent->id}}">
                                    <td width="5">
                                        <img
                                            src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"
                                            alt="" style="width:30px;">
                                    </td>
                                    <td width="300">{{$rent['book']->book_name}}</td>
                                    <td class="sortable" width="300">{{$rent['user']->name}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                    <td id="tdRentStatus-{{$rent->id}}">{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>

                                    <td width="5">
                                        @if($rent->rent_status==1)
                                            <a id="tdCheckButton-{{$rent->id}}" class="btn btn-app" href="javascript:void(0)">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-check-circle text-success teslimAl-{{$rent->id}}"></i>Onayla
                                            </a>
                                        @endif
                                    </td>
                                    <td width="5">
                                        {{--                                    {{route('libraries.edit',$library->id)}}--}}
                                        @if($rent->rent_status==1)
                                            <a class="btn btn-app" href="javascript:void(0)">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-pen text-primary"></i>Düzenle
                                            </a>
                                        @endif
                                    </td>

                                    <td width="5">
                                        @if($rent->rent_status==1 || $rent->rent_status==4)

                                            <a class="btn btn-app" href="javascript:void(0)">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-trash text-danger cop-{{$rent->id}}"></i>Sil
                                            </a>


                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center" style="margin-top:20px;">
                        {!! $data['rentsWaitingApprove']->links() !!}
                    </div>

                </div>
            </div>

            {{--            Teslim Tarihi Yaklaşan Rezervasyonlar--}}
            <div class="card card-warning">
                <div class="card-header">
                    <h5 class="m-0">Teslim Tarihi Yaklaşan Rezervasyonlar</h5>
                </div>
                <div class="card-body">
                    {{--                    <h6 class="card-title">Altbaşlık Alanı</h6>--}}

                    <p class="card-text">
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                @if(count($data['rents'])!=0)
                                    <th>RESİM</th>
                                    <th>KİTAP</th>
                                    <th>ALICI</th>
                                    <th class="text-center">BAŞLANGIÇ TARİHİ</th>
                                    <th class="text-center">BİTİŞ TARİHİ</th>
                                    <th>REZERV. DURUMU</th>
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @if(count($data['rents'])==0)
                                Teslim tarihi yaklaşan hiç rezervasyon yok!
                            @endif

                            @foreach($data['rents'] as $rent)
                                <tr id="item-{{$rent->id}}">
                                    <td width="5">
                                        <img
                                            src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"
                                            alt="" style="width:30px;">
                                    </td>
                                    <td width="300">{{$rent['book']->book_name}}</td>
                                    <td class="sortable" width="300">{{$rent['user']->name}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                    <td id="tdRentStatus-{{$rent->id}}">{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>

                                    <td width="5">
                                        @if($rent->rent_status==2)
                                            <a id="tdTeslimAlButton-{{$rent->id}}" class="btn btn-app" href="javascript:void(0)">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-hand-holding-medical text-warning teslimAl-{{$rent->id}}"></i> Teslim Al
                                            </a>
                                        @endif
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

            {{--            Teslim Tarihi Geçen Rezervasyonlar--}}
            <div class="card card-danger">
                <div class="card-header">
                    <h5 class="m-0">Teslim Tarihi Geçen Rezervasyonlar</h5>
                </div>
                <div class="card-body">
                    {{--                    <h6 class="card-title">Altbaşlık Alanı</h6>--}}

                    <p class="card-text">
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                @if(count($data['rentsOverDate'])!=0)
                                    <th>RESİM</th>
                                    <th>KİTAP</th>
                                    <th>ALICI</th>
                                    <th class="text-center">BAŞLANGIÇ TARİHİ</th>
                                    <th class="text-center">BİTİŞ TARİHİ</th>
                                    <th>REZERV. DURUMU</th>
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @if(count($data['rentsOverDate'])==0)
                                Teslim tarihi geçen hiç rezervasyon yok!
                            @endif

                            @foreach($data['rentsOverDate'] as $rent)
                                <tr id="item-{{$rent->id}}">
                                    <td width="5">
                                        <img
                                            src="{{ $rent['book']->book_image == null ?  url('/images/books/default.jpg'): url('/images/books')."/".$rent['book']->book_image}}"
                                            alt="" style="width:30px;">
                                    </td>
                                    <td width="300">{{$rent['book']->book_name}}</td>
                                    <td class="sortable" width="300">{{$rent['user']->name}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                    <td width="170" class="text-center">{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                    <td id="tdRentStatus-{{$rent->id}}">{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>

                                    <td width="5">
                                        @if($rent->rent_status==2)
                                            @if($rent->rent_status==2)
                                                <a id="tdTeslimAlButton-{{$rent->id}}" class="btn btn-app" href="javascript:void(0)">
                                                    <i id="@php echo $rent->id @endphp" class="fa fa-hand-holding-medical text-warning teslimAl-{{$rent->id}}"></i>Teslim Al
                                                </a>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center" style="margin-top:20px;">
                        {!! $data['rentsOverDate']->links() !!}
                    </div>

                </div>
            </div>


        </div>
    </div>

    <script type="text/javascript">
        $(".fa-check-circle").click(function () {
            onay_id = $(this).attr('id');
            alertify.confirm('Kitabı alıcıya teslim etmek istediğinizden emin misiniz?', 'Bu seçeneği yalnızca kitabı alıcıya teslim ederken kullanın.',
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
                            id: onay_id,
                            _method: 'POST'
                        },
                        url: "{{ route('rents.Check','') }}/" + onay_id,
                        success: function (data) {
                            $("#tdCheckButton-" + onay_id).hide();
                            $(".cop-" + onay_id).hide();
                            $(".kalem-" + onay_id).hide();
                            $("#tdTeslimAlButton-" + onay_id).show();
                            $("#tdRentStatus-" + onay_id).text('{{\App\Models\Rents::RentStatuses[2]}}');
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
                        }
                    });
                },
                function () {
                    alertify.error('Alıcıya teslim işlemi gerçekleştirilmedi!');
                }
            ).set('labels', {ok: 'TESLİM ET', cancel: 'İPTAL'})
        });


        $(".fa-hand-holding-medical").click(function () {
            teslimAl_id = $(this).attr('id');
            alertify.confirm('Kitabı teslim almak istediğinize emin misiniz?', 'Bu seçeneği yalnızca kitabı alıcıdan teslim alırken kullanın.',
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
                            id: teslimAl_id,
                            _method: 'POST'
                        },
                        url: "{{ route('rents.GetBook','') }}/" + teslimAl_id,
                        success: function (data) {
                            $(".teslimAl-" + teslimAl_id).hide();
                            $("#tdTeslimAlButton-" + teslimAl_id).hide();
                            $("#tdRentStatus-" + teslimAl_id).text('{{\App\Models\Rents::RentStatuses[3]}}');
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
                        }
                    });
                },
                function () {
                    alertify.error('Teslim alma işlemi gerçekleştirilmedi!');
                }
            ).set('labels', {ok: 'TESLİM AL', cancel: 'İPTAL'})
        });


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
                        url: "{{ route('rents.destroy','') }}/" + destroy_id,
                        success: function (data) {
                            $("#item-" + destroy_id).remove();
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
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


@section('css')@endsection
@section('js')@endsection
