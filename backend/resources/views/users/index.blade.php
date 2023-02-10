@extends('layouts.table')
@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Dữ Liệu Bảng</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="javaScript:void();">Người Dùng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý người dùng</li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                <a role="button" class="btn btn-light waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Cập Nhật Ảnh Đăng Ký</a>
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="users"><i class="fa fa-minus mr-1"></i>Xóa
                        Mục Chọn</button>
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Ảnh Đăng Ký</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/banner')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tên Tiêu Đề:</label>
                                <input type="text" class="form-control" value="{{$banner['register_text']}}" name="register_text" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ảnh Đăng Ký</label>
                                <div class="input-group">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose Image
                                    </a>
                                    <input id="thumbnail" class="form-control" value="{{$banner['register_image']}}" type="text" name="register_image" readonly required>
                                </div>
                                <div id="holder">
                                    <input type="image" src="{{$banner['register_image']}}" width="100px" height="100px">
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
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Người Dùng</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Loại tài khoản</th>
                                        <th>Tình trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                    <tr>
                                        <td><input type="checkbox" value="{{$user['id']}}" class="sub_ck" data-id="{{$user['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>{{$user['name']}}</td>
                                        <td>
                                            {{ $user['email'] }}
                                        </td>
                                        <td>{{ $user['type'] }}</td>
                                        <td style="font-size: 30px">
                                            <center>
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="user" recordid="{{$user['id']}}" title="Xóa người dùng"><i class="fa fa-trash"></i></a>
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