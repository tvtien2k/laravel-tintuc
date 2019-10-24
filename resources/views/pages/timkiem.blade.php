@extends('layout.index')

@section('title')
    Tìm kiếm
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <?php
            function doimau($str, $tukhoa)
            {
                return str_ireplace($tukhoa, "<span style='color:red;'>$tukhoa</span>", $str);
            }
            ?>
            <div class="col-md-9 ">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h4><b>Kết quả tìm kiếm cho: {{$tukhoa}}</b></h4>
                    </div>
                    @foreach($tintuc as $tt)
                        <div class="row-item row">
                            <div class="col-md-3">
                                <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}">
                                    <br>
                                    <img width="200px" height="200px" class="img-responsive"
                                         src="upload/tintuc/{{$tt->Hinh}}" alt="">
                                </a>
                            </div>

                            <div class="col-md-9">
                                <h3>{!! doimau($tt->TieuDe, $tukhoa) !!}</h3>
                                <p>{!! doimau($tt->TomTat, $tukhoa) !!}</p>
                                <a class="btn btn-primary" href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}">View
                                    Project <span class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                            <div class="break"></div>
                        </div>
                    @endforeach

                    <div class="row text-center">
                        <div class="col-lg-12">
                            {!! $tintuc->appends(['tintuc' => $tintuc,'tukhoa' => $tukhoa])->links() !!}
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>

        </div>

    </div>
@endsection
