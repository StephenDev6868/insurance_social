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
                    <li class="breadcrumb-item active" aria-current="page">Tạo Câu Hỏi</li>
                </ol>
            </div>

        </div>
        @include('sweetalert::alert')
        <!-- End Breadcrumb-->
        <form action="{{ url('admin/create/question/survey/'.$id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-uppercase">Các Dữ Liệu Câu Hỏi</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label>Câu hỏi</label>
                                    <input type="text" name="question" required class="form-control">
                                </div>
                                <div class="col-6">
                                    <label>Loại câu hỏi</label>
                                    <select name="type" required class="form-control type-question">
                                        <option value="0" selected>Trắc nghiệm</option>
                                        <option value="1" >Tự luận</option>
                                    </select>
                                </div>
                            </div>
                            
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
                            <div class="change-type-question">
                                <div class="row">
                                    <div class="col-11">
                                        <label>Câu Trả Lời</label>
                                        <input type="text" required name="answer[]" class="form-control" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-11">
                                        <label>Câu Trả Lời</label>
                                        <input type="text" required name="answer[]" class="form-control" required>
                                    </div>
                                    <div class="col-1">
                                        <a href="javascript:void(0)" style="position: relative;top:40%" class="create-question"><i class="fa fa-3x fa-plus-circle"></i></a>
                                    </div>
                                </div>
                                <hr>
                                <div id="new-question">

                                </div>
                            </div>
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