@extends('layouts.create_edit')
@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Chỉnh Sửa</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="javaScript:void();">Cấu Hình</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Sách</li>
                </ol>
            </div>

        </div>
        @include('sweetalert::alert')
        <!-- End Breadcrumb-->
        <form action="{{ url('admin/edit/book', $book['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-uppercase">Các Dữ Liệu Sách</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiêu Đề</label>
                                    <input type="text" name="title" value="{{$book['title']}}" required class="form-control">
                                </div>
                                <div class="col-6">
                                    <label>Loại Sách</label>
                                    <select class="form-control type-book" name="type" required>
                                        @if($book['type'] == 1)
                                        <option value="1" selected>PDF</option>
                                        <option value="0">Giấy</option>
                                        @else
                                        <option value="1">PDF</option>
                                        <option value="0" selected>Giấy</option>
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
                                <input id="thumbnail2" class="form-control" type="text" value="{{$book['image']}}" name="image" readonly required>
                            </div>
                            <div id="holder2">
                                <img data-original="{{$book['image']}}" width="100px" height="100px">

                            </div>
                            <hr>
                            <label>Mô Tả</label>
                            <textarea id="editor" name="description" required>{{$book['description']}}</textarea>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiền (VND)</label>
                                    <input type="number" min="1" value="{{$book['price']}}" class="form-control price_original" required name="price">
                                </div>
                                <div class="col-6">
                                    <label>Tiền sau giảm giá (VND)</label>
                                    <input type="number" readonly value="{{$book['price_reduce']}}" min="1" class="form-control price_reduce" name="price_reduce">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tiền (Xu)</label>
                                    <input type="number" min="1" value="{{$book['coin']}}" class="form-control coin_original" required name="coin">
                                </div>
                                <div class="col-6">
                                    <label>Tiền sau giảm giá (Xu)</label>
                                    <input type="number" min="1" value="{{$book['coin_reduce']}}" class="form-control coin_reduce" readonly name="coin_reduce">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label>Giảm giá (%)</label>
                                    <input type="text" class="form-control discount" value="{{$book['discount']}}" name="discount">
                                </div>
                                <div class="col-6">
                                    <label>Danh Mục</label>
                                    <select class="form-control single-select" name="category_id" required>
                                        @foreach($categories as $category)
                                        @if($book['category_id']==$category['id'])
                                        <option value="{{ $category['id'] }}" selected>{{ $category['name'] }}</option>
                                        @else
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="change-type-book">
                                @if($book['type']==0)
                                <div class="row">
                                    <div class="col-4">
                                        <label>Kích thước</label>
                                        <input type="text" class="form-control" name="size" value="{{$book['size']}}">
                                    </div>
                                    <div class="col-4">
                                        <label>Loại bìa</label>
                                        <input type="text" class="form-control" name="cover_type" value="{{$book['cover_type']}}">
                                    </div>
                                    <div class="col-4">
                                        <label>Số trang</label>
                                        <input type="number" min="1" class="form-control" value="{{$book['page']}}" name="page">
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Nhà xuất bản</label>
                                        <input type="text" class="form-control" name="publish_company" value="{{$book['publish_company']}}">
                                    </div>
                                    <div class="col-6">
                                        <label>Năm xuất bản</label>
                                        <input type="number" min="1000" max="9999" class="form-control" value="{{$book['publish_year']}}" name="publish_year">
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