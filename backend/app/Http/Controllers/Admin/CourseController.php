<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Banner;
use App\Models\Category;
class CourseController extends Controller
{

  public function index(Request $request)
  {
    $courses = Course::all();
    $banner = Banner::first();
    return View('courses.index', compact('courses', 'banner'));
  }
  public function create(Request $request)
  {
    $categories=Category::all();
    $course_categories=CourseCategory::all();
    if ($request->isMethod('POST')) {
      $data = $request->all();
      // dd($data);
      $validator = Validator::make($data, [
        'image.*' => 'image|mimes:jpeg,jpg,png',
      ]);
      if ($validator->fails()) {
        ALert::error('Lỗi', $validator->errors()->first());
        return redirect()->back();
      } else {
        if(count(Category::where('id',$data['category_id'])->get())==0){
          $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
          $data['category_id']=$category['id'];
        }
        $data['admin_id'] = Auth::guard('admin')->user()->id;
        $data['admin_name'] = Auth::guard('admin')->user()->name;
        if (isset($data['image'])) {
          Course::create($data);
          ALert::success('Thành công', 'Tạo Thành Công Khóa Học');
          return redirect('/admin/courses');
        } else {
          ALert::error('Lỗi', 'Thiếu Ảnh');
          return redirect()->back();
        }
      }
    }
    return view('courses.create', compact('course_categories'));
  }
  public function edit(Request $request, $id)
  {
    $course = Course::find($id);
    $categories=Category::all();
    $course_categories=CourseCategory::all();
    if ($request->isMethod('POST')) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'image.*' => 'image|mimes:jpeg,jpg,png',
      ]);
      if ($validator->fails()) {
        ALert::error('Lỗi', $validator->errors()->first());
        return redirect()->back();
      } else {

        if(count(Category::where('id',$data['category_id'])->get())==0){
          $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
          $data['category_id']=$category['id'];
        }
        $data['admin_id'] = Auth::guard('admin')->user()->id;
        $data['admin_name'] = Auth::guard('admin')->user()->name;
        if (isset($data['image'])) {
          $course->update($data);
          ALert::success('Thành công', 'Chỉnh Sửa Thành Công Khóa Học');
          return redirect('/admin/courses');
        } else {
          ALert::error('Lỗi', 'Thiếu Ảnh');
          return redirect()->back();
        }
      }
    }
    return view('courses.edit', compact('course', 'course_categories'));

  }
  public function delete(Request $request, $id)
  {
    Course::find($id)->delete();
    ALert::success('Thành công', 'Xóa Khóa Học Thành Công');
    return redirect()->back();
  }
  public function deleteAll(Request $request)
  {
    $data = $request->all();
    Course::whereIn('id', explode(",", $data['ids']))->delete();
    return response()->json(['status' => true]);
  }
}
