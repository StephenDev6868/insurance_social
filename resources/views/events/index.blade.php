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
          <li class="breadcrumb-item"><a href="javaScript:void();">Sự kiện</a></li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý Sự kiện</li>
        </ol>
      </div>
      <div class="col-sm-5">
        <div class="btn-group float-sm-right">
          <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="events"><i class="fa fa-minus mr-1"></i>Xóa
            Mục Chọn</button>
          <a role="button" href="{{ url('admin/create/event') }}" class="btn btn-light waves-effect waves-light"><i class="fa fa-plus mr-1"></i>
            Tạo Sự Kiện</a>

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
                    <th>Thời gian diễn ra</th>
                    <th>Tình Trạng</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($events as $key => $event)
                  <tr>
                    <td><input type="checkbox" value="{{$event['id']}}" class="sub_ck" data-id="{{$event['id']}}"></td>
                    <td>{{ ++$key }}</td>
                    <td> <img data-original="{{$event['image']}}" width="100px" height="100px"></td>
                    <td>
                      {{ $event['title'] }}
                    </td>
                    <td>{{ date('d/m/Y', strtotime($event['date'])) }}</td>
                    <td style="font-size: 30px">
                      <center>
                        <a href="{{ url('admin/edit/event/' . $event['id']) }}" style="color:greenyellow" title="Chỉnh sửa sự kiện"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="event" recordid="{{$event['id']}}" title="Xóa sự kiện"><i class="fa fa-trash"></i></a>
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