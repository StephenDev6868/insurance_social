<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
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
            CourseUser::create($data);
            return response()->json(['statusCode'=>200, 'message'=>'Thêm giỏ hàng thành công']);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Bạn cần đăng nhập tài khoản để thực hiện chức năng này']);
        }
    }
    public function detail(Request $request){
        $data=$request->all();
        $course=Course::with('courseVideo')->find($data['id']);
        $course['admin_image']=Admin::find($course['admin_id'])->image;
        $course['description']=html_entity_decode($course['description']);
        return response()->json(['statusCode'=>200, 'data'=>['course'=>$course]]);
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
}
