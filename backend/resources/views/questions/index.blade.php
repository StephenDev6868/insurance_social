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
          <li class="breadcrumb-item"><a href="javaScript:void();">Câu Hỏi</a></li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý Câu Hỏi</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <button type="submit" class="btn btn-facebook waves-effect waves-light delete-all" record="questions"><i class="fa fa-minus mr-1"></i>Xóa
            Mục Chọn</button>
          <a role="button" href="{{ url('admin/create/question/survey/'.$id) }}" class="btn btn-light waves-effect waves-light"><i
              class="fa fa-plus mr-1"></i>
            Tạo</a>
        </div>
      </div>
    </div>
    @include('sweetalert::alert')
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header"><i class="fa fa-table"></i> Dữ Liệu Bảng Câu Hỏi</div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-bordered">
                <thead>
                  <tr>
                    <th><input type="checkbox" class="select-all"></th>
                    <th>#</th>
                    <th>Câu Hỏi</th>
                    <th>Ngày tạo</th>
                    <th>Tình Trạng</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($questions as $key => $question)
                  <tr>
                    <td><input type="checkbox" value="{{$question['id']}}" class="sub_ck" data-id="{{$question['id']}}"></td>
                    <td>{{ ++$key }}</td>
                    <td> {{$question['question']}}</td>
                    <td>{{ date('d/m/Y', strtotime($question['created_at'])) }}</td>
                    <td style="font-size: 30px">
                      <center>
                        <a href="{{ url('admin/edit/question/' . $question['id'].'/survey/'.$id) }}" style="color:greenyellow"
                          title="Chỉnh sửa Câu Hỏi"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" style="color: red" class="confirmdelete" record="question" recordid="{{$question['id']}}"
                          title="Xóa Câu Hỏi"><i class="fa fa-trash"></i></a>
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