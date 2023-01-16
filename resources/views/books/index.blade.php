@extends('layouts.table')
@section('content')
<?php
use App\Models\BookChapter;
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-7">
        <h4 class="page-title">Dữ Liệu Bảng</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Sách</a></li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý sách</li>
        </ol>
      </div>
      <div class="col-sm-5">
        <div class="btn-group float-sm-right">
        <a role="button" class="btn btn-behance waves-effect waves-light" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus mr-1"></i>
                        Cập Nhật Ảnh Sách</a>
          <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="books"><i class="fa fa-minus mr-1"></i>Xóa
            Mục Chọn</button>
          <a role="button" href="{{ url('admin/create/book') }}" class="btn btn-light waves-effect waves-light"><i
              class="fa fa-plus mr-1"></i>
            Tạo</a>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#007bff;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Ảnh Sách</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{url('/admin/banner')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">

              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tên Tiêu Đề:</label>
                <input type="text" class="form-control" value="{{$banner['book_text']}}" name="book_text" required>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Ảnh Sách</label>
                <div class="input-group">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fa fa-picture-o"></i> Choose Image
                  </a>
                  <input id="thumbnail" class="form-control" value="{{$banner['book_image']}}" type="text" name="book_image" readonly required>
                </div>
                <div id="holder">
                  <input type="image" src="{{$banner['book_image']}}" width="100px" height="100px">
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
          <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Sách</div>
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
                    <th>Loại sách</th>
                    <td style="display: none;">Mô tả</td>
                    <td style="display: none;">Tên người đăng</td>
                    <td style="display: none;">Giảm giá</td>
                    <td style="display: none;">Giá gốc</td>
                    <td style="display: none;">Xu gốc</td>
                    <td style="display: none;">Giá được giảm</td>
                    <td style="display: none;">Xu được giảm</td>
                    <th>Tình Trạng</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($books as $key => $book)
                  <tr>
                    <td><input type="checkbox" value="{{$book['id']}}" class="sub_ck" data-id="{{$book['id']}}"></td>
                    <td>{{ ++$key }}</td>
                    <td> <img src="{{$book['image']}}" width="100px" height="100px"></td>
                    <td>
                      {{ $book['title'] }}
                    </td>
                    <td>{{ $book['sold'] }} đã bán</td>
                    <td>@if($book['type']==1) PDF
                      @else Giấy
                      @endif
                    </td>
                    <td style="display: none;">{!!$book['description']!!}</td>
                    <td style="display: none;">{{$book['admin_name']}}</td>
                    <td style="display: none;">{{$book['discount']}}</td>
                    <td style="display: none;">{{$book['price']}}</td>
                    <td style="display: none;">{{$book['coin']}}</td>
                    <td style="display: none;">{{$book['price_reduce']}}</td>
                    <td style="display: none;">{{$book['coin_reduce']}}</td>
                    <td style="font-size: 30px">
                      <center>
                        @if($book['type']==1)
                      <a href="{{ url('admin/chapters/book/' . $book['id']) }}" style="color:aqua"
                          title="Xem các chương sách"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                          @endif
                        <a href="{{ url('admin/edit/book/' . $book['id']) }}" style="color:greenyellow"
                          title="Chỉnh sửa sách"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="book" recordid="{{$book['id']}}"
                          title="Xóa sách"><i class="fa fa-trash"></i></a>
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