@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>{{$user->name}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                {{$error}}<br>
                            @endforeach
                        </div>
                    @endif
                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <form action="admin/user/sua/{{$user->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input class="form-control" name="name" value="{{$user->name}}" placeholder="Nhập họ tên"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{$user->email}}"
                                   placeholder="Nhập Email" readonly/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="changePass" name="changePass"/>
                            <label>Đổi mật khẩu</label>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control password" name="password" disabled
                                   placeholder="Nhập Password"/>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận Password</label>
                            <input type="password" class="form-control password" name="repassword" disabled
                                   placeholder="Nhập lại Password"/>
                        </div>
                        <div class="form-group">
                            <label>Quyền: </label>
                            <label class="radio-inline">
                                <input name="quyen" value="0"
                                       @if ($user->quyen == 0)
                                       {{"checked"}}
                                       @endif
                                       type="radio">Thành viên
                            </label>
                            <label class="radio-inline">
                                <input name="quyen" value="1"
                                       @if ($user->quyen == 1)
                                       {{"checked"}}
                                       @endif
                                       type="radio">Admin
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Sửa thông tin</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#changePass").change(function () {
                if ($(this).is(":checked")) {
                    $(".password").removeAttr('disabled');
                } else {
                    $(".password").attr('disabled', '');
                }
            })
        })
    </script>
@endsection
