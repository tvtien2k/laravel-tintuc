@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>Thêm</small>
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
                    <form action="admin/user/them" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input class="form-control" name="name" placeholder="Nhập họ tên"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Nhập Email"/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Nhập Password"/>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận Password</label>
                            <input type="password" class="form-control" name="repassword"
                                   placeholder="Nhập lại Password"/>
                        </div>
                        <div class="form-group">
                            <label>Quyền: </label>
                            <label class="radio-inline">
                                <input name="quyen" value="0" checked="" type="radio">Thành viên
                            </label>
                            <label class="radio-inline">
                                <input name="quyen" value="1" type="radio">Admin
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Thêm người dùng</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
