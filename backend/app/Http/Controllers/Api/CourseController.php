<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(){
        $courses=Course::with('courseVideo')->get();
        foreach($courses as $course){
            $course['description']=html_entity_decode($course['description']);
        }
        return response()->json(['statusCode'=>200, 'data'=>['courses'=>$courses]]);
    }
    public function buyCourse(Request $request){
        $data=$request->all();
        if(Auth::check()){
            $data['user_id']=Auth::user()->id;
            $data['status'] = 1;
            CourseUser::create($data);
            return response()->json(['statusCode'=>200, 'message'=>'Thêm giỏ hàng thành công']);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Bạn cần đăng nhập tài khoản để thực hiện chức năng này']);
        }
    }

    public function typeCourse(Request $request){
        $data=$request->all();
        $courses=Course::where('type',$data['type'])->get();
        $courses_new=array();
        foreach($courses as $course){
            array_push($courses_new, ['admin_name'=>Admin::find($course['admin_id'])->name, 'course_image'=>$course['image'], 'admin_image'=>Admin::find($course['admin_id'])->image,  'sold'=>$course['sold'], 'opening_date'=>date('d/m/Y', strtotime($course['opening_date'])), 'title'=>$course['title'], 'type'=>$course['type']]);
        }
        return response()->json(['statusCode'=>200, 'data'=>['courses'=>$courses_new]]);
    }

    public function list(Request $request)
    {
        $userInfo = Auth::user();
        return Course::query()
            ->where('creator_id', $userInfo->id)
            ->get()
            ->toArray();
    }

    public function detail(Course $course, Request $request){
        return response()->json(['statusCode'=>200, 'data'=>['course'=>$course]]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
        } else {
            if (count(Category::where('id', $data['category_id'])->get()) == 0) {
                $category = Category::create(['name' => ucfirst(strtolower($data['category_id']))]);
                $data['category_id'] = $category['id'];
            }
            $data['creator_id'] = Auth::guard('api')->user()->id;
            $data['creator_name'] = Auth::guard('api')->user()->name;
            if (isset($data['image'])) {
                Course::create($data);
            } else {
                return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
            }
        }
        return response()->json(['statusCode' => 200, 'message' => 'Tạo khoá học thành công']);
    }

    public function edit(Request $request, $id)
    {
        $course = Course::find($id);
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'image.*' => 'image|mimes:jpeg,jpg,png',
            ]);
            if ($validator->fails()) {
                return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
            } else {
                if(count(Category::where('id',$data['category_id'])->get())==0){
                    $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
                    $data['category_id']=$category['id'];
                }
                $data['creator_id'] = Auth::guard('user')->user()->id;
                $data['creator_name'] = Auth::guard('user')->user()->name;
                if (isset($data['image'])) {
                    $course->update($data);
                    return response()->json(['statusCode' => 200, 'message' => 'Chỉnh Sửa Thành Công Khóa Học']);
                } else {
                    return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
                }
            }
        }
        return response()->json(['statusCode'=>200, 'message' => 'Cập nhập khoá học thành công']);
    }

    public function delete(Course $course)
    {
        try {
            $course->delete();
            return response()->json(['statusCode'=>200, 'message' => 'Xoá khoá học thành công']);
        } catch (\Exception $exception) {
            return response()->json(['statusCode'=>400, 'message' => 'Xoá khoá học không thành công']);
        }



    }
}
