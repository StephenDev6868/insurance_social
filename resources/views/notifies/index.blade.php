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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Thông Báo</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý Thông Báo</li>
                </ol>
            </div>
            <div class="col-sm-5">
                <div class="btn-group float-sm-right">
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="notifies"><i class="fa fa-minus mr-1"></i>Xóa
                        Mục Chọn</button>
                    <a role="button" class="btn btn-light waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Tạo Thông Báo</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo Thông Báo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/create/notify')}}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                <input type="text" name="title" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Mô tả:</label>
                                <textarea id="editor" name="description"></textarea>
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
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Thông Báo</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Ngày tạo</th>
                                        <th>Tình Trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifies as $key => $notify)
                                    <div class="modal fade" id="exampleModal{{$notify['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content" style="background-color:#007bff;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Thông Báo</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/edit/notify/'.$notify['id'])}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                                            <input type="text" name="title" value="{{$notify['title']}}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Mô tả:</label>
                                                            <textarea id="editor1" name="description">{{$notify['description']}}</textarea>
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
                                        <td><input type="checkbox" value="{{$notify['id']}}" class="sub_ck" data-id="{{$notify['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $notify['title'] }}
                                        </td>
                                        <td>
                                            {{date('d/m/Y', strtotime($notify['created_at']))}}
                                        </td>
                                        <td style="font-size: 30px">
                                            <center>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal{{$notify['id']}}" style="color:greenyellow" title="Chỉnh sửa thông báo"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="notify" recordid="{{$notify['id']}}" title="Xóa thông báo"><i class="fa fa-trash"></i></a>
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