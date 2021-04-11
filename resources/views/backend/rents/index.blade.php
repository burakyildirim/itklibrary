@extends('backend.layout')

@section('content')


    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Rezervasyon Yönetimi</h5>

                </div>
                <div class="card-body">
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-lg-9">
                            <form action="{{route('rents.Search')}}" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q"
                                           placeholder="Kitap yada Alıcı Adı Girin">

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                        <div class="col-lg-3 text-right">
                            <a class="btn btn-success btn-md" href="{{route('rents.create')}}">
                                Yeni Rezervasyon
                            </a>
                        </div>

                    </div>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>RESİM</th>
                                <th>KİTAP</th>
                                <th>ALICI</th>
                                <th class="text-center">BAŞLANGIÇ TARİHİ</th>
                                <th class="text-center">BİTİŞ TARİHİ</th>
                                <th class="text-center">SON GÜNCELLEME</th>
                                <th class="text-center">REZERV. DURUMU</th>
                                <th></th>
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
                                            alt="" style="width:30px;">
                                    </td>
                                    <td>{{$rent['book']->book_name}}</td>
                                    <td class="sortable">{{$rent['user']->name}}</td>
                                    <td class="text-center">{{date('d.m.Y',strtotime($rent->rentStartDate))}}</td>
                                    <td class="text-center">{{date('d.m.Y',strtotime($rent->rentEndDate))}}</td>
                                    <td class="text-center">{{date('d.m.Y',strtotime($rent->updated_at))}}</td>
                                    <td id="tdRentStatus-{{$rent->id}}" class="text-center">{{\App\Models\Rents::RentStatuses[$rent->rent_status]}}</td>

                                    <td width="5">
                                        @if($rent->rent_status==1)
                                        <a id="tdCheckButton-{{$rent->id}}" href="javascript:void(0)" alt="Onayla">
                                            <i id="@php echo $rent->id @endphp" class="fa fa-check-circle text-success"></i>
                                        </a>
                                            @elseif($rent->rent_status==2)
                                            <a id="tdTeslimAlButton-{{$rent->id}}" href="javascript:void(0)" alt="Teslim Al">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-hand-holding-medical text-warning teslimAl-{{$rent->id}}"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td width="5">
                                        {{--                                    {{route('libraries.edit',$library->id)}}--}}
                                        @if($rent->rent_status==1)
                                            <a href="javascript:void(0)" alt="Düzenle">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-pen kalem-{{$rent->id}}"></i>
                                            </a>
                                        @endif
                                    </td>

                                    <td width="5">
                                        @if($rent->rent_status==1 || $rent->rent_status==4)
                                            <a href="javascript:void(0)" alt="Sil">
                                                <i id="@php echo $rent->id @endphp" class="fa fa-trash text-danger cop-{{$rent->id}}"></i>
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
                            $(".cop-"+onay_id).hide();
                            $(".kalem-"+onay_id).hide();
                            $("#tdTeslimAlButton-"+onay_id).show();
                            $("#tdRentStatus-" + onay_id).text('{{\App\Models\Rents::RentStatuses[2]}}');
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
                        }
                    });
                },
                function () {
                    alertify.error('Alıcıya teslim işlemi gerçekleştirilmedi!');
                }
            ).set('labels', {ok:'TESLİM ET', cancel:'İPTAL'})
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
                            $(".teslimAl-"+teslimAl_id).hide();
                            $("#tdTeslimAlButton-"+teslimAl_id).hide();
                            $("#tdRentStatus-" + teslimAl_id).text('{{\App\Models\Rents::RentStatuses[3]}}');
                            alertify.success(data);
                            setTimeout(location.reload.bind(location), 1500);
                        }
                    });
                },
                function () {
                    alertify.error('Teslim alma işlemi gerçekleştirilmedi!');
                }
            ).set('labels', {ok:'TESLİM AL', cancel:'İPTAL'})
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
