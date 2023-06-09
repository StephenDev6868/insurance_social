@extends('layouts.create_edit')
@section('content')
<?php

use Carbon\Carbon;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Chỉnh Sửa</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="javaScript:void();">Cấu Hình</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Khóa Học</li>
                </ol>
            </div>

        </div>
        @include('sweetalert::alert')
        <!-- End Breadcrumb-->
        <form action="{{ url('admin/edit/course', $course['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-uppercase">Các Dữ Liệu Khóa Học</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiêu Đề</label>
                                    <input type="text" value="{{$course['title']}}" name="title" required class="form-control">
                                </div>
                                <div class="col-6">
                                    <label>Loại Khóa Học</label>
                                    <select class="form-control type-course" name="type" required>
                                        @if($course['type'] == 1)
                                        <option value="1" selected>Online-Video</option>
                                        <option value="0">Offline-Meet</option>
                                        @else
                                        <option value="1">Online-Video</option>
                                        <option value="0" selected>Offline-Meet</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <label>Ảnh</label>
                            <div class="input-group">
                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary text-white">
                                    <i class="fa fa-picture-o"></i> Choose Image
                                </a>
                                <input id="thumbnail2" class="form-control" value="{{$course['image']}}" type="text" name="image" readonly required>
                            </div>
                            <div id="holder2">
                                <img data-original="{{$course['image']}}" width="100px" height="100px">
                            </div>
                            <hr>
                            <label>Mô Tả</label>
                            <textarea id="editor" name="description" required>{!!$course['description']!!}</textarea>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiền (VND)</label>
                                    <input type="number" min="1" value="{{$course['price']}}" class="form-control price_original" required name="price">
                                </div>
                                <div class="col-6">
                                    <label>Tiền sau giảm giá (VND)</label>
                                    <input type="number" readonly value="{{$course['price_reduce']}}" min="1" class="form-control price_reduce" name="price_reduce">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiền (Xu)</label>
                                    <input type="number" min="1" value="{{$course['coin']}}" class="form-control coin_original" required name="coin">
                                </div>
                                <div class="col-6">
                                    <label>Tiền sau giảm giá (Xu)</label>
                                    <input type="number" min="1" value="{{$course['coin_reduce']}}" class="form-control coin_reduce" readonly name="coin_reduce">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Giảm giá (%)</label>
                                    <input type="text" class="form-control discount" name="discount" value="{{$course['discount']}}">
                                </div>
                                <div class="col-6">
                                    <label>Danh Mục</label>
                                    <select class="form-control single-select" name="category_id" required>
                                        @foreach($course_categories as $category)
                                        @if($course['category_id']==$category['id'])
                                        <option value="{{ $category['id'] }}" selected>{{ $category['name'] }}</option>
                                        @else
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <label>Admin phê duyệt</label>
                                    <select name="status" required class="form-control type-question">
                                        <option value="0" {{ $course['status'] == 0 ? 'selected' : '' }}>Đang chờ phê duyệt</option>
                                        <option value="1" {{ $course['status'] == 1 ? 'selected' : '' }}>Chấp nhận</option>
                                        <option value="2" {{ $course['status'] == 2 ? 'selected' : '' }}>Từ chối</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="change-type-course">
                                @if($course['type'] == 0)
                                <div class="row">
                                    <div class="col-6">
                                        <label>Ngày khai giảng</label>
                                        <input type="datetime-local" class="form-control" name="opening_date" value="{{$course['opening_date']}}" required>
                                    </div>
                                    <div class="col-6">
                                        <label>Ứng dụng</label>
                                        <input type="text" class="form-control" name="application" value="{{$course['application']}}" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Mật khẩu</label>
                                        <input type="text" class="form-control" name="password" value="{{$course['password']}}" required>
                                    </div>
                                    <div class="col-6">
                                        <label>Link học</label>
                                        <input type="text" class="form-control" name="link" value="{{$course['link']}}" required>
                                    </div>
                                </div>
                                <hr>
                                @endif
                            </div>
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
