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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Danh Mục</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý Danh Mục</li>
                </ol>
            </div>
            <div class="col-sm-5">
                <div class="btn-group float-sm-right">
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="categories"><i class="fa fa-minus mr-1"></i>Xóa
                        Mục Chọn</button>
                    <a role="button" class="btn btn-light waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Tạo Danh Mục</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo Danh Mục</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/create/category')}}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tên:</label>
                                <input type="text" name="name" class="form-control" id="recipient-name" required>
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
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Danh Mục</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Tình Trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key => $category)
                                    <div class="modal fade" id="exampleModal{{$category['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content" style="background-color:#007bff;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Danh Mục</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/edit/category/'.$category['id'])}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Tên:</label>
                                                            <input type="text" name="name" value="{{$category['name']}}" required class="form-control" id="recipient-name">
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
                                        <td><input type="checkbox" value="{{$category['id']}}" class="sub_ck" data-id="{{$category['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $category['name'] }}
                                        </td>
                                        <td style="font-size: 30px">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal{{$category['id']}}" style="color:greenyellow" title="Chỉnh sửa danh mục"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="category" recordid="{{$category['id']}}" title="Xóa danh mục"><i class="fa fa-trash"></i></a>
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