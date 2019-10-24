@extends('layout.index')

@section('title')
    {{$tintuc->TieuDe}}
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-9">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>{{$tintuc->TieuDe}}</h1>

                <!-- Author -->
                <p class="lead">
                    by Admin
                </p>

                <!-- Preview Image -->
                <img class="img-responsive" src="upload/tintuc/{{$tintuc->Hinh}}" alt="">

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{$tintuc->created_at}}</p>
                <hr>

                <!-- Post Content -->
                <p>{!! $tintuc->NoiDung !!}</p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                @if (isset(Auth::user()->id))
                    <div class="well">
                        <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
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
                        <form role="form" action="comment/them/{{$tintuc->id}}" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <textarea name="NoiDung" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </form>
                    </div>
                    <hr>
                @endif

            <!-- Posted Comments -->
                <!-- Comment -->

                @foreach($tintuc->comment as $cmt)
                    <div class="media">
                        <a class="pull-left">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body form-group">
                            <h4 class="media-heading">{{$cmt->user->name}}
                                <small>{{$cmt->created_at}}</small>
                            </h4>
                            {{$cmt->NoiDung}}
                            @if($cmt->idUser == Auth::user()->id)
                                <p style="text-align: right"><a href="comment/xoa/{{$cmt->id}}/{{$tintuc->id}}">Xóa</a></p>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tin liên quan</b></div>
                    <div class="panel-body">

                        <!-- item -->
                        @foreach($tinlienquan as $tt)
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-5">
                                    <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}">
                                        <img class="img-responsive" src="upload/tintuc/{{$tt->Hinh}}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}"><b>{{$tt->TieuDe}}</b></a>
                                </div>
                                <div class="break"></div>
                            </div>
                            <!-- end item -->
                        @endforeach


                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tin nổi bật</b></div>
                    <div class="panel-body">

                        <!-- item -->
                        @foreach($tinnoibat as $tt)
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-5">
                                    <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}">
                                        <img class="img-responsive" src="upload/tintuc/{{$tt->Hinh}}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}"><b>{{$tt->TieuDe}}</b></a>
                                </div>
                                <div class="break"></div>
                            </div>
                            <!-- end item -->
                        @endforeach

                    </div>
                </div>

            </div>

        </div>
        <!-- /.row -->
    </div>
@endsection
