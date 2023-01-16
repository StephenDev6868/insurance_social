@extends('layouts.table')
@section('content')
<?php

use App\Models\Question;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-7">
                <h4 class="page-title">Dữ Liệu Bảng</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="javaScript:void();">Khảo Sát</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý khảo sát</li>
                </ol>
            </div>
            <div class="col-sm-5">
                <div class="btn-group float-sm-right">
                <a role="button" class="btn btn-behance waves-effect waves-light" data-toggle="modal" data-target="#exampleModalx"><i class="fa fa-plus mr-1"></i>
                        Cập Nhật Ảnh Khảo Sát</a>
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="surveys"><i class="fa fa-minus mr-1"></i>Xóa
                        Mục Chọn</button>
                    <a role="button" class="btn btn-light waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Tạo Khảo Sát</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo khảo sát</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/create/survey')}}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                <input type="text" name="title" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Ảnh Khảo Sát</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/banner')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tên Tiêu Đề:</label>
                                <input type="text" class="form-control" value="{{$banner['survey_text']}}" name="survey_text" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ảnh Khảo Sát</label>
                                <div class="input-group">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose Image
                                    </a>
                                    <input id="thumbnail" class="form-control" value="{{$banner['survey_image']}}" type="text" name="survey_image" readonly required>
                                </div>
                                <div id="holder">
                                    <img data-original="{{$banner['survey_image']}}" width="100px" height="100px">
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng khảo sát</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Số câu hỏi</th>
                                        <th>Tình Trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surveys as $key => $survey)
                                    <div class="modal fade" id="exampleModal{{$survey['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content" style="background-color:#007bff;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật khảo sát</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/edit/survey/'.$survey['id'])}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                                            <input type="text" name="title" value="{{$survey['title']}}" class="form-control" id="recipient-name">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td><input type="checkbox" value="{{$survey['id']}}" class="sub_ck" data-id="{{$survey['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $survey['title'] }}
                                        </td>
                                        <td>
                                            {{count(Question::where('survey_id', $survey['id'])->get())}} câu hỏi
                                        </td>
                                        <td style="font-size: 30px">
                                            <center>
                                                <a href="{{ url('admin/questions/survey/' . $survey['id']) }}" style="color:aqua" title="Xem các câu hỏi"><i class="fa fa-plus-circle"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal{{$survey['id']}}" style="color:greenyellow" title="Chỉnh sửa khảo sát"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="survey" recordid="{{$survey['id']}}" title="Xóa khảo sát"><i class="fa fa-trash"></i></a>
                                            </center>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->
        <!--start overlay-->
        <div class="overlay"></div>
        <!--end overlay-->
    </div>
    <!-- End container-fluid-->

</div>

@endsection