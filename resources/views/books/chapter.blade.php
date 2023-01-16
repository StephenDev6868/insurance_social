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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Chương Sách</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý chương sách</li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="chapter-books"><i class="fa fa-minus mr-1"></i>Xóa
                        Mục Chọn</button>
                    <a role="button" class="btn btn-light waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Tạo</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:#007bff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo chương sách</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/create/chapter/book/'.$id)}}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                <input type="text" name="title" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Mô tả:</label>
                                <textarea class="form-control" name="description" id="editor"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Kiểm tra:</label>
                                <select class="form-control" name="check" required> 
                                    <option value="0" selected>Khóa</option>
                                    <option value="1">Mở</option>
                                </select>
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
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Chương Sách</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Kiểm tra</th>
                                        <th>Tình Trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chapters as $key => $chapter)
                                    <div class="modal fade" id="exampleModal{{$chapter['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content" style="background-color:#007bff;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật chương sách</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/edit/chapter/'.$chapter['id'])}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                                            <input type="text" name="title" value="{{$chapter['title']}}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Mô tả:</label>
                                                            <textarea class="form-control" name="description" id="editor1">{{$chapter['description']}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Kiểm tra:</label>
                                                            <select class="form-control" name="check" required> 
                                                                @if($chapter['check']==0)
                                                                <option value="0" selected>Khóa</option>
                                                                <option value="1">Mở</option>
                                                                @else
                                                                <option value="0" >Khóa</option>
                                                                <option value="1" selected>Mở</option>
                                                                @endif
                                                            </select>
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
                                        <td><input type="checkbox" value="{{$chapter['id']}}" class="sub_ck" data-id="{{$chapter['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $chapter['title'] }}
                                        </td>
                                        <td>
                                            {!! $chapter['description'] !!}
                                        </td>
                                        <td>
                                            @if($chapter['check']==0)
                                                Khóa
                                            @else
                                                Mở
                                            @endif
                                        </td>
                                        <td style="font-size: 30px">
                                            <center>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal{{$chapter['id']}}" style="color:greenyellow" title="Chỉnh sửa chương sách"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="chapter" recordid="{{$chapter['id']}}" title="Xóa chương sách"><i class="fa fa-trash"></i></a>
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