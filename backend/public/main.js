$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select-all').click(function () {
        if (this.checked == true) {
            $('input[type="checkbox"]').prop('checked', true);
        } else {
            $('input[type="checkbox"]').prop('checked', false);
        }
    });
    $(".delete-all").click(function () {
        var allVals = [];
        $(".sub_ck:checked").each(function () {
            allVals.push($(this).attr("data-id"));
        });
        if (allVals.length <= 0) {
            alert("Chọn cột cần xóa");
        } else {
            var record = $(this).attr("record");
            Swal.fire({
                title: "Bạn có chắc xóa các dữ liệu đã chọn?",
                text: "Bạn sẽ không thể khôi phục dữ liệu!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Đồng ý xóa!",
            }).then((result) => {
                if (result.isConfirmed) {
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: "/admin/delete-all/" + record,
                        type: "GET",
                        data: {
                            ids: join_selected_values,
                        },
                        success: function (resp) {
                            if (resp["status"] === true) {
                                $(".sub_ck:checked").each(function () {
                                    $(this).parents("tr").remove();
                                    window.location.reload();
                                });
                            }
                        },
                        error: function () {
                            alert("ERROR");
                        },
                    });
                }
            });
        }
    });
    $(".confirmdelete").click(function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Bạn có chắc?",
            text: "Bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng ý xóa!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    "/admin/delete/" + record + "/" + recordid;
            }
        });
    });
    $('.discount').keyup(function () {
        var discount = $(this).val();
        var coin = $('.coin_original').val();
        var price = $('.price_original').val();
        if (discount > 100 || discount < 0) {
            alert('Giảm giá quá lớn hoặc quá thấp mức cho phép')
        } else {
            $('.coin_reduce').val(parseInt(coin) * (100 - parseFloat(discount)) / 100);
            $('.price_reduce').val(parseInt(price) * (100 - parseFloat(discount)) / 100);
        }
    });
    $('.create-question').click(function () {
        $('#new-question').append(
            `<div class="newcreate">
                <div class="row">
                    <div class="col-11">
                        <label>Câu Trả Lời</label>
                        <input type="text" required name="answer[]" class="form-control">
                    </div>
                    <div class="col-1">
                        <a href="javascript:void(0)" style="position: relative;top:40%" class="minus-question"><i class="fa fa-3x fa-minus-circle"></i></a>
                    </div>
                </div>
                <hr>
            </div>`
        );
        $('.minus-question').click(function () {
            $(this).closest('.newcreate').remove();
        });
    });
    $('.minus-question').click(function () {
        $(this).closest('.newcreate').remove();
    });
    $('.type-question').change(function () {
        var type = $(this).val();
        if (type == 1) {
            $('.change-type-question').html('');
        } else {
            $('.change-type-question').html(
                `
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
                `
            );
        }
        $('.create-question').click(function () {
            $('#new-question').append(
                `<div class="newcreate">
                    <div class="row">
                        <div class="col-11">
                            <label>Câu Trả Lời</label>
                            <input type="text" required name="answer[]" class="form-control">
                        </div>
                        <div class="col-1">
                            <a href="javascript:void(0)" style="position: relative;top:40%" class="minus-question"><i class="fa fa-3x fa-minus-circle"></i></a>
                        </div>
                    </div>
                    <hr>
                </div>`
            );
            $('.minus-question').click(function () {
                $(this).closest('.newcreate').remove();
            });
        });
    });
    $('.type-course').change(function () {
        var type = $(this).val();
        if (type == 1) {
            $('.change-type-course').html(``);
        }else{
            $('.change-type-course').html(`
            <div class="row">
            <div class="col-6">
                <label>Ngày khai giảng</label>
                <input type="datetime-local" class="form-control" name="opening_date" required value="{{Carbon::now()}}">
            </div>
            <div class="col-6">
                <label>Ứng dụng</label>
                <input type="text" class="form-control" name="application" required>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <label>Mật khẩu</label>
                <input type="text" class="form-control" name="password" required>
            </div>
            <div class="col-6">
                <label>Link Học</label>
                <input type="text" class="form-control" name="link" required>
            </div>
        </div>
        <hr>
            `);
        }

    });
    $('.type-book').change(function(){
        var type = $(this).val();
        if (type == 1) {
            $('.change-type-book').html(``);
        }else{
            $('.change-type-book').html(`
            <div class="row">
            <div class="col-4">
                <label>Kích thước</label>
                <input type="text" class="form-control" name="size" required>
            </div>
            <div class="col-4">
                <label>Loại bìa</label>
                <input type="text" class="form-control" name="cover_type" required>
            </div>
            <div class="col-4">
                <label>Số trang</label>
                <input type="number" min="1" class="form-control" name="page" required>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-6">
                <label>Nhà xuất bản</label>
                <input type="text" class="form-control" name="publish_company" required>
            </div>
            <div class="col-6">
                <label>Năm xuất bản</label>
                <input type="number" min="1000" max="9999" class="form-control" name="publish_year" required>
            </div>
        </div>
        <hr>
            `);
        }
    })
    document.addEventListener("DOMContentLoaded", function () {
        var lazyloadImages = document.querySelectorAll("img.lazy");
        var lazyloadThrottleTimeout;

        function lazyload() {
            if (lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }

            lazyloadThrottleTimeout = setTimeout(function () {
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function (img) {
                    if (img.offsetTop < (window.innerHeight + scrollTop)) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if (lazyloadImages.length == 0) {
                    document.removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }

        document.addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
    });
});
