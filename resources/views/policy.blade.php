@extends('layouts.create_edit')
@section('content')
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Cập Nhật</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Cấu Hình</a></li>
          <li class="breadcrumb-item active" aria-current="page">Điều Khoản Chính Sách</li>
        </ol>
      </div>

    </div>

    @include('sweetalert::alert')
    <!-- End Breadcrumb-->
    <form action="{{ url('admin/policy') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header text-uppercase">Các Dữ Liệu Về Điều Khoản Chính Sách</div>
            <div class="card-body">
              <label>Mô Tả</label>
              <textarea id="editor" name="description">{{$policy['description']}}</textarea>

              <hr>
              <button type="submit" class="btn btn-gradient-primary">Cập Nhật</button>
            </div>
          </div>
        </div>
      </div>
      <!--End Row-->
      <!--End Row-->


    </form>


    <!--End Row-->



    <!--End Row-->
    <!--start overlay-->
    <div class="overlay"></div>
    <!--end overlay-->
  </div>
  <!-- End container-fluid-->

</div>
@endsection