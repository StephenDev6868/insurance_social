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
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa User</li>
                    </ol>
                </div>

            </div>
{{--            @include('sweetalert::alert')--}}
            <!-- End Breadcrumb-->
            <form action="{{ url('admin/edit/user/check', $user['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-uppercase">Các Dữ Liệu User</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Tên</label>
                                        <input type="text" value="{{$user->name}}" class="form-control" required name="name" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label>Số điện thoại</label>
                                        <input type="text" min="1" value="{{$user->mobile}}" class="form-control" readonly name="mobile">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" readonly value="{{$user['email']}}">
                                    </div>
                                    <div class="col-6">
                                        <label>Địa chỉ</label>
                                        <input type="email" class="form-control" name="address" readonly value="{{$user['address']}}">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Loại tài khoản</label>
                                        @if($user->type == 1)
                                            <input type="text" value="Tài khoản thường" class="form-control" required name="type" readonly>
                                        @elseif($user->type == 2)
                                            <input type="text" value="Tài khoản chuyên gia" class="form-control" required name="type" readonly>
                                        @else
                                            <input type="text" value="Tài khoản đối tác" class="form-control" required name="type" readonly>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>Số điện thoại</label>
                                        <input type="text" min="1" value="{{$user->mobile}}" class="form-control" readonly name="mobile">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Số dư</label>
                                        <input type="text" min="1" value="{{$user->price}}" class="form-control" readonly name="price">
                                    </div>
                                    <div class="col-6">
                                        <label>Số coin</label>
                                        <input type="text" min="1" value="{{$user->coin}}" class="form-control" readonly name="coin">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Ảnh mặt trước cccd/cmnd</label>
                                        <img src="" alt="">
                                    </div>
                                    <div class="col-6">
                                        <label>Ảnh mặt sau cccd/cmnd</label>
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Link file chứng chỉ</label>
                                        <input type="text" value="" class="form-control" required name="type" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label>Xác nhận của admin</label>
                                        <select name="check" required class="form-control type-question">
                                            <option value="0" {{ $user->check == 0 ? 'selected' : '' }}>Từ chối</option>
                                            <option value="1" {{ $user->check == 1 ? 'selected' : '' }}>chấp nhận</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-gradient-primary mt-3">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="overlay"></div>
        </div>
        <!-- End container-fluid-->

    </div>
@endsection
