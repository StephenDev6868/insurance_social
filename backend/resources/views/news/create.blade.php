@extends('layouts.create_edit')
@section('content')
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Tạo</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Cấu Hình</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tạo Tin Tức</li>
        </ol>
      </div>

    </div>

    @include('sweetalert::alert')
    <!-- End Breadcrumb-->
    <form action="{{ url('admin/create/news') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header text-uppercase">Các Dữ Liệu Tin Tức</div>
            <div class="card-body">
              <label>Tiêu Đề</label>
              <input type="text" name="title" required class="form-control">
              <hr>
              <label>Ảnh</label>
              <div class="input-group">
                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary text-white">
                  <i class="fa fa-picture-o"></i> Choose Image
                </a>
                <input id="thumbnail2" class="form-control" type="text" name="image" readonly required>
              </div>
              <div id="holder2"></div>
              <hr>
              <label>Mô Tả</label>
              <textarea id="editor" name="description">
                                    </textarea>
              <hr>
              <label>Danh Mục</label>
              <select class="form-control single-select" name="category_id" required>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
              </select>
              <hr>
              <button type="submit" class="btn btn-gradient-primary">Tạo</button>
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