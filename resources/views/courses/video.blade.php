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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Video</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý Video</li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="video-books"><i class="fa fa-minus mr-1"></i>Xóa
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
                        <h5 class="modal-title" id="exampleModalLabel">Tạo Video</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/admin/create/video/course/'.$id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                <input type="text" name="title" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Video:</label>

                                <div class="input-group">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-file-video-o"></i> Choose Video
                                    </a>
                                    <input id="thumbnail" class="form-control" type="text" name="video" readonly>
                                </div>
                                <div id="holder"></div>
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
                    <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Video</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="select-all"></th>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Video</th>
                                        <th>Kiểm tra</th>
                                        <th>Tình Trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $key => $video)
                                    <div class="modal fade" id="exampleModal{{$video['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content" style="background-color:#007bff;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Video</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/edit/video/'.$video['id'])}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                                                            <input type="text" name="title" value="{{$video['title']}}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Video:</label>

                                                            <div class="input-group">
                                                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary text-white">
                                                                    <i class="fa fa-file-video-o"></i> Choose Video
                                                                </a>
                                                                <input id="thumbnail2" class="form-control" type="text" value="{{$video['video']}}" name="video" readonly>
                                                                <div id="holder2"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Kiểm tra:</label>
                                                            <select class="form-control" name="check" required>
                                                                @if($video['check']==0)
                                                                <option value="0" selected>Khóa</option>
                                                                <option value="1">Mở</option>
                                                                @else
                                                                <option value="0">Khóa</option>
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
                                        <td><input type="checkbox" value="{{$video['id']}}" class="sub_ck" data-id="{{$video['id']}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $video['title'] }}
                                        </td>
                                        <td>
                                            <video width="300" height="200" controls>
                                                <source src="{{$video['video']}}" type="video/mp4">
                                            </video>
                                        </td>
                                        <td>
                                            @if($video['check']==0)
                                            Khóa
                                            @else
                                            Mở
                                            @endif
                                        </td>
                                        <td style="font-size: 30px">
                                            <center>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal{{$video['id']}}" style="color:greenyellow" title="Chỉnh sửa Video"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="video" recordid="{{$video['id']}}" title="Xóa Video"><i class="fa fa-trash"></i></a>
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