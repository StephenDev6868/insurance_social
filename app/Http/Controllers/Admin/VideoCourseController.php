<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse;
use RealRashid\SweetAlert\Facades\Alert;
class VideoCourseController extends Controller
{
    public function index(Request $request, $id){
        $videos=VideoCourse::where('course_id', $id)->get();
        return View('courses.video', compact('videos', 'id'));
    }
    public function create(Request $request, $id){
        $data=$request->all();
        $data['course_id']=$id;
        VideoCourse::create($data);
        ALert::success('Thành công', 'Tạo Video Thành Công');
        return redirect()->back();
    }
    public function edit(Request $request, $id){
        $video=VideoCourse::find($id);
        $data=$request->all();
        $video->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Video Thành Công');
        return redirect()->back();
    }
    public function delete(Request $request, $id){
        VideoCourse::find($id)->delete();
        ALert::success('Thành công', 'Xóa Video Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        VideoCourse::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
