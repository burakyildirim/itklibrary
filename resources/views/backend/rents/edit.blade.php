@extends('backend.layout')


@section('content')

    <style>
        .yazarLi{
            margin-left:10px;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Rezervasyon Güncelle</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('rents.update',$rent->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="form-group">
                            <label>Yüklü Görsel</label>
                            <div class="row">
                                <div class="col-xs-12">
                                    <img width="100" style="padding-left:7px;" src="{{url('/images/books')."/".$rent->book['book_image']}}" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputBookName">Kitap Adı</label>
                                <input class="form-control" type="text" id="inputBookName" name="book_name" value="{{$rent->book['book_name']}}" autocomplete="off" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputRentUser">Rezervasyon Sahibi</label>
                                <select class="custom-select" id="inputRentUser" name="users_id">
                                    @foreach($users as $user)
                                        <option {{$user->id == $rent->users_id ? 'selected' : ''}} value="@php echo $user->id @endphp" disabled>@php echo $user->name @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputBookISBN">ISBN NUmarası</label>
                                <input class="form-control" type="number" name="book_isbn" id="inputBookISBN" value="{{$rent->book['book_isbn']}}" autocomplete="off" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputRentStatus">Rezervasyon Durumu</label>
                                <select class="custom-select" id="inputRentStatus" name="rent_status">
                                    @foreach($visStatus as $visStat)
                                        <option {{\App\Models\Rents::getRentStatusID($visStat)==$rent->rent_status?'selected':''}} value="@php echo \App\Models\Rents::getRentStatusID($visStat); @endphp">@php echo $visStat @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputRentStartDate">Rez. Başlangıç Tarihi</label>
                                <input class="form-control" type="text" id="inputRentStartDate" name="rentStartDate" value="{{date('d.m.Y',strtotime($rent->rentStartDate))}}" autocomplete="off" class="publishDate"
                                       data-provide="datepicker" data-date-format="dd.mm.yyyy" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputRentEndDate">Rez. Bitiş Tarihi</label>
                                <input class="form-control" id="inputRentEndDate" type="text" name="rentEndDate" value="{{date('d.m.Y',strtotime($rent->rentEndDate))}}" autocomplete="off" class="publishDate"
                                       data-provide="datepicker" data-date-format="dd.mm.yyyy">
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:30px;">
                            <div align="right" class="card-footer">
                                <button type="submit" class="btn btn-success">Güncelle</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('backend/custom/js/bootstrap-datepicker.min.js')}}"></script>

@endsection

@section('css')@endsection
@section('js')@endsection
