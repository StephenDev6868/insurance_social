@extends('layouts.table')
@section('content')

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-7">
        <h4 class="page-title">Dữ Liệu Bảng</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Khóa học</a></li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý khóa học</li>
        </ol>
      </div>
      <div class="col-sm-5">
        <div class="btn-group float-sm-right">
          <a role="button" class="btn btn-behance waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
            Cập Nhật Ảnh Khóa Học</a>
          <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="courses"><i class="fa fa-minus mr-1"></i>Xóa
            Mục Chọn</button>
          <a role="button" href="{{ url('admin/create/course') }}" class="btn btn-light waves-effect waves-light"><i class="fa fa-plus mr-1"></i>
            Tạo Khóa Học</a>

        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#007bff;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Ảnh Khóa Học</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{url('/admin/banner')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">

              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tên Tiêu Đề:</label>
                <input type="text" class="form-control" value="{{$banner['course_text']}}" name="course_text" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Ảnh Khóa Học</label>
                <div class="input-group">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fa fa-picture-o"></i> Choose Image
                  </a>
                  <input id="thumbnail" class="form-control" value="{{$banner['course_image']}}" type="text" name="course_image" readonly required>
                </div>
                <div id="holder">
                  <input type="image" src="{{$banner['course_image']}}" width="100px" height="100px">
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
          <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Khóa Học</div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-bordered">
                <thead>
                  <tr>
                    <th><input type="checkbox" class="select-all"></th>
                    <th>#</th>

                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Số lượng bán</th>
                    <th>Loại khóa học</th>
                    <th>Ngày tạo</th>
                    <td style="display: none;">Mô tả</td>
                    <td style="display: none;">Tên người đăng</td>
                    <td style="display: none;">Lượt xem</td>
                    <td style="display: none;">Giảm giá</td>
                    <td style="display: none;">Giá gốc</td>
                    <td style="display: none;">Xu gốc</td>
                    <td style="display: none;">Giá được giảm</td>
                    <td style="display: none;">Xu được giảm</td>
                    <th>Tình Trạng</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($courses as $key => $course)
                  <tr>
                    <td><input type="checkbox" value="{{$course['id']}}" class="sub_ck" data-id="{{$course['id']}}"></td>
                    <td>{{ ++$key }}</td>
                    <td> <img data-original="{{$course['image']}}" width="100px" height="100px"></td>
                    <td>
                      {{ $course['title'] }}
                    </td>


                    <td>{{ $course['sold'] }} đã bán</td>
                    <td>@if($course['type']==0)
                            Offline-Meet
                        @else
                            Online-Video
                        @endif
                    </td>
                    <td>{{ date('d/m/Y', strtotime($course['created_at'])) }}</td>
                    <td style="display: none;">{!!$course['description']!!}</td>
                    <td style="display: none;">{{$course['admin_name']}}</td>
                    <td style="display: none;">{{$course['view']}}</td>
                    <td style="display: none;">{{$course['discount']}}</td>
                    <td style="display: none;">{{$course['price']}}</td>
                    <td style="display: none;">{{$course['coin']}}</td>
                    <td style="display: none;">{{$course['price_reduce']}}</td>
                    <td style="display: none;">{{$course['coin_reduce']}}</td>
                    <td style="font-size: 30px">
                      <center>
                        @if($course['type']==1)
                      <a href="{{ url('admin/videos/course/' . $course['id']) }}" style="color:aqua"
                          title="Xem các video"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                          @endif
                        <a href="{{ url('admin/edit/course/' . $course['id']) }}" style="color:greenyellow" title="Chỉnh sửa khóa học"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="course" recordid="{{$course['id']}}" title="Xóa khóa học"><i class="fa fa-trash"></i></a>
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