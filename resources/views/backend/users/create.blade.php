@extends('backend.layout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Kullanıcı Ekle</h5>
                </div>
                <div class="card-body">
                    {{--                    {{route('settings.Update')}}--}}
{{--                    {{route('settings.Update',['id' => $settings->id])}}--}}
                    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Ad Soyad</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="email" name="email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>TC No.</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                           type = "number"
                                           maxlength = "11" name="tcno">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Rol</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Seçiniz</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="role">
                                    @foreach($userRoles as $role)
                                        <option {{\App\Models\User::getRoleID($role)=='3'?'selected':''}} value="@php echo \App\Models\User::getRoleID($role); @endphp">@php echo $role @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                            <div class="form-group" style="margin-top:30px;">
                                <div align="right" class="card-footer">
                                    <button type="submit" class="btn btn-success">Ekle</button>
                                </div>
                            </div>

                    </form>
                </div>


            </div>

        </div>
    </div>

@endsection

<!-- CSS ve JS Dosyalarını bu alanda dahil ediyorum. -->
@section('css')@endsection
@section('js')@endsection
