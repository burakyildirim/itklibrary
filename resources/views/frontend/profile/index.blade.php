@extends('frontend.sidebar_layout')


@section('sidebar_menu')
    <div class="list-group">
        <a href="{{route('profile.Index')}}" class="list-group-item list-group-item-action active">
            <i class="fa fa-user-circle"></i> Hesap Bilgilerim
        </a>
        <button type="button" class="list-group-item list-group-item-action">
            <i class="fa fa-heart"></i> Favorilerim
        </button>
        <a href="{{route('profile.Reservations')}}" class="list-group-item list-group-item-action">
            <i class="fa fa-folder"></i> Rezervasyonlarım
        </a>

    </div>
@endsection

@section('sidebar_content')
                <h1 class="display-6" style="font-weight: lighter;">Hesap Bilgilerim</h1>
                <hr/>
{{--                oninput='up2.setCustomValidity(up2.value != up.value ? "Parolalar uyuşmuyor!" : "")'--}}
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputName1">Ad Soyad</label>
                                <input type="text" class="form-control" value="{{$userProfile->name}}" maxlength="20" id="exampleInputName1" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail">E-Posta</label>
                                <input type="email" class="form-control" value="{{$userProfile->email}}" id="exampleInputEmail" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputTcNo">TC No.</label>
                                <input type="text" class="form-control" value="{{$userProfile->tcno}}" maxlength="11" id="exampleInputTcNo" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputTelNo">Tel No.</label>
                                <input type="text" class="form-control" maxlength="11" id="exampleInputTelNo" disabled>
                            </div>
                        </div>
                    </div>



{{--                    <div class="row">--}}
{{--                        <div class="col">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="exampleInputPassword">Parola</label>--}}
{{--                                <input type="password" class="form-control" name="up" id="exampleInputPassword" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="exampleInputPassword2">Parola Tekrar</label>--}}
{{--                                <input type="password" class="form-control" name="up2" id="exampleInputPassword2" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <button type="submit" class="btn btn-primary">Güncelle</button>--}}
{{--                    <button type="submit" class="btn btn-warning">Parolamı Sıfırla</button>--}}

                </form>
@endsection

