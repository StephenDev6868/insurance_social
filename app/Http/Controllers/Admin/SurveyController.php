<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Banner;
class SurveyController extends Controller
{
    public function index(){
        $surveys=Survey::all();
        $banner=Banner::first();
        return view('surveys.index', compact('surveys', 'banner'));
    }
    public function create(Request $request){
        $data=$request->all();
        Survey::create($data);
        ALert::success('Thành công', 'Tạo Khảo Sát Thành Công');
        return redirect()->back();
    }
    public function edit(Request $request, $id){
        $survey=Survey::find($id);
        $data=$request->all();
        $survey->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Khảo Sát Thành Công');
        return redirect()->back();
    }
    public function delete(Request $request, $id){
        Survey::find($id)->delete();
        ALert::success('Thành công', 'Xóa Khảo Sát Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        Survey::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
